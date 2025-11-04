<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\CreditList;
use App\Models\Tenant\Person;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;


class StaffPersonWorkerCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function($row) {
            return [
                'id' => $row->id,
                'person_id' => $row->person_id,
                'person_name' => optional($row->person)->name,
                'date_daily' => $row->date_daily,
                'entrance' => $row->entrance,
                'exit' => $row->exit,
                'horas_trabajadas' => $row->horas_trabajadas,
                'overtime' => $row->overtime,
                'amount_extra' => $row->amount_extra,
                'lack' => $row->lack,
                'date_end_daily' => $row->date_end_daily,
                'pairs' => $row->pairs,
            ];
        });
    }
}