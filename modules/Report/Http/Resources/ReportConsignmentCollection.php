<?php

namespace Modules\Report\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReportConsignmentCollection extends ResourceCollection
{


    public function toArray($request)
    {


        return $this->collection->transform(function ($row, $key) {
            $number = str_pad($row->id, 8, "0", STR_PAD_LEFT);
            $items = $row->items;
            $count_items = $items->count();
            $total = 0;
            foreach ($items as $item) {
                $total += $item->original_quantity * $item->price;
            }
            $penalty = null;
            if ($row->penalty) {
                $consignment_penalty = $row->penalty;
                $amount = $consignment_penalty->amount;
                if ($consignment_penalty->type == 'percentage') {
                    $penalty = $amount . '%';
                } else {
                    $penalty = 'S/ ' . $amount;
                }
            }
            $user_name = $row->user ?$row->user->name:"";
            $user_liquidated_name = $row->user_liquidated ?$row->user_liquidated->name:"";
            return [
                'id' => $row->id,
                'number' => $number,
                'date_of_issue' => Carbon::parse($row->date_of_issue)->format('Y-m-d'),
                'date_of_end' => Carbon::parse($row->date_of_end)->format('Y-m-d'),
                'person' => ["name" => $row->person->name, "number" => $row->person->number],
                'count_items' => $count_items,
                "total" => $total,
                "penalty" => $penalty,
                "liquidated" => $row->liquidated  == 1 ? 'Liquidado' : 'Por liquidar',
                'user_name' => $user_name,
                'user_liquidated_name' => $user_liquidated_name,
            ];
        });
    }
}
