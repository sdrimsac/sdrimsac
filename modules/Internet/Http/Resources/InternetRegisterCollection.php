<?php

namespace Modules\Internet\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\URL;
use Modules\Internet\Models\InternetConceptOperation;
use Modules\Internet\Models\InternetPayment;
use Modules\Internet\Models\InternetPaymentMonth;
use Modules\Internet\Models\InternetPlan;
use Modules\Internet\Models\InternetPlanOperation;
use Modules\Internet\Models\InternetPlanVariation;
use Modules\Internet\Models\InternetSuspension;

class InternetRegisterCollection extends ResourceCollection
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

            $plan_operation = InternetPlanOperation::whereHas('operation', function ($query) use ($row) {
                $query->where('register_id', $row->id);
            })->latest()->first();
            $concepts_operation = InternetConceptOperation::whereHas('operation', function ($query) use ($row) {
                $query->where('register_id', $row->id);
            })->get()->transform(function ($row) {
                $concept_variation  = $row->concept;
                $concept_general = $concept_variation->concept;
                return [
                    "general" => $concept_general,
                    "variation" => $concept_variation,
                ];
            });
            $plan_variation = InternetPlanVariation::find($plan_operation->plan_id);
            $plan = InternetPlan::find($plan_variation->plan_id);

            $last_payment = InternetPaymentMonth::whereHas('payment', function ($query)  use ($row) {
                $query->whereHas('operation', function ($query) use ($row) {
                    $query->where('register_id', $row->id);
                });
            })->where('state', 'incomplete')->first();
            $amount = $plan_operation->operation->get_operation_amount();
            InternetPaymentMonth::whereHas('payment', function ($query) {
                $query->whereNull('state');
            })->chunk(50, function ($payments) use ($amount) {
                foreach ($payments as $payment) {

                    $payment->normalize($amount);
                }
            });
            if (!$row->pay_date) {
                $row->pay_date = $row->date;
                $row->save();
            }
            $suspension_description = null;
            $has_suspension = InternetSuspension::where('register_id', $row->id)->where('active', 1)
                ->whereNull('reconnect_date')
                ->latest()->first();
            if ($has_suspension) {
                $suspension_description = $has_suspension->description;
            }
            if ($last_payment == null) {
                $has_payment = InternetPaymentMonth::whereHas('payment', function ($query) use ($row) {
                    $query->whereHas('operation', function ($query) use ($row) {
                        $query->where('register_id', $row->id);
                    });
                })->count();
                if ($has_payment == 0) {
                    $last_payment_general = InternetPayment::whereHas('operation', function ($query) use ($row) {
                        $query->where('register_id', $row->id);
                    })->latest()->first();
                    if ($last_payment_general) {
                        $last_payment = [
                            "state" => $last_payment_general->type,
                            "rest" => $last_payment_general->rest == 0 ? null : $last_payment_general->rest,
                        ];
                    }
                }
            }

            // $house_photo = null;
            return [
                'suspension_description' => $suspension_description,
                'id'          => $row->id,
                'last_payment' => $last_payment,
                'total' => floatval($amount ?? "0"),
                'person' => $row->person,
                'date' => Carbon::parse($row->pay_date)->format("d") . " de cada mes",
                'date_value' => $row->pay_date,
                'identifier'      => $row->identifier,
                'credit'      => $row->credit,
                'concepts_operation'      => $concepts_operation,
                'plan'     => $plan,
                'plan_variation'     => $plan_variation,
                'monthly'    => false,
                'active' => (bool)$row->active,
                'house_photo' => $row->house_photo,
            ];
        });
    }
}
