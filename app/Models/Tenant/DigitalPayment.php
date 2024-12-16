<?php

namespace App\Models\Tenant;

class DigitalPayment extends ModelTenant
{
    protected $table = 'digital_payment_notifications';
    protected $fillable = ['type', 'person_name', 'amount', 'all_message', 'package_name', 'title'];
}