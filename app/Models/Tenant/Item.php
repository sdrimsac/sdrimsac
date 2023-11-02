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
    public function getCurrentItemWarehouse($warehouse_id)
    {
        return $this->warehouses()->where('warehouse_id', $warehouse_id);
    }
    public function getDataToItemModal($warehouse = null,$with_lots_has_sale = false,$extended_description = false,$series = null,$search_item_by_series = false,$aditional_data = true) {
        $configuration = Configuration::first();
        if ($warehouse == null) {
            $establishment_id = auth()->user()->establishment_id;
            $warehouse = Warehouse::where('establishment_id', $establishment_id)->first();
        }
        $detail = $this->getFullDescription($warehouse, $extended_description);
        $realtion_item_unit_types = $this->item_unit_types;
        $lots_grp = $this->lots_group;

        $lots = $this->getLotsBySerie($warehouse, $series, $search_item_by_series);
        $blank = [];
        $currentColors = collect($blank);
        $ItemUnitsPerPackage = collect($blank);
        $ItemMoldProperty = collect($blank);
        $ItemProductFamily = collect($blank);
        $ItemMoldCavity = collect($blank);
        $ItemPackageMeasurement = collect($blank);
        $ItemStatus = collect($blank);
        $ItemSize = collect($blank);
        $ItemUnitBusiness = collect($blank);

        if ($aditional_data === true) {
            $currentColors = [];
            $ItemUnitsPerPackage = [];
            $ItemMoldProperty = [];


            $ItemProductFamily = [];
            $ItemMoldCavity = [];
            $ItemPackageMeasurement = [];
            $ItemStatus = [];
            $ItemUnitBusiness = [];

            $ItemSize = [];
        }

        if ($with_lots_has_sale == true) {
            $lots = $this->item_lots->where('has_sale', false)->transform(function ($row) {
                return [
                    'id'           => $row->id,
                    'series'       => $row->series,
                    'date'         => $row->date,
                    'item_id'      => $row->item_id,
                    'warehouse_id' => $row->warehouse_id,
                    'has_sale'     => (bool)$row->has_sale,
                    'lot_code'     => ($row->item_loteable_type)
                        ?
                        (isset($row->item_loteable->lot_code)
                            ?
                            $row->item_loteable->lot_code
                            :
                            null)
                        :
                        null,
                ];
            })->values();
        }
        $stock = $detail['stock'];

        // Obtiene el stock basado el en almacen itemwarehouse
        $stockItemWarehouse = $this->getCurrentItemWarehouse($warehouse->id)->first();
        if (is_object($stockItemWarehouse)) {
            $stock = $stockItemWarehouse->stock;
        }

        $stockPerCategory = ItemMovement::getStockByCategory($this->id, auth()->user()->establishment_id);
        $currency = $this->currency_type;
        if (empty($currency)) {
            $currency = new CurrencyType();
        }

        $purchase_unit_price = $this->purchase_unit_price;
        $purchase_unit_value = $this->purchase_unit_price;
        
        if ($this->purchase_affectation_igv_type_id == '10') {
            $purchase_unit_value = round($purchase_unit_price / 1.18, 8);
        } 
        // else {
        //     
        // }

        $data = [
            'id'                               => $this->id,
            'item_code'                    => $this->item_code,
            'full_description'                 => $detail['full_description'],
            'model'                            => $this->model,
            'brand'                            => $detail['brand'],
            'text_filter' => $this->text_filter,
            'stock_by_extra'                            =>  $stockPerCategory,
            'warehouse_description'            => $detail['warehouse_description'],
            'extra'                         => collect([
                'colors' => null,
                'CatItemUnitsPerPackage' => null,
                'CatItemMoldProperty' => null,
                'CatItemProductFamily' => null,
                'CatItemMoldCavity' => null,
                'CatItemPackageMeasurement' => null,
                'CatItemStatus' => null,
                'CatItemSize' => null,
                'CatItemUnitBusiness' => null,
            ]),
            'category'                         => $detail['category'],
            'stock'                            => $stock,
            'internal_id'                      => $this->internal_id,
            'description'                      => $this->description,
            'info_link'                       => $this->info_link,
            'currency_type_id'                 => $this->currency_type_id,
            'currency_type_symbol'             => $currency->symbol,
            'has_igv'                          => (bool)$this->has_igv,
            //number_format($row->total, $configuration->decimal_quantity, ".", ""),
            'sale_unit_price'                  => number_format(self::getSaleUnitPriceByWarehouse($this, $warehouse->id), $configuration->decimal_quantity, ".", ""),
            'purchase_has_igv'                 => $this->purchase_has_igv,
            'purchase_unit_value'              => $purchase_unit_value,
            'purchase_unit_price'              => $purchase_unit_price,
            'unit_type_id'                     => $this->unit_type_id,
            'original_unit_type_id'                     => $this->unit_type_id,
            'sale_affectation_igv_type'     => $this->sale_affectation_igv_type,
            'sale_affectation_igv_type_id'     => $this->sale_affectation_igv_type_id,
            'purchase_affectation_igv_type_id' => $this->purchase_affectation_igv_type_id,
            'calculate_quantity'               => (bool)$this->calculate_quantity,
            'has_plastic_bag_taxes'            => (bool)$this->has_plastic_bag_taxes,
            'amount_plastic_bag_taxes'         => $this->amount_plastic_bag_taxes,
            'colors' => $currentColors,
            'CatItemUnitsPerPackage' => $ItemUnitsPerPackage,
            'CatItemMoldProperty' => $ItemMoldProperty,
            'CatItemProductFamily' => $ItemProductFamily,
            'CatItemMoldCavity' => $ItemMoldCavity,
            'CatItemPackageMeasurement' => $ItemPackageMeasurement,
            'CatItemStatus' => $ItemStatus,
            'CatItemSize' => $ItemSize,
            'CatItemUnitBusiness' => $ItemUnitBusiness,
            'item_unit_types'                  => $this->item_unit_types->transform(function ($item_unit_types) {
                if (is_array($item_unit_types)) {
                    return $item_unit_types;
                }
                return [
                    'id'            => $item_unit_types->id,
                    'description'   => "{$item_unit_types->description}",
                    'item_id'       => $item_unit_types->item_id,
                    'unit_type_id'  => $item_unit_types->unit_type_id,
                    'quantity_unit' => $item_unit_types->quantity_unit,
                    'price1'        => $item_unit_types->price1,
                    'price2'        => $item_unit_types->price2,
                    'price3'        => $item_unit_types->price3,
                    'price_default' => $item_unit_types->price_default,
                    'factor_default' => (bool) $item_unit_types->factor_default,
                    'barcode' => $item_unit_types->barcode,
                ];
            }),
            'warehouses' => collect($this->warehouses)->transform(function ($warehouses) use ($warehouse) {
                return [
                    'warehouse_description' => $warehouses->warehouse->description,
                    'stock'                 => (!empty($warehouses->stock)) ? $warehouses->stock : 0,
                    'warehouse_id'          => $warehouses->warehouse_id,
                    'checked'               => ($warehouses->warehouse_id == $warehouse->id) ? true : false,
                ];
            }),
            // se listaran atributos necesarios en pdf de otra forma
            'attributes'     => $this->getAttributesAttribute($this->attributes['attributes']),
            'lots_group'     => collect($lots_grp)->transform(function ($lots_group) {
                return [
                    'id'          => $lots_group->id,
                    'code'        => $lots_group->code,
                    'quantity'    => $lots_group->quantity,
                    'date_of_due' => $lots_group->date_of_due,
                    'checked'     => false,
                    'compromise_quantity' => 0
                ];
            }),
            'lots'           => $lots,
            'lots_enabled'   => (bool)$this->lots_enabled,
            'series_enabled' => (bool)$this->series_enabled,
            'is_set'         => (bool)$this->is_set,

            'lot_code'    => $this->lot_code,
            'date_of_due' => $this->date_of_due,
            'barcode'     => $this->barcode,
            'change_free_affectation_igv'     => false,
            'original_affectation_igv_type_id'     => $this->sale_affectation_igv_type_id,

            'has_isc' => (bool)$this->has_isc,
            'system_isc_type_id' => $this->system_isc_type_id,
            'percentage_isc' => $this->percentage_isc,
            'is_for_production' => false,
            'subject_to_detraction' => $this->subject_to_detraction,
            'exchange_points' => $this->exchange_points,
            'quantity_of_points' => $this->quantity_of_points,
            'exchanged_for_points' => false, //para determinar si desea canjear el producto
            'used_points_for_exchange' => null, //total de puntos
            'factory_code' => $this->factory_code,
            'restrict_sale_cpe' => $this->restrict_sale_cpe,

        ];

        // El nombre de producto, por defecto, sera la misma descripcion.
        // $data['name_product_pdf'] =$data['description'];

        return $data;
    }
    private function getLotsBySerie($warehouse, $series,  $search_item_by_series)
    {
        $lots = [];


        if ($search_item_by_series) {

            $lots = $this->item_lots()->where('has_sale', false)
                ->where('warehouse_id', $warehouse->id)
                ->where('series', $series)
                ->take(1)
                ->get();

            // dd($search_item_by_series, $lots, $this->item_lots);
        }

        return $lots;
    }
    public function getFullDescription($warehouse, $extended = false)
    {

        $desc = ($this->internal_id) ? $this->internal_id . ' - ' . $this->description : $this->description;
        $category = ($this->category) ? "{$this->category->name}" : '';
        $brand = ($this->brand) ? "{$this->brand->name}" : '';
        if ($this->unit_type_id != 'ZZ') {
            if (isset($this['stock'])) {
                $warehouse_stock = number_format($this['stock'], 2);
            } else {
                $warehouse_stock = ($this->warehouses && $warehouse)
                    ?
                    number_format($this->warehouses->where('warehouse_id', $warehouse->id)->first()->stock, 2)
                    :
                    0;
            }
            $stock = ($this->warehouses && $warehouse) ? "{$warehouse_stock}" : '';
        } else {
            $stock = '';
        }
        if ($extended == false) {
            $desc = "{$desc} - {$brand}";
        } else {
            $desc = "{$desc} - {$category} - {$brand}";
        }
        return [
            'full_description'      => $desc,
            'brand'                 => $brand,
            'category'              => $category,
            'stock'                 => $stock,
            'warehouse_description' => $warehouse->description,
        ];
    }
    public function warehousePrices()
    {
        return $this->hasMany(ItemWarehousePrice::class, 'item_id')->select('id', 'item_id', 'price', 'warehouse_id');
    }
    public static function getSaleUnitPriceByWarehouse(Item $item, int $warehouseId): string
    {
        $warehousePrice = $item->warehousePrices->where('item_id', $item->id)
            ->where('warehouse_id', $warehouseId)
            ->first();

        $price = $warehousePrice->price ?? $item->sale_unit_price;
        return number_format($price, 4, ".", "");
    }
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

    public function checkSeries(){
        collect($this->warehouses)->transform(function ($warehouse)  {
            $warehouses_series = ItemLot::where('item_id', $this->id)->where('warehouse_id', $warehouse->warehouse_id)
            ->where('has_sale', false)->count();
            if($warehouse->stock != $warehouses_series){
                $warehouse->stock = $warehouses_series;
                $warehouse->save();
            }
        });
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
