<?php

namespace App\Traits;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\PromotionDocument;
use App\Models\Tenant\PromotionDocumentCustomer;
use App\Models\Tenant\PromotionDocumentCustomerDetail;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * 
 */
trait PromotionDocumentTrait
{

    public function desactivePromotion($document)
    {
        try {
            $customer_id = $document->customer_id;
            $promotionCustomers = PromotionDocumentCustomer::where('customer_id', $customer_id)
                ->whereHas('promotion_document', function ($query) {
                    $query->whereColumn('promotion_document_customers.acc_total', 'promotion_documents.total');
                })
                ->get();

            foreach ($promotionCustomers as $promotionCustomer) {
                $promotionCustomer->active = 0;
                $promotionCustomer->save();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function savePromotion($document, $promotion_id)
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
