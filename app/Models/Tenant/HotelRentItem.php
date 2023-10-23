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

    public function hotel_rent()
    {
        return $this->belongsTo(HotelRent::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function guesses()
    {
        return $this->belongsToMany(Person::class, 'hotel_rent_item_person');
    }

}
