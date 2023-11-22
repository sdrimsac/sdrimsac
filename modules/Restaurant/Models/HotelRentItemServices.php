<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\HotelRentItem;
use App\Models\Tenant\ModelTenant;


class HotelRentItemServices extends ModelTenant
{

    protected $table = "hotel_rent_item_services";
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $fillable = [
        'hotel_rent_item_id',
        'room_service_id',
        'quantity', 
        'code', 
        'active',
    ];

    public function hotel_rent_item()
    {
        return $this->belongsTo(HotelRentItem::class);
    }

    public function room_service()
    {
        return $this->belongsTo(RoomService::class);
    }
    

 
}
