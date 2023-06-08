<?php

namespace Modules\Internet\Models;

use Carbon\Carbon;
use App\Models\Tenant\ModelTenant;

class InternetPaymentMonth extends ModelTenant
{
    public $timestamps = true;
    protected $table = "internet_payment_month";
    protected $fillable = [
        "payment_id",
        "month",
        "year",
        "amount",
        "state",
        "rest",
        "start_date",
        "end_date",

    ];



    public function payment()
    {
        return $this->belongsTo(InternetPayment::class, 'payment_id');
    }

    public function normalize($amount)
    {
        $date = Carbon::create($this->year);
        $start_date = $date->format('Y-m-d');
        $end_date = Carbon::create($start_date)->addMonthNoOverflow()->format('Y-m-d');
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->amount = $amount;
        $this->state = "complete";
        $this->rest = 0;
        $this->save();
    }
}
