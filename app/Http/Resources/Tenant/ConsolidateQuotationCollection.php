<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ConsolidateQuotationCollection extends ResourceCollection
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
            // $total = 0;
            $quotations_ids = $row->quotations->pluck('id');
            return [
                'id' => $row->id,
                'identifier' =>'CON-'.STR_PAD($row->id, 6, '0', STR_PAD_LEFT),
                'user_name' => $row->user->alias ? $row->user->alias." - ".  $row->user->name : $row->user->name,
                'establishment' => $row->establishment->description,
                'date' => $row->created_at->format('Y-m-d H:i:s'),
                'quotations' => $quotations_ids,
                'zone' => isset($row->person->zone) ? $row->person->zone->description : '',
                // 'total' => $total,
            ];
        });
    }
}
