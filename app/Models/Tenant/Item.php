<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Catalogs\CurrencyType;
use App\Models\Tenant\Catalogs\SystemIscType;
use App\Models\Tenant\Catalogs\UnitType;
use Illuminate\Database\Eloquent\Model;
use Modules\Format\Models\Account;
use Modules\Item\Models\CategoryItem;
use Modules\Item\Models\Brand;
use Modules\Item\Models\ItemLot;
use Modules\Item\Models\ItemLotsGroup;
use Modules\Restaurant\Models\Food;

class Item extends ModelTenant
{
    protected $with = ['item_warehouse_prices', 'item_type', 'unit_type', 'currency_type', 'warehouses', 'item_unit_types', 'category', 'lots_group'];
    protected $fillable = [
        'max_quantity_description',
        'delivery_cost',
        'warehouse_id',
        'name',
        'second_name',
        'max_quantity',
        'barcode',
        'description',
        'item_type_id',
        'internal_id',
        'item_code',
        'item_code_gs1',
        'unit_type_id',
        'currency_type_id',
        'sale_unit_price',
        'purchase_unit_price',
        'has_isc',
        'system_isc_type_id',
        'percentage_isc',
        'suggested_price',

        'sale_affectation_igv_type_id',
        'purchase_affectation_igv_type_id',
        'calculate_quantity',
        'has_igv',
        'is_stock',
        'stock',
        'stock_min',
        'percentage_of_profit',

        'attributes',
        'has_perception',
        'percentage_perception',
        'image',
        'image_medium',
        'image_small',

        'account_id',
        'amount_plastic_bag_taxes',
        'date_of_due',
        'is_set',
        'sale_unit_price_set',
        'apply_store',
        'brand_id',
        'category_id',
        'lot_code',
        'lots_enabled',
        'active',
        'series_enabled',
        'location',
        'has_orden_compra',
        'is_promotion',
        'promotion_count'
        // 'warehouse_id'
    ];

    /*protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('active', 1);
        });
    }*/

    public function food(){
        return $this->hasOne(Food::class);
    }

    public function getDataWarehouses()
    {
        return collect($this->warehouses)->transform(function ($row) {
            return [
                'warehouse_description' => $row->warehouse->description,
                'stock' => $row->stock,
                'warehouse_id' => $row->warehouse_id,
                'id' => $row->id,
            ];
        });
    }
    public static function AffectationIgvTypesExoneratedUnaffected()
    {
        return ['20', '21', '30', '31', '32', '33', '34', '35', '36', '37'];
    }
    public function scopePharmacy($query)
    {
        return $query
            ->whereNotNull('items.cod_digemid')
            ->select('items.*')
            ->join('cat_digemid', 'cat_digemid.item_id', '=', 'items.id');
    }
    public function getAttributesAttribute($value)
    {
        return (is_null($value)) ? null : json_decode($value);
    }

    public function setAttributesAttribute($value)
    {
        $this->attributes['attributes'] = (is_null($value)) ? null : json_encode($value);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function item_type()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function unit_type()
    {
        return $this->belongsTo(UnitType::class, 'unit_type_id');
    }

    public function currency_type()
    {
        return $this->belongsTo(CurrencyType::class, 'currency_type_id');
    }

    public function system_isc_type()
    {
        return $this->belongsTo(SystemIscType::class, 'system_isc_type_id');
    }

    public function kardex()
    {
        return $this->hasMany(Kardex::class);
    }
    public function item_warehouse_prices()
    {
        return $this->hasMany(ItemWarehousePrice::class);
    }
    public function inventory_kardex()
    {
        return $this->hasMany(InventoryKardex::class);
    }

    public function purchase_item()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function sale_affectation_igv_type()
    {
        return $this->belongsTo(AffectationIgvType::class, 'sale_affectation_igv_type_id');
    }

    public function purchase_affectation_igv_type()
    {
        return $this->belongsTo(AffectationIgvType::class, 'purchase_affectation_igv_type_id');
    }

    public function scopeWhereWarehouse($query)
    {
        $establishment_id = auth()->user()->establishment_id;
        $warehouse = Warehouse::where('establishment_id', $establishment_id)->first();
        if ($warehouse) {
            return $query->whereHas('warehouses', function ($query) use ($warehouse) {
                $query->where('warehouse_id', $warehouse->id);
            })->orWhere('unit_type_id', 'ZZ');
        }
        return $query;
    }

    public function scopeWhereTypeUser($query)
    {
        $user = auth()->user();
        return ($user->type == 'seller') ? $this->scopeWhereWarehouse($query) : null;
    }

  

    public function scopeWhereNotIsSet($query)
    {
        return $query->where('is_set', false);
    }

    public function scopeWhereIsActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeWhereIsSet($query)
    {
        return $query->where('is_set', true);
    }

    public function getStockByWarehouse()
    {
        if (auth()->user()) {
            $establishment_id = auth()->user()->establishment_id;
            $warehouse = Warehouse::where('establishment_id', $establishment_id)->first();
            if ($warehouse) {
                $item_warehouse = $this->warehouses->where('warehouse_id', $warehouse->id)->first();
                return ($item_warehouse) ? $item_warehouse->stock : "0";
            }
        }

        return "0";
    }

    public function warehouses()
    {
        return $this->hasMany(ItemWarehouse::class)->with('warehouse');
    }


    public function item_unit_types()
    {
        return $this->hasMany(ItemUnitType::class);
    }



    public function sets()
    {
        return $this->hasMany(ItemSet::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryItem::class);
    }

    public function item_lots()
    {
        return $this->hasMany(ItemLot::class, 'item_id');
    }

    public function lots()
    {
        return $this->morphMany(ItemLot::class, 'item_loteable');
    }

    public  function images()
    {
        return $this->hasMany(ItemImage::class, 'item_id');
    }

    public function lots_group()
    {
        return $this->hasMany(ItemLotsGroup::class, 'item_id');
    }


    public function scopeWhereNotService($query)
    {
        return $query->where('unit_type_id', '!=', 'ZZ');
    }

    public  function document_items()
    {
        return $this->hasMany(DocumentItem::class, 'item_id');
    }

    public  function sale_note_items()
    {
        return $this->hasMany(SaleNoteItem::class, 'item_id');
    }

    public function scopeWhereFilterValuedKardex($query, $params)
    {

        if ($params->establishment_id) {

            return $query->with([
                'document_items' => function ($q) use ($params) {
                    $q->whereHas('document', function ($q) use ($params) {
                        $q->whereStateTypeAccepted()
                            ->whereTypeUser()
                            ->whereBetween('date_of_issue', [$params->date_start, $params->date_end])
                            ->where('establishment_id', $params->establishment_id);
                    });
                },
                'sale_note_items' => function ($q) use ($params) {
                    $q->whereHas('sale_note', function ($q) use ($params) {
                        $q->whereStateTypeAccepted()
                            ->whereNotChanged()
                            ->whereTypeUser()
                            ->whereBetween('date_of_issue', [$params->date_start, $params->date_end])
                            ->where('establishment_id', $params->establishment_id);
                    });
                }
            ]);
        }

        return $query->with([
            'document_items' => function ($q) use ($params) {
                $q->whereHas('document', function ($q) use ($params) {
                    $q->whereStateTypeAccepted()
                        ->whereTypeUser()
                        ->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
                });
            },
            'sale_note_items' => function ($q) use ($params) {
                $q->whereHas('sale_note', function ($q) use ($params) {
                    $q->whereStateTypeAccepted()
                        ->whereNotChanged()
                        ->whereTypeUser()
                        ->whereBetween('date_of_issue', [$params->date_start, $params->date_end]);
                });
            }
        ]);
    }

    public function scopeWhereIsNotActive($query)
    {
        return $query->where('active', false);
    }

    public function scopeWhereHasInternalId($query)
    {
        return $query->where('internal_id', '!=', null);
    }
}
