<?php

namespace Modules\Restaurant\Models;
use App\Models\Tenant\ModelTenant;


class RoomService extends ModelTenant
{

    protected $table = "room_services";
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $fillable = [
        'name',
        'description',
        'has_items',
        'active',
    ];

    public function items()
    {
        return $this->hasMany(ItemRoomService::class);
    }

}
