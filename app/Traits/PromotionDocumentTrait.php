<?php

namespace App\Traits;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\Item;
use App\Models\Tenant\PromotionDocument;
use App\Models\Tenant\PromotionDocumentCustomer;
use App\Models\Tenant\PromotionDocumentCustomerDetail;
use App\Models\Tenant\PromotionDocumentItem;
use App\Models\Tenant\PromotionReceived;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * 
 */
trait PromotionDocumentTrait
{
    public function updatePromotion($document)
    {
        $configuration = Configuration::first();
        if ($configuration->is_promotion_document) {
            $this->desactivePromotion($document);
        } else {
            $this->subtractPromotionPoints($document);
        }
    }
    function subtractPromotionPoints($document)
    {
        $customer_id = $document->customer_id;
        // Log inicial para diagnosticar llamadas a la resta de puntos
        try {
            Log::info('subtractPromotionPoints called', ['document_id' => $document->id, 'document_type_id' => $document->document_type_id, 'customer_id' => $customer_id]);
        } catch (\Exception $e) {
            // no bloquear ejecución por errores de logging
        }
        $promotion_customer = PromotionDocumentCustomer::where('customer_id', $customer_id)
            ->where('active', 1)
            ->whereHas('promotion_document', function ($query) {
                $query->where('is_points', true);
            })
            ->orderBy('id', 'desc')->first();
        if (!$promotion_customer) {
            try { Log::info('subtractPromotionPoints: no active promotion_customer found', ['customer_id' => $customer_id]); } catch (\Exception $e) {}
            return;
        }

        $promotion_document_id = $promotion_customer->promotion_document_id;
        $points_to_subtract = 0;
        $items = $document->items;
        foreach ($items as $item) {

            if (isset($item->item->is_promotion) && $item->item->is_promotion) {
                try {
                    Log::info('Promotion item detected in subtractPromotionPoints', ['document_id' => $document->id, 'document_type_id' => $document->document_type_id, 'item_id' => $item->item_id, 'quantity' => $item->quantity]);
                } catch (\Exception $e) {}
                $item_promotion = PromotionDocumentItem::where('item_id', $item->item_id)
                    ->whereHas('promotion_document', function ($query) use ($promotion_document_id) {
                        $query->where('is_points', true);
                    })
                    ->first();
                // Los puntos siempre deben ser enteros
                $points_to_subtract += intval($item_promotion->points_value);
                $this->savePromotionReceived($promotion_customer, $item->item_id, $item->quantity, $document);
            }
        }
        // Log antes de guardar los puntos actualizados
        try {
            Log::info('Saving promotion_customer points', ['promotion_customer_id' => $promotion_customer->id, 'points_to_subtract' => $points_to_subtract, 'points_before' => $promotion_customer->points]);
        } catch (\Exception $e) {}
        // Asegurar que los puntos siempre sean enteros
        $promotion_customer->points = intval($promotion_customer->points) - intval($points_to_subtract);
        $promotion_customer->save();
    }

    function savePromotionReceived($promotion_customer, $item_id, $quantity, $document)
    {
        $promotion_received = new PromotionReceived();
        $promotion_received->promotion_document_customer_id = $promotion_customer->id;
        $promotion_received->item_id = $item_id;
        $promotion_received->quantity = $quantity;
        $document_type_id = $document->document_type_id;
        if ($document_type_id == '80') {
            $promotion_received->sale_note_id = $document->id;
        } else {
            $promotion_received->document_id = $document->id;
        }
        try {
            Log::info('Creating PromotionReceived', ['promotion_document_customer_id' => $promotion_customer->id, 'item_id' => $item_id, 'quantity' => $quantity, 'document_type_id' => $document_type_id, 'document_id' => $document->id]);
        } catch (\Exception $e) {}
        $user = auth()->user();
        $promotion_received->user_id = $user->id;
        $promotion_received->save();
    }
    function desactivePromotion($document)
    {
        try {
            $customer_id = $document->customer_id;
            $promotionCustomer = PromotionDocumentCustomer::where('customer_id', $customer_id)
                ->whereHas('promotion_document', function ($query) {
                    $query->whereColumn('promotion_document_customers.acc_total', 'promotion_documents.total')
                        ->where('promotion_documents.is_points', false);
                })
                ->where('active', 1)
                ->first();

            if ($promotionCustomer) {
                $promotionCustomer->active = 0;
                $promotionCustomer->save();
                $promotionDocument = PromotionDocument::find($promotionCustomer->promotion_document_id);
                $items = PromotionDocumentItem::where('promotion_document_id', $promotionDocument->id)->get();
                foreach ($items as $item) {
                    $this->savePromotionReceived($promotionCustomer, $item->item_id, $item->quantity, $document);
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function getPromotionPoints($customer_id)
    {
        $promotion = PromotionDocumentCustomer::where('customer_id', $customer_id)->orderBy('id', 'desc')->first();
        return $promotion->points;
    }
    public function checkLimit($promotion_id, $customer_id)
    {
        $configuration = Configuration::first();
        if (!$configuration->promotions_by_points) return true;
        $promotion_document = PromotionDocument::find($promotion_id);
        $limit_changes = $promotion_document->limit_changes;
        $changes = PromotionReceived::whereHas('promotion_document_customer', function ($query) use ($promotion_id, $customer_id) {
            $query->where('promotion_document_id', $promotion_id)
                ->where('customer_id', $customer_id);
        });

        if ($configuration->promotions_by_points) {
            $changes = $changes->groupBy('item_id')
                ->selectRaw('item_id, count(*) as total')
                ->get()
                ->count();
        } else {
            $changes = $changes->distinct('promotion_document_customer_id')
                ->count('promotion_document_customer_id');
        }
        return $changes <= $limit_changes;
    }
    private function desactivePromotionCustomer($customer_id, $promotion_id)
    {
        $promotion_customer = PromotionDocumentCustomer::where('customer_id', $customer_id)
            ->where('promotion_document_id', $promotion_id)
            ->orderBy('id', 'desc')->first();
        if (!$promotion_customer) return;
        $promotion_customer->active = 0;
        $promotion_customer->save();
    }
    public function savePromotion($document, $promotion_id)
    {
        if (!$this->checkLimit($promotion_id, $document->customer_id)) {
            $this->desactivePromotionCustomer($document->customer_id, $promotion_id);
            return;
        }
        $configuration = Configuration::first();
        if ($configuration->is_promotion_document) {
            $this->savePromotionWithoutPoins($document, $promotion_id);
        } else {
            $this->savePromotionWithPoins($document, $promotion_id);
        }
    }
    private function savePromotionWithPoins($document, $promotion_id)
    {
        try {
            if (!$promotion_id) return;
            $configuration = Configuration::first();
            if (!$configuration->promotions_by_points) return;
            $document_type_id = $document->document_type_id;
            $customer_id = $document->customer_id;
            $promotion_document = PromotionDocument::find($promotion_id);
            $limit = $promotion_document->total;
            $points_value = $promotion_document->points_value;
            $document_total = $document->total;

            $promotion = PromotionDocumentCustomer::where('promotion_document_id', $promotion_id)
                ->where('active', 1)
                ->where('customer_id', $customer_id)
                ->orderBy('id', 'desc')
                ->first();

            if (!$promotion) {
                $promotion = $this->createPromotion($promotion_id, $customer_id, $document_total);
            } else {
                $promotion->acc_total += $document_total;
            }
            $this->createPromotionDetail($promotion->id, $document, $document_total, $document_type_id);
            // Asegurar que los puntos siempre sean enteros
            $calculatedPoints = $this->calculatePoints($document_total, $limit, $points_value);
            $promotion->points = intval($promotion->points) + intval($calculatedPoints);
            $promotion->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    /* function calculatePoints($total, $total_to_points, $points_value)
    {
        $points = ($total / $total_to_points) * $points_value;
        return $points;
    } */

    function calculatePoints($document_total, $limit, $points_value)
    {
        if ($limit <= 0) return 0; // evita división por cero

        $points = ($document_total / $limit) * $points_value;

        // 🔹 Toma solo la parte entera
        return floor($points);
    }
    private function savePromotionWithoutPoins($document, $promotion_id)
    {
        try {
            if (!$promotion_id) return;

            $configuration = Configuration::first();
            if (!$configuration->is_promotion_document) return;

            $document_type_id = $document->document_type_id;
            $customer_id = $document->customer_id;
            $promotion_document = PromotionDocument::find($promotion_id);
            $limit = $promotion_document->total;
            $total = $document->total;

            // Busca el último registro de promoción del cliente
            $promotion = PromotionDocumentCustomer::where('promotion_document_id', $promotion_id)
                ->where('active', 1)
                ->where('customer_id', $customer_id)
                ->orderBy('id', 'desc')
                ->first();

            // Procesar acumulado inicial si no existe un registro previo
            if (!$promotion) {
                $promotion = $this->createPromotion($promotion_id, $customer_id, min($total, $limit));
                $this->createPromotionDetail($promotion->id, $document, min($total, $limit), $document_type_id);
                $total -= min($total, $limit);
            } else {
                // Ajustar el acumulado existente
                $promotion_total = $promotion->acc_total;
                $remaining_limit = $limit - $promotion_total;
                $sum = min($total, $remaining_limit);

                $promotion->acc_total += $sum;
                $promotion->save();
                $this->createPromotionDetail($promotion->id, $document, $sum, $document_type_id);

                $total -= $sum;
            }

            // Crear registros adicionales si el total restante supera el límite
            while ($total > $limit) {
                $promotion = $this->createPromotion($promotion_id, $customer_id, $limit);
                $this->createPromotionDetail($promotion->id, $document, $limit, $document_type_id);
                $total -= $limit;
            }

            // Crear un último registro para el saldo restante, si queda algún monto
            if ($total > 0) {
                $promotion = $this->createPromotion($promotion_id, $customer_id, $total);
                $this->createPromotionDetail($promotion->id, $document, $total, $document_type_id);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
    private function createPromotion($promotion_id, $customer_id, $acc_total)
    {
        $promotion = new PromotionDocumentCustomer();
        $promotion->promotion_document_id = $promotion_id;
        $promotion->customer_id = $customer_id;
        $promotion->acc_total = $acc_total;
        $promotion->points = 0; // Inicializar puntos como entero
        $promotion->save();

        return $promotion;
    }

    private function createPromotionDetail($promotion_id, $document, $total, $document_type_id)
    {
        $promotionDetail = new PromotionDocumentCustomerDetail();
        $promotionDetail->promotion_customer_id = $promotion_id;

        if ($document_type_id == '80') {
            $promotionDetail->sale_note_id = $document->id;
        } else {
            $promotionDetail->document_id = $document->id;
        }

        $promotionDetail->total = $total;
        $promotionDetail->save();
    }
}
