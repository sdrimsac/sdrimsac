<?php

namespace App\Models\Tenant;

use Modules\Restaurant\Models\TableType;

class HotelRentPenaltySetting extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'hotel_rent_penalties_settings';
    protected $with = ['table_type'];
    protected $fillable = [
        'table_type_id',
        'amount_per_day',
        'grace_period_days',
        'is_percentage',
        'active',
    ];

    protected $casts = [
        'is_percentage' => 'boolean',
        'active' => 'boolean',
    ];



    public function table_type()
    {
        return $this->belongsTo(TableType::class);
    }


    

}
