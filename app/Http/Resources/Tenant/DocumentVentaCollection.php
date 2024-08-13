<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;
use App\Models\Tenant\Catalogs\DetractionType;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\DetractionPayment;
use App\Models\Tenant\Establishment;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Restaurant\Models\Orden;

class DocumentVentaCollection extends ResourceCollection
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
            $establishment_description = Establishment::find($row->establishment_id)->description;
                return [
                    'id' => $row->id,
                    'establishment_description' => $establishment_description,
                    'number_full' => $row->number_full,
                    'date_of_issue' => $row->date_of_issue,
                    'items' => $row->items->map(function ($item) {
                        return [
                            'item_id' => $item->id,
                            'item' => $item->item,
                            'warehouse_id' => $item->warehouse_id,
                            'unit_value' => $item->unit_value,
                            'quantity' => $item->quantity,
                            'total' => $item->total,
                        ];
                    }),  
                ];
            });
    }
}
