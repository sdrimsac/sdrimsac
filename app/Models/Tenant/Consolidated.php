<?php

namespace App\Models\Tenant;

use Modules\Dispatch\Models\Driver;
use Modules\Dispatch\Models\Transport;

class Consolidated extends ModelTenant

{
    // public $timestamps = false;
    protected $table = "consolidated";
    protected $fillable = [
        "user_id",
        "establishment_id",
        "date_of_issue",
        "weight",
        "transport_id",
        "driver_id"

    ];

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
 
}
