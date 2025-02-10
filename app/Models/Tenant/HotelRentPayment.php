<?php

namespace App\Models\Tenant;


class HotelRentPayment extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'hotel_rent_payments';
    protected $fillable = [
        'hotel_rent_item_id',
        'date_payment',
        'date_start',
        'date_end',
        'amount',
        'is_paid',
        'is_warranty'

    ];

    protected $casts = [
        'is_paid' => 'boolean',
    ];



    public function hotel_rent_item()
    {
        return $this->belongsTo(HotelRentItem::class);
    }

    public function hotel_rent_document()
    {
        return $this->hasMany(HotelRentDocument::class);
    }


}
