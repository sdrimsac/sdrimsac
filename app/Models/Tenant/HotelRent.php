<?php

namespace App\Models\Tenant;



class HotelRent extends ModelTenant
{
    protected $fillable = [
        'customer_id',
        'customer',
        'observation',
        'payment_type',
        'payment_number_operation',
        'payment_status',
        'total',
        'paid',
        'document_id',
        'sale_note_id',
    ];

    
}