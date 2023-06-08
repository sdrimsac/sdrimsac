<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\Person;
use Carbon\Carbon;
use Exception;
use App\Models\Tenant\ModelTenant;
use Illuminate\Support\Facades\Log;

class InternetRegister extends ModelTenant
{
    public $timestamps = true;
    protected $table = "internet_register";
    protected $with = ["person", "operations"];
    protected $fillable = [
        "person_id",
        "type",
        "installation_address",
        "reference_installation_address",
        "identifier",
        "mac",
        "date",
        "end_date",
        "tech_id",
        "supplie",
        "active",
        "credit",
        "pay_date",
        'house_photo',


    ];

    protected $casts = [
        'active' => 'boolean'
    ];
    public function tech()
    {
        return $this->belongsTo(InternetTech::class);
    }
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function operations()
    {
        return $this->hasMany(InternetOperation::class, 'register_id', 'id');
    }
    public function get_name_of_plan()
    {
        try {
            $operation = InternetOperation::where('register_id', $this->id)->first();
            $plan_operation = InternetPlanOperation::where('operation_id', $operation->id)->first();
            $plan_variation = InternetPlanVariation::where('id', $plan_operation->plan_id)->first();
            $plan = InternetPlan::where('id', $plan_variation->plan_id)->first();
            $name_plan = $plan->capacity . "-" . $plan_variation->description;
            return $name_plan;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return "";
        }
    }

    public function get_last_payment()
    {
        try {

            $last_payment = InternetPaymentMonth::whereHas('payment', function ($query) {
                $query->whereHas('operation', function ($query) {
                    $query->where('register_id', $this->id);
                });
            })->where('state', 'incomplete')->first();

            if ($last_payment) {
                return $last_payment->rest;
            }
            return 0.00;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return 0.00;
        }
    }

    public function get_date_pay()
    {
        $pay_date = Carbon::parse($this->pay_date);
        //get the day of the pay_date with carbon
        $day = $pay_date->day;

        return "Día $day";
    }

    public function get_suspension_description()
    {
        $suspension_description = null;
        $has_suspension = InternetSuspension::where('register_id', $this->id)->where('active', 1)
            ->whereNull('reconnect_date')
            ->latest()->first();
        if ($has_suspension) {
            $suspension_description = $has_suspension->description;
        }
        return $suspension_description;
    }
}
