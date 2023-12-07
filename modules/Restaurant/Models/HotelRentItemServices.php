<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\HotelRentItem;
use App\Models\Tenant\ModelTenant;


class HotelRentItemServices extends ModelTenant
{

    protected $table = "hotel_rent_item_services";
    protected $casts = [
        'active' => 'boolean',
        'was_due' => 'boolean',
    ];
    protected $fillable = [
        'hotel_rent_item_id',
        'room_service_id',
        'quantity',
        'code',
        'date_take',
        'was_due',
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

    public function dued(){
        $room_service = $this->room_service;
        $due_time = $room_service->due_time;
        $date_take = $this->date_take;
        if(!$date_take || !$due_time){
            return false;
        }
        $date_take = \Carbon\Carbon::parse($date_take.' '.$due_time);
        $now = \Carbon\Carbon::now();
        if($now->gt($date_take)){
            $this->was_due = true;
            $this->save();
            return true;
        }
        return false;
    }
}
