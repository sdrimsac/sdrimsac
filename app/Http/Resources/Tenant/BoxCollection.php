<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Establishment;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BoxCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {
            $date  = $row->created_at->format('Y-m-d H:i:s');
            $amount = $row->amount;
            $customers = "";
            $customerNumber = "";
            $payment_condition = "Contado";
            $establishment_description = "";
            if ($row->type == "1") {

                $type = $row->method . " - Ingreso";
            } else if ($row->type == "2") {
                $type = "Egreso";
            }
            if ($row->type == "1") {
                if ($row->document_id != null) {
                    $row_document = Document::where('id', $row->document_id)->first();
                    $total = $row_document->total;
                    if($total < $amount){
                        $amount = $total;
                    }
                    $establishment = Establishment::find($row->establishment_id);
                    $establishment_description = ($establishment == null) ? "" : $establishment->description;
                    $payment_condition = $row_document->payment_condition_id == "01" ? "Contado" : "Crédito";
                    $customers = ($row_document == null) ? "" : $row_document->customer->name;
                    $customerNumber = ($row_document == null) ? "" : $row_document->customer->number;
                    $date = $row_document->date_of_issue."  ".$row_document->time_of_issue;
                } else if ($row->sale_note_id != null ) {
                    $row_document = SaleNote::where('id', $row->sale_note_id)->first();
                    $total = $row_document->total;
                    if($total < $amount){
                        $amount = $total;
                    }
                    $establishment = Establishment::find($row->establishment_id);
                    $establishment_description = ($establishment == null) ? "" : $establishment->description;
                    $payment_condition = $row_document->credit_cash !== 1 ? "Contado" : "Crédito";
                    $customers = ($row_document == null) ? "" : $row_document->customer->name;
                    $customerNumber = ($row_document == null) ? "" : $row_document->customer->number;
                    $date = $row_document->date_of_issue->format('Y-m-d')."  ".$row_document->time_of_issue;

                } else {
                    $customers = "";
                }
                /* dump($customers); */
            }
            $items = $row->items->transform(function ($item, $key) {
                return [
                    "id" => $item->id,
                    "quantity" => floatval($item->quantity),
                    "price" => floatval($item->price),
                    "extra_price" => floatval($item->price_extra),
                    "detail" => $item->item->detail,
                    "unit_id" => $item->item->unit_id,
                ];
            });
            return [
                'establishment_description' => $establishment_description,
                'payment_condition' => $payment_condition,
                'operation_number' => $row->operation_number,
                'id'                => $row->id,
                'groups'            => $row->groups->group,
                'categories'        => $row->categories,
                'customerNumber' => $customerNumber,
                'subcategories'     => $row->subcategories,
                'group_id'          => $row->group_id,
                'reference'        => $row->cash->reference_number,
                'category_id'       => $row->category_id,
                'subcategory_id'    => $row->subcategory_id,
                'amount'            => $amount,
                'method'            => $row->method,
                // 'date'              => $row->date . " " . $row->created_at->format('h:m:s'),
                'description'       => $row->description,
                'cliente'           => $customers,
                'type'              => $type,
                'items' => $items,
                'user'              => $row->user->name,
                'date'             => $date,
            ];
        });
    }
}
