<?php

namespace Modules\College\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\College\Models\CollegePlanService;

class CollegeRegisterCollection extends ResourceCollection
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
            $plan = $row->plan;
            $services = CollegePlanService::where('plan_id', $plan->id)->get();
            $payments = $row->payments;
            return [
                'payments' => $payments,
                'id'          => $row->id,
                'active' => $row->active,
                'plan' => $plan,
                'services' => $services,
            ];
        });
    }
}
