<?php

namespace Modules\Consignment\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Consignment\Models\ConsignmentDocument;
use Modules\Consignment\Models\ConsignmentItem;

class ConsignmentCollection extends ResourceCollection
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
            $items = ConsignmentItem::where('consignment_id', $row->id);
            $stock = $items->sum('original_quantity');
            $total_price = ConsignmentItem::selectRaw('SUM(original_quantity * price) as total')
                ->where('consignment_id', $row->id)
                ->first();
            $consignment_penalty  = $row->penalty;
            $penalty = null;
            if ($consignment_penalty) {

                $penalty = $consignment_penalty->type == 'percentage' ? $consignment_penalty->amount . '%' : 'S/' . $consignment_penalty->amount;
            }
            $expired = Carbon::parse($row->date_of_end)->lte(Carbon::now()->startOfDay());
            
            $document = ConsignmentDocument::where('consignment_id', $row->id)->first();
            $sale_note = $document ? $document->sale_note : null;
            $download_url =  null;
            $number_document = null;
            if($sale_note){
                $number_document = $sale_note->getNumberFullAttribute();
                //http://colegio.sdrimsac-tenant.oo/sale-notes/print/f9d639e6-5ba2-402c-ad63-ab10cb977dcf/ticket
                $download_url =  url('sale-notes/print/'.$sale_note->external_id.'/ticket');
            }
            $liquidated = (bool)$row->liquidated;
            $user_name = $row->user ?$row->user->name:"";
            $user_liquidated_name = $row->user_liquidated ?$row->user_liquidated->name:"";
            return [
                'number_document' => $number_document,
                'download_url' => $download_url,
                'expired' => $expired && !$liquidated,
                'id' => $row->id,
                'penalty' => $penalty,
                'liquidated' => (bool)$row->liquidated,
                'date_of_issue' => Carbon::parse($row->date_of_issue)->format('Y-m-d'),
                'date_of_end' => Carbon::parse($row->date_of_end)->format('Y-m-d'),
                'person' => [
                    'id' => $row->person->id,
                    'name' => $row->person->name,
                    'number' => $row->person->number,
                ],
                'stock' => $stock,
                'total' => $total_price ? $total_price->total : 0,
                'active' => (bool)$row->active,
                'user_name' => $user_name,
                'user_liquidated_name' => $user_liquidated_name,

            ];
        });
    }
}
