<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SellerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
            return [
                'id' => $row->id,
                'name' => $row->name,
                'document' => $row->document,
                'telephone' => $row->telephone,
                'establishment_description' => optional($row->establishment)->description ?? '-',
                'active' => (bool) $row->active,
                'documents_total' => $row->documents_total ?? 0,
                'sale_notes_total' => $row->sale_notes_total ?? 0,
                'total_sales' => ($row->documents_total ?? 0) + ($row->sale_notes_total ?? 0),
                'created_at' => $row->created_at,
                'created_at' => Carbon::parse($row->created_at)->format('Y-m-d H:i'),
                'updated_at' => $row->updated_at,
                'user_name' => $row->user ? $row->user->name : '',
            ];
        });
    }
}