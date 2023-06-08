<?php

namespace Modules\Inventory\Models;

use App\Models\Tenant\User;
use App\Models\Tenant\ModelTenant;

class TransferPlace extends ModelTenant
{
    protected $table = "transfers_place";
    protected $with = ["detail", "warehouse_destination", "warehouse"];
    protected $fillable = [
        'code',
        'observation',
        'status',
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, "sender_id");
    }
    public function receive()
    {
        return $this->belongsTo(User::class, "receive_id");
    }
    public function detail()
    {
        return $this->hasMany(TransferPlaceDetail::class, "transfers_place_id");
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function warehouse_destination()
    {
        return $this->belongsTo(Warehouse::class, "warehouse_id_destination");
    }
}
