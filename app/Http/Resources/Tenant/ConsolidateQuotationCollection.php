<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
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
            $first_quotation = $row->quotations->first();
            $exist_documents = Document::where('quotation_id', $first_quotation->id)->exists();
            $exist_sale_notes = SaleNote::where('quotation_id', $first_quotation->id)->exists();
            return [
                'id' => $row->id,
                'identifier' =>'CON-'.STR_PAD($row->id, 6, '0', STR_PAD_LEFT),
                'user_name' => $row->user->alias ? $row->user->alias." - ".  $row->user->name : $row->user->name,
                'establishment' => $row->establishment->description,
                'date' => $row->created_at->format('Y-m-d H:i:s'),
                'quotations' => $quotations_ids,
                'hasPrint' => $exist_documents || $exist_sale_notes,
                // 'zone' => isset($row->person->zone) ? $row->person->zone->description : '',
                // 'total' => $total,
            ];
        });
    }
}
