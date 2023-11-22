<?php

namespace Modules\Restaurant\Models;
use App\Models\Tenant\ModelTenant;


class ItemRoomService extends ModelTenant
{

    protected $table = "item_room_services";
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $fillable = [
        'room_service_id',
        'food_id',
        'quantity',
    ];

    public function room_service()
    {
        return $this->belongsTo(RoomService::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

}   
