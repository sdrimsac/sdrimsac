<?php

namespace App\Models\Tenant;



class HotelRentItem extends ModelTenant
{
    protected $table = 'hotel_rent_items';
    protected $fillable = [
        'hotel_rent_id',
        'table_id',
        'duration',
        'quantity_persons',
        'payment_status',
        'checkin_date',
        'checkin_time',
        'checkout_date',
        'checkout_time',
    ];
}
