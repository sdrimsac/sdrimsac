<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\ModelTenant;

class InternetOperation extends ModelTenant
{
    public $timestamps = true;
    protected $fillable = [
        "description",
        "total",
        "register_id",
        "period",
        "active",
        "plan",
        "concepts",
    ];

    protected $casts = [
        'active' => 'boolean',
        'plan' => 'array',
        'concepts' => 'array',
    ];


    public function register()
    {
        return $this->belongsTo(InternetRegister::class, 'register_id');
    }

    public function payments()
    {
        return $this->hasMany(InternetPayment::class, 'operation_id');
    }

    public function get_operation_amount()
    {
        $total = 0;
        if ($this->plan == null) {
          $this->set_plan_concept_json();
        }
        if($this->plan == null){
            $plan_operation = InternetPlanOperation::where('operation_id', $this->id)->first();
            $concept_operation = InternetConceptOperation::where('operation_id', $this->id)->get();
            $total = $plan_operation->plan->price;
            foreach ($concept_operation as $concept) {
                $total += $concept->concept->price;
            }
          }else{
            $plan_total = $this->plan["price"];
            $total += $plan_total;
            
            isset($this->concepts) ? $concepts = $this->concepts : $concepts = [];
            foreach ($concepts as $concept) {
                $total += $concept["price"];
            }
          }
        return $total; 
    }
    public function set_plan_concept_json()
    {
        $plan_operation = InternetPlanOperation::where('operation_id', $this->id)->first();
        $concept_operation = InternetConceptOperation::where('operation_id', $this->id)->get();
        $plan = $plan_operation->plan;
        $concepts = [];
        foreach ($concept_operation as $concept) {
            $concepts[] = $concept->concept;
        }
        $this->plan = $plan;
        $this->concepts = $concepts;
        $this->save();
    }
}
