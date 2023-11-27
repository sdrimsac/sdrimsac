<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
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

            $customers = "";
            if ($row->type == "1") {

                $type = $row->method . " - Ingreso";
            } else if ($row->type == "2") {
                $type = "Egreso";
            }
            if ($row->type == "1") {
                if ($row->document_id != null  && $row->type == "1") {
                    $row_document = Document::where('id', $row->document_id)->first();
                    $customers = ($row_document == null) ? "" : $row_document->customer->name;
                    $date = $row_document->date_of_issue."  ".$row_document->time_of_issue;
                } else if ($row->sale_note_id != null && $row->type == "1") {
                    $row_document = SaleNote::where('id', $row->sale_note_id)->first();
                    $customers = ($row_document == null) ? "" : $row_document->customer->name;
                    $date = $row_document->date_of_issue->format('Y-m-d')."  ".$row_document->time_of_issue;
                } else {
                    $customers = "";
                }
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
                'operation_number' => $row->operation_number,
                'id'                => $row->id,
                'groups'            => $row->groups->group,
                'categories'        => $row->categories,
                'subcategories'     => $row->subcategories,
                'group_id'          => $row->group_id,
                'reference'        => $row->cash->reference_number,
                'category_id'       => $row->category_id,
                'subcategory_id'    => $row->subcategory_id,
                'amount'            => $row->amount,
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
