<?php

namespace App\Models\Tenant;


class HotelRentInfraction extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'hotel_rent_infractions';
    protected $fillable = [
        'hotel_rent_id',
        'description',
        'amount',
        'paid',
        'hotel_rent_document_id',
    ];

    protected $casts = [
        'paid' => 'boolean',
    ];


    public function hotel_rent()
    {
        return $this->belongsTo(HotelRent::class);
    }

    public function hotel_rent_document()
    {
        return $this->belongsTo(HotelRentDocument::class);
    }

}
