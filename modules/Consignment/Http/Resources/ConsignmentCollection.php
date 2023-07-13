<?php

namespace Modules\Consignment\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
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
            

            $liquidated = (bool)$row->liquidated;

            return [
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

            ];
        });
    }
}
