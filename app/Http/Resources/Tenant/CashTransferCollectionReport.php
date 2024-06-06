<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CashTransferCollectionReport extends ResourceCollection
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

            
            return [
                'id' => $row->id,
                'date_of_issue' => $row->date_of_issue,
                'type' => $row->type,
                'user_name' => $row->user_name,
                'income' => $row->income,
                'expense' => $row->expense,
            ];
        });
    }
}
