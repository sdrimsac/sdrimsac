<?php

namespace Modules\Restobar\Events;

use Illuminate\Broadcasting\Channel;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Report\Exports\GananciaDiscountReportExport;
use Modules\Report\Exports\GananciaReportExport;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Item;
use Carbon\Carbon;
use Hyn\Tenancy\Environment;
use Illuminate\Support\Facades\Log;

class GenerateDiscountExcelReportJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $params;
    protected $user_id;

    public function __construct($params, $user_id)
    {
        $this->params = $params;
        $this->user_id = $user_id;
    }

    public function handle()
    {
        ini_set('max_execution_time', "3000");
        ini_set('memory_limit', '2048M');

        $sales_data = [];
        $total_utility = 0;
        $total_net_utility = 0;

        $date_start = $this->params['date_start'];
        $date_end = $this->params['date_end'];

        // Procesar documentos en chunks
        Document::whereNotIn('state_type_id', ['09', '11'])
            ->when($this->params['date_start'], function ($query) {
                return $this->params['date_end']
                    ? $query->whereBetween('date_of_issue', [$this->params['date_start'], $this->params['date_end']])
                    : $query->whereDate('date_of_issue', $this->params['date_start']);
            })
            ->when($this->params['establishment_id'], function ($query) {
                return $query->where('establishment_id', $this->params['establishment_id']);
            })
            ->chunk(100, function ($documents) use (&$sales_data, &$total_utility, &$total_net_utility) {
                foreach ($documents as $document) {
                    $this->processDocument($document, $sales_data, $total_utility, $total_net_utility);
                }
            });

        // Procesar notas de venta en chunks
        SaleNote::where('state_type_id', '<>', '11')
            ->when($this->params['date_start'], function ($query) {
                return $this->params['date_end']
                    ? $query->whereBetween('date_of_issue', [$this->params['date_start'], $this->params['date_end']])
                    : $query->whereDate('date_of_issue', $this->params['date_start']);
            })
            ->when($this->params['establishment_id'], function ($query) {
                return $query->where('establishment_id', $this->params['establishment_id']);
            })
            ->chunk(100, function ($sale_notes) use (&$sales_data, &$total_utility, &$total_net_utility) {
                foreach ($sale_notes as $sale_note) {
                    $this->processSaleNote($sale_note, $sales_data, $total_utility, $total_net_utility);
                }
            });

        $is_service = false;
        if ($this->params['item_id'] !== null) {
            $item = Item::findOrFail($this->params['item_id']);
            $is_service = $item->unit_type_id == "ZZ";
        }


        $export = new GananciaDiscountReportExport();
        $export->salesData($sales_data)
            ->company($this->params['company'])
            ->establishment($this->params['establishment'])
            ->dateStart($this->params['date_start'])
            ->dateEnd($this->params['date_end'])
            ->date_start($date_start)
            ->date_end($date_end)
            ->isService($is_service)
            ->totalUtility($total_utility)
            ->totalNetUtility($total_net_utility);


        $website = app(Environment::class)->tenant();
        $tenant_uuid = $website->uuid;

        $filename = $this->params['filename'];
        $tenant_path = "tenancy/tenants/{$tenant_uuid}/reports/discounts";
        $full_path = "{$tenant_path}/{$filename}";

        Storage::makeDirectory($tenant_path);

        Storage::put($full_path, Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX));
    }

    private function processDocument($document, &$sales_data, &$total_utility, &$total_net_utility)
    {
        $items_data = [];
        $document_total_utility = 0;
        $document_total_net_utility = 0;
        $sum_ganancia_global_igv = 0;
        $sum_ganancia_global_no_igv = 0;
        $sum_ganancia_global_exo = 0;
        $temp_items = [];

        foreach ($document->items as $item) {
            $unit_price = $item->unit_price;
            $quantity = $item->quantity;
            $purchase_unit_price = $item->relation_item->purchase_unit_price ?? 0;
            $item_discount = isset($item->total_discount) ? $item->total_discount : 0;
            $total_purchase = $purchase_unit_price * $quantity;
            $total_sale = $unit_price * $quantity;
            $utility = $total_sale - $total_purchase;
            $has_igv = isset($item->total_igv) && (float)$item->total_igv > 0;
            // Mejor detección de exonerados: por affectation_igv_type_id o total_igv casteado
            $is_exonerado = (
                (isset($item->affectation_igv_type_id) && $item->affectation_igv_type_id == '20') ||
                (isset($item->total_igv) && (float)$item->total_igv == 0)
            );
            $factor_igv = 1.18;
            $global_discount = isset($document->total_discount) ? $document->total_discount : 0;
            $total_venta_doc = $document->total ? $document->total : 0;
            $proporcion = $total_venta_doc > 0 ? ($unit_price * $quantity) / $total_venta_doc : 0;
            $global_discount_item = $global_discount * $proporcion;
            $descuento_item_final = $global_discount_item + ($has_igv ? $item_discount * $factor_igv : $item_discount);
            $ganancia_unidad_igv = $unit_price - $purchase_unit_price - ($has_igv ? $item_discount * $factor_igv / $quantity : $item_discount / $quantity);
            $ganancia_global_igv = $ganancia_unidad_igv * $quantity;
            $unit_price_no_igv = $has_igv ? $unit_price / $factor_igv : $unit_price;
            $purchase_unit_price_no_igv = $has_igv ? $purchase_unit_price / $factor_igv : $purchase_unit_price;
            $ganancia_unidad_no_igv = $unit_price_no_igv - $purchase_unit_price_no_igv - ($item_discount / $quantity);
            $ganancia_global_no_igv = $ganancia_unidad_no_igv * $quantity;
            // Ganancia exonerada solo si es exonerado
            $ganancia_unidad_exo = $is_exonerado ? $ganancia_unidad_no_igv : 0;
            $ganancia_global_exo = $is_exonerado ? $ganancia_global_no_igv : 0;
            $temp_items[] = [
                'description' => $item->item->description,
                'quantity' => $quantity,
                'unit_type' => $item->item->unit_type_id,
                'purchase_unit_price' => number_format($purchase_unit_price, 2),
                'total_purchase' => number_format($total_purchase, 2),
                'unit_price' => number_format($item->unit_price, 2),
                'total_sale' => number_format($total_sale, 2),
                'utility' => number_format($utility, 2),
                'ganancia_unidad_igv' => round($ganancia_unidad_igv, 2),
                'ganancia_global_igv' => round($ganancia_global_igv, 2),
                'ganancia_unidad_no_igv' => round($ganancia_unidad_no_igv, 2),
                'ganancia_global_no_igv' => round($ganancia_global_no_igv, 2),
                'ganancia_unidad_exo' => round($ganancia_unidad_exo, 2),
                'ganancia_global_exo' => round($ganancia_global_exo, 2),
                'item_discount' => number_format($item_discount, 2)
            ];
            $sum_ganancia_global_igv += $ganancia_global_igv;
            $sum_ganancia_global_no_igv += $ganancia_global_no_igv;
            $sum_ganancia_global_exo += $ganancia_global_exo;
            $document_total_utility += $utility;
            $document_total_net_utility += $ganancia_global_no_igv;
        }

        // Calcular porcentajes proporcionales y ajustar para que sumen exactamente 100%
        $porcentajes_igv = [];
        $porcentajes_no_igv = [];
        $porcentajes_exo = [];
        foreach ($temp_items as $temp_item) {
            $porcentajes_igv[] = $sum_ganancia_global_igv != 0 ? ($temp_item['ganancia_global_igv'] / $sum_ganancia_global_igv) * 100 : 0;
            $porcentajes_no_igv[] = $sum_ganancia_global_no_igv != 0 ? ($temp_item['ganancia_global_no_igv'] / $sum_ganancia_global_no_igv) * 100 : 0;
            $porcentajes_exo[] = $sum_ganancia_global_exo != 0 ? ($temp_item['ganancia_global_exo'] / $sum_ganancia_global_exo) * 100 : 0;
        }
        // Redondear y ajustar para que sumen 100%
        $porcentajes_igv = array_map(function ($v) {
            return round($v, 2);
        }, $porcentajes_igv);
        $porcentajes_no_igv = array_map(function ($v) {
            return round($v, 2);
        }, $porcentajes_no_igv);
        $porcentajes_exo = array_map(function ($v) {
            return round($v, 2);
        }, $porcentajes_exo);
        $diff_igv = 100 - array_sum($porcentajes_igv);
        $diff_no_igv = 100 - array_sum($porcentajes_no_igv);
        $diff_exo = 100 - array_sum($porcentajes_exo);
        if (count($porcentajes_igv) > 0) $porcentajes_igv[count($porcentajes_igv) - 1] += $diff_igv;
        if (count($porcentajes_no_igv) > 0) $porcentajes_no_igv[count($porcentajes_no_igv) - 1] += $diff_no_igv;
        if (count($porcentajes_exo) > 0) $porcentajes_exo[count($porcentajes_exo) - 1] += $diff_exo;
        // Call discount_global to update temp_items with descuento_item
        $this->discount_global($document, $temp_items);
        foreach ($temp_items as $idx => $temp_item) {
            $items_data[] = array_merge($temp_item, [
                'porcentaje_igv' => $sum_ganancia_global_igv == 0 ? 0 : $porcentajes_igv[$idx],
                'porcentaje_no_igv' => $sum_ganancia_global_no_igv == 0 ? 0 : $porcentajes_no_igv[$idx],
                'porcentaje_exo' => $sum_ganancia_global_exo == 0 ? 0 : $porcentajes_exo[$idx],
                'descuento_item_final' => isset($temp_item['descuento_item']) ? $temp_item['descuento_item'] : 0,
            ]);
        }

        // Descuento global del documento
        $global_discount = isset($document->total_discount) ? $document->total_discount : 0;

        $sales_data[] = [
            'document_type' => $document->document_type->description,
            'series_number' => $document->series . '-' . $document->number,
            'customer' => $document->customer->name,
            'date' => Carbon::parse($document->date_of_issue)->format('d/m/Y'),
            'items' => $items_data,
            'total_utility' => number_format($document_total_utility, 2),
            'total_net_utility' => number_format($document_total_net_utility, 2),
            'global_discount' => number_format($global_discount, 2)
        ];

        $total_utility += $document_total_utility;
        $total_net_utility += $document_total_net_utility;
    }

    private function processSaleNote($sale_note, &$sales_data, &$total_utility, &$total_net_utility)
    {
        $items_data = [];
        $document_total_utility = 0;
        $document_total_net_utility = 0;
        $sum_ganancia_global_igv = 0;
        $sum_ganancia_global_no_igv = 0;
        $sum_ganancia_global_exo = 0;
        $temp_items = [];

        foreach ($sale_note->items as $item) {
            $unit_price = $item->unit_price;
            $quantity = $item->quantity;
            $purchase_unit_price = $item->relation_item->purchase_unit_price ?? 0;
            $item_discount = isset($item->total_discount) ? $item->total_discount : 0;
            $total_purchase = $purchase_unit_price * $quantity;
            $total_sale = $unit_price * $quantity;
            $utility = $total_sale - $total_purchase;
            $has_igv = isset($item->total_igv) && (float)$item->total_igv > 0;
            // Mejor detección de exonerados: por affectation_igv_type_id o total_igv casteado
            $is_exonerado = (
                (isset($item->affectation_igv_type_id) && $item->affectation_igv_type_id == '20') ||
                (isset($item->total_igv) && (float)$item->total_igv == 0)
            );
            $factor_igv = 1.18;
            $global_discount = isset($sale_note->total_discount) ? $sale_note->total_discount : 0;
            $total_venta_doc = $sale_note->total ? $sale_note->total : 0;
            $proporcion = $total_venta_doc > 0 ? ($unit_price * $quantity) / $total_venta_doc : 0;
            $global_discount_item = $global_discount * $proporcion;
            $descuento_item_final = $global_discount_item + ($has_igv ? $item_discount * $factor_igv : $item_discount);
            $ganancia_unidad_igv = $unit_price - $purchase_unit_price - ($has_igv ? $item_discount * $factor_igv / $quantity : $item_discount / $quantity);
            $ganancia_global_igv = $ganancia_unidad_igv * $quantity;
            $unit_price_no_igv = $has_igv ? $unit_price / $factor_igv : $unit_price;
            $purchase_unit_price_no_igv = $has_igv ? $purchase_unit_price / $factor_igv : $purchase_unit_price;
            $ganancia_unidad_no_igv = $unit_price_no_igv - $purchase_unit_price_no_igv - ($item_discount / $quantity);
            $ganancia_global_no_igv = $ganancia_unidad_no_igv * $quantity;
            // Ganancia exonerada solo si es exonerado
            $ganancia_unidad_exo = $is_exonerado ? $ganancia_unidad_no_igv : 0;
            $ganancia_global_exo = $is_exonerado ? $ganancia_global_no_igv : 0;
            $temp_items[] = [
                'description' => $item->item->description,
                'quantity' => $quantity,
                'unit_type' => $item->item->unit_type_id,
                'purchase_unit_price' => number_format($purchase_unit_price, 2),
                'total_purchase' => number_format($total_purchase, 2),
                'unit_price' => number_format($unit_price, 2),
                'total_sale' => number_format($total_sale, 2),
                'utility' => number_format($utility, 2),
                'ganancia_unidad_igv' => round($ganancia_unidad_igv, 2),
                'ganancia_global_igv' => round($ganancia_global_igv, 2),
                'ganancia_unidad_no_igv' => round($ganancia_unidad_no_igv, 2),
                'ganancia_global_no_igv' => round($ganancia_global_no_igv, 2),
                'ganancia_unidad_exo' => round($ganancia_unidad_exo, 2),
                'ganancia_global_exo' => round($ganancia_global_exo, 2),
                'item_discount' => number_format($item_discount, 2)
            ];
            $sum_ganancia_global_igv += $ganancia_global_igv;
            $sum_ganancia_global_no_igv += $ganancia_global_no_igv;
            $sum_ganancia_global_exo += $ganancia_global_exo;
            $document_total_utility += $utility;
            $document_total_net_utility += $ganancia_global_no_igv;
        }

        // Calcular porcentajes proporcionales y ajustar para que sumen exactamente 100%
        $porcentajes_igv = [];
        $porcentajes_no_igv = [];
        $porcentajes_exo = [];
        foreach ($temp_items as $temp_item) {
            $porcentajes_igv[] = $sum_ganancia_global_igv != 0 ? ($temp_item['ganancia_global_igv'] / $sum_ganancia_global_igv) * 100 : 0;
            $porcentajes_no_igv[] = $sum_ganancia_global_no_igv != 0 ? ($temp_item['ganancia_global_no_igv'] / $sum_ganancia_global_no_igv) * 100 : 0;
            $porcentajes_exo[] = $sum_ganancia_global_exo != 0 ? ($temp_item['ganancia_global_exo'] / $sum_ganancia_global_exo) * 100 : 0;
        }
        // Redondear y ajustar para que sumen 100%
        $porcentajes_igv = array_map(function ($v) {
            return round($v, 2);
        }, $porcentajes_igv);
        $porcentajes_no_igv = array_map(function ($v) {
            return round($v, 2);
        }, $porcentajes_no_igv);
        $porcentajes_exo = array_map(function ($v) {
            return round($v, 2);
        }, $porcentajes_exo);
        $diff_igv = 100 - array_sum($porcentajes_igv);
        $diff_no_igv = 100 - array_sum($porcentajes_no_igv);
        $diff_exo = 100 - array_sum($porcentajes_exo);
        if (count($porcentajes_igv) > 0) $porcentajes_igv[count($porcentajes_igv) - 1] += $diff_igv;
        if (count($porcentajes_no_igv) > 0) $porcentajes_no_igv[count($porcentajes_no_igv) - 1] += $diff_no_igv;
        if (count($porcentajes_exo) > 0) $porcentajes_exo[count($porcentajes_exo) - 1] += $diff_exo;
        // Call discount_global to update temp_items with descuento_item
        $this->discount_global($sale_note, $temp_items);
        foreach ($temp_items as $idx => $temp_item) {
            $items_data[] = array_merge($temp_item, [
                'porcentaje_igv' => $sum_ganancia_global_igv == 0 ? 0 : $porcentajes_igv[$idx],
                'porcentaje_no_igv' => $sum_ganancia_global_no_igv == 0 ? 0 : $porcentajes_no_igv[$idx],
                'porcentaje_exo' => $sum_ganancia_global_exo == 0 ? 0 : $porcentajes_exo[$idx],
                'descuento_item_final' => isset($temp_item['descuento_item']) ? $temp_item['descuento_item'] : 0,
            ]);
        }

        // Descuento global de la nota de venta
        $global_discount = isset($sale_note->total_discount) ? $sale_note->total_discount : 0;

        $sales_data[] = [
            'document_type' => 'NOTA DE VENTA',
            'series_number' => $sale_note->series . '-' . $sale_note->number,
            'customer' => $sale_note->customer->name,
            //'date' => $sale_note->date_of_issue->format('d/m/Y'),
            'date' => \Carbon\Carbon::parse($sale_note->date_of_issue)->format('d/m/Y'),
            'items' => $items_data,
            'total_utility' => number_format($document_total_utility, 2),
            'total_net_utility' => number_format($document_total_net_utility, 2),
            'global_discount' => number_format($global_discount, 2)
        ];

        $total_utility += $document_total_utility;
        $total_net_utility += $document_total_net_utility;
    }


    public function discount_global($doc, &$items_data)
    {
        // Prorratear el descuento global según el total de cada ítem
        $global_discount = isset($doc->total_discount) ? $doc->total_discount : 0;
        $total_venta_doc = isset($doc->total) ? $doc->total : 0;
        Log::info('total venta doc: ' . $total_venta_doc);
        Log::info('items data count: ' . count($items_data));

        // Sumar el total de venta de todos los ítems
        $sum_total_venta_items = 0;
        foreach ($items_data as $item) {
            $item_total = (isset($item['unit_price']) ? $item['unit_price'] : 0) * (isset($item['quantity']) ? $item['quantity'] : 0);
            $sum_total_venta_items += $item_total;
        }

        if ($global_discount > 0 && $sum_total_venta_items > 0 && count($items_data) > 0) {
            Log::info('descuento global: ' . $global_discount);
            foreach ($items_data as &$item) {
                $item_total = (isset($item['unit_price']) ? $item['unit_price'] : 0) * (isset($item['quantity']) ? $item['quantity'] : 0);
                $proporcion = $item_total / $sum_total_venta_items;
                $item['descuento_item'] = number_format($global_discount * $proporcion, 2);
            }
        }
    }


    public function discount_item(&$items_data)
    {
        // aqui ver si hay descuento por item, multiplicando por 1.18
        $factor_igv = 1.18;
        foreach ($items_data as &$item) {
            $item_discount = isset($item['total_discount']) ? $item['total_discount'] : 0;
            $item['item_discount'] = number_format($item_discount * $factor_igv, 2);
        }
    }
}
