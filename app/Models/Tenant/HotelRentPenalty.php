<?php

namespace App\Models\Tenant;

class HotelRentPenalty extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'hotel_rent_penalties';
    protected $fillable = [
        'hotel_rent_item_id',
        'days_late',
        'amount',
        'status',
        
    ];


    public function hotel_rent_item()
    {
        return $this->belongsTo(HotelRentItem::class);
    }




    


}
