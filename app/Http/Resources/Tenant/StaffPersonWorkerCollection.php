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
                'extra_time_two' => $row->extra_time_two,
                'extra_time_three' => $row->extra_time_three,
                'lack_time' => $row->lack_time,
                'job_position' => optional($row->job_position)->name,
                // the query in StaffController selects the advances sum as `advances`
                // expose it here and keep a backward-compatible key `worker_advances`
                'advances' => (float) ($row->advances ?? 0),
                'worker_advances' => (float) ($row->worker_advances ?? $row->advances ?? 0),
                'amount' => $row->amount,
            ];
        });
    }
}