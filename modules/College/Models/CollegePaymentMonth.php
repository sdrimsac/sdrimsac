<?php

namespace Modules\College\Models;

use App\Models\Tenant\ModelTenant;

class CollegePaymentMonth extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_payment_month";
    protected $fillable = [
        'month',
        'payment_id',
        'year',
    ];

    public function payment()
    {

        return $this->belongsTo(CollegePayment::class, 'payment_id');
    }
}
