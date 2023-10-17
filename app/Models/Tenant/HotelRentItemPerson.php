<?php

namespace App\Models\Tenant;



class HotelRentItemPerson extends ModelTenant
{
    protected $table = 'hotel_rent_item_person';
    protected $fillable = [
        'hotel_rent_item_id',
        'person_id',
    ];
}
