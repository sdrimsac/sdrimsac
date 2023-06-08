<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Catalogs\UnitType;

use App\Models\Tenant\ModelTenant;

class BoxesItemDetail extends ModelTenant
{

    public $timestamps = true;
    protected $table = "expenses_incomes_items";

    protected $fillable = [
        'unit_id',
        'detail',
    ];


    public function unit_type()
    {
        return $this->belongsTo(UnitType::class, 'unit_id');
    }
}
