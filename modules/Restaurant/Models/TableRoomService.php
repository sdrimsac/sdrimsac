<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\ModelTenant;


class TableRoomService extends ModelTenant
{

    protected $table = "table_room_services";
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $fillable = [
        'table_id',
        'room_service_id',
        'active',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function room_service()
    {
        return $this->belongsTo(RoomService::class);
    }
}
