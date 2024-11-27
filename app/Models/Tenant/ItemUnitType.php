<?php

namespace App\Models\Tenant;

use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Catalogs\CurrencyType;
use App\Models\Tenant\Catalogs\SystemIscType;
use App\Models\Tenant\Catalogs\UnitType;
use Illuminate\Database\Eloquent\Model;

class ItemUnitType extends ModelTenant
{
    protected $with = ['unit_type'];
    public $timestamps = false;

    protected $fillable = [
        'description',
        'item_id',
        'unit_type_id',
        'quantity_unit',
        'qty_min',
        'qty_max',
        'qty_free',
        'price1',
        'price2',
        'price3',
        'price_default',
        'warehouse_id',
        'total',
    ];

    protected $casts = [
        'price1' => 'decimal:2',
        'price2' => 'decimal:2',
        'price3' => 'decimal:2',
        
    ];

    public function unit_type()
    {
        return $this->belongsTo(UnitType::class, 'unit_type_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
