<?php

namespace Modules\College\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\College\Models\CollegePlanService;

class CollegePaymentCollection extends ResourceCollection
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
            $plan = $row->register->plan;
            $services = CollegePlanService::where('plan_id', $plan->id)->get();
            return [
                'id'          => $row->id,
                'document' => $row->document,
                'type' => $row->type,
                'active' => $row->active,
                'register' => $row->register,
                'plan' => $plan,
                'services' => $services,
            ];
        });
    }
}
