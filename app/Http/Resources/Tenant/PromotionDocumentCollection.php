<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PromotionDocumentCollection extends ResourceCollection
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
            $current_date = date('Y-m-d');
            $days_remaining = (strtotime($row->date_end) - strtotime($current_date)) / (60 * 60 * 24);
            
            $status = 'available';
            if ($days_remaining <= 2) {
                $status = 'danger';
            } elseif ($days_remaining <= 5) {
                $status = 'warning';
            }
            return [
                'id' => $row->id,
                'status' => $status,
                'description' => $row->description,
                'date_start' => $row->date_start,
                'date_end' => $row->date_end,
                'total' => $row->total,
                'points_value' => $row->points_value,
                'limit_changes' => $row->limit_changes,
                'active' => (bool) $row->active,
                'active' => (bool) $row->active,
            
            ];
        });
    }
}