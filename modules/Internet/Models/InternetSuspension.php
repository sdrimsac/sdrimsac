<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;

class InternetSuspension extends ModelTenant
{
    public $timestamps = true;
    protected $table = "internet_history_suspension";
    protected $fillable = [
        'description',
        'suspend_date',
        'reconnect_date',
        'register_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function register()
    {
        return $this->belongsTo(InternetRegister::class);
    }
}
