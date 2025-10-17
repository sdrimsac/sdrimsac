<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Item;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PurchaseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    return $this->collection->transform(function ($row, $key) {

            $total = $row->total;
            if ($row->total_perception) {
                $total += round($row->total_perception, 2);
            }
            if ($row->includes == 1) {
                $includes = true;
            } else {
                $includes = false;
            }
            $paid = $row->purchase_payments->sum('payment') == $row->total;
            if ($paid == false) {
                $paid = $row->total_canceled;
            }
            return [
                'id' => $row->id,
                'document_type_description' => $row->document_type->description,
                'group_id' => $row->group_id,
                'soap_type_id' => $row->soap_type_id,
                'user_name' => $row->user->name,
                'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                'time_of_issue' => $row->time_of_issue,
                'date_of_due' => ($row->date_of_due) ? $row->date_of_due->format('Y-m-d') : '-',
                'number' => $row->number_full,
                'number_full' => $row->series_guia . "-" . $row->number_guia,
                'supplier_name' => $row->suppliers->name,
                'supplier_number' => $row->suppliers->number,
                'currency_type_id' => $row->currency_type_id,
                'total_exportation' => $row->total_exportation,
                'total_free' => number_format($row->total_free, 2, ".", ""),
                'total_unaffected' => number_format($row->total_unaffected, 2, ".", ""),
                'total_exonerated' => number_format($row->total_exonerated, 2, ".", ""),
                'total_taxed' => number_format($row->total_taxed, 2, ".", ""),
                'total_igv' => number_format($row->total_igv, 2, ".", ""),
                'total_perception' => number_format($row->total_perception, 2, ".", ""),
                'total' => number_format($total, 2, ".", ""),
                'state_type_id' => $row->state_type_id,
                'state_type_description' => $row->state_type->description,
                'state_type_payment_description' => $row->state_type_id != '11' ? ($paid ? 'Pagado' : 'Pendiente de pago') : 'Anulado',
                'includes' => ($includes),
                // 'payment_method_type_description' => isset($row->purchase_payments['payment_method_type']['description'])?$row->purchase_payments['payment_method_type']['description']:'-',
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
                'payments' => $row->purchase_payments->transform(function ($row, $key) {
                    return [
                        'id' => $row->id,
                        'payment_method_type_description' => $row->payment_method_type->description,
                        'reference' => $row->reference,
                        'payment' => $row->payment,
                        'payment_method_type_id' => $row->payment_method_type_id,
                    ];
                }),
                'items' => $row->items->transform(function ($row, $key) {
                    $itemModel = Item::find($row->item_id);
                    // $row->item puede ser null o stdClass sin todas las propiedades
                    $itemObj = isset($row->item) ? $row->item : null;
                    $internal_id = null;
                    $description = null;
                    $unit_type_id = null;
                    $color_size = null;
                    $lots_group = null;

                    if ($itemObj) {
                        // si es array o stdClass, intentar obtener las propiedades de forma segura
                        if (is_array($itemObj)) {
                            $internal_id = $itemObj['internal_id'] ?? null;
                            $description = $itemObj['description'] ?? null;
                            $unit_type_id = $itemObj['unit_type_id'] ?? null;
                            $color_size = $itemObj['color_size'] ?? null;
                            $lots_group = $itemObj['lots_group'] ?? null;
                        } else {
                            // objeto (puede ser stdClass o modelo)
                            $internal_id = property_exists($itemObj, 'internal_id') ? $itemObj->internal_id : (isset($itemObj->internalId) ? $itemObj->internalId : null);
                            $description = property_exists($itemObj, 'description') ? $itemObj->description : null;
                            $unit_type_id = property_exists($itemObj, 'unit_type_id') ? $itemObj->unit_type_id : null;
                            $color_size = property_exists($itemObj, 'color_size') ? $itemObj->color_size : null;
                            $lots_group = property_exists($itemObj, 'lots_group') ? $itemObj->lots_group : null;
                        }
                    }

                    return [
                        'key' => $key + 1,
                        'id' => $row->id,
                        'internal_id' => $internal_id,
                        'description' => $description,
                        'quantity' => round($row->quantity, 2),
                        'unit_type_id' => $unit_type_id,
                        'max_quantity' => $itemModel ? $itemModel->max_quantity : null,
                        'max_quantity_description' => $itemModel ? $itemModel->max_quantity_description : null,
                        'lots' => collect($row->lots)->transform(function ($row, $key) {
                            return [
                                'id' => $row->id,
                                'series' => $row->series,
                                'date' => $row->date,
                                'item_lot_id' => $row->item_lot_id,
                            ];
                        }),
                        'color_size' => $color_size,
                        'lots_group' => ($lots_group && is_iterable($lots_group))
                            ? collect($lots_group)->transform(function ($row, $key) {
                                return [
                                    'id' => isset($row->id) ? $row->id : null,
                                    'code' => isset($row->code) ? $row->code : null,
                                    'date_of_due' => isset($row->date_of_due) ? $row->date_of_due : null,
                                    'item_id' => isset($row->item_id) ? $row->item_id : null,
                                    'warehouse_id' => isset($row->warehouse_id) ? $row->warehouse_id : null,
                                    'status' => isset($row->status) ? $row->status : null,
                                ];
                            })
                            : null,
                        'warehouse' => $row->warehouse ? $row->warehouse->description : '',
                    ];
                }),
            ];
        })->all();
    }
}
