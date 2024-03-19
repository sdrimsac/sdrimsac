<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentSaludCollection extends ResourceCollection
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
                'date_of_charge' => $row->date_of_charge,
                'file_name' => $row->file_name,
                'identifier' => $row->identifier,
                'status' => $row->status,
                'error' => $row->error,
            ];
        });
    }
}
