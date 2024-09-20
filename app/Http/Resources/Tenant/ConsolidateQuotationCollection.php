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
                'user_name' => $row->user->name,
                'establishment' => $row->establishment->description,
                'date' => $row->date_of_issue,
                'quotations' => $quotations_ids,
                // 'total' => $total,
            ];
        });
    }
}
