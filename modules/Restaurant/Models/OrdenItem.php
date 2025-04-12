<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\User;
use App\Traits\HelperTrait;
use App\Traits\RegisterMovementTrait;
use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenItem extends ModelTenant
{
    use HelperTrait, RegisterMovementTrait;

    public $timestamps = false;
    protected $table = "orden_item";
    protected $with = ['food'];

    protected $fillable = [
        'name_product_pdf',
        'date',
        'time',
        'observations',
        'orden_id',
        'item_id',
        'status_orden_id',
        'area_id',
        'quantity',
        'user_id',
        'price',
    ];
    protected static function boot()
    {
        parent::boot();
        //created
        static::created(function ($orden_item) {
            $request = Request::capture();
            $description = "Orden item creado: Solicitado";
            RegisterMovementTrait::registerCreate(
                $orden_item,
                $request,
                $description,
                $orden_item->toArray()
            );
        });
        static::updated(function ($orden_item) {
            $request = Request::capture();
            $description = "Orden item en preparación";
            $newStatus = $orden_item->status_orden->description;
            $description = "Orden item actualizado: $newStatus";
            RegisterMovementTrait::registerUpdate(
                $orden_item,
                $request,
                $description,
                $orden_item->toArray()
            );
        });

        static::deleted(
            function ($orden_item) {
                $request = Request::capture();
                $description = "Orden item eliminado";
                $data = [];
                $data['orden_id'] = $orden_item->orden_id;
                $data['food_id'] = $orden_item->food_id;
                $data['status_orden_id'] = $orden_item->status_orden_id;
                $data['area_id'] = $orden_item->area_id;
                $data['quantity'] = $orden_item->quantity;
                $data['price'] = $orden_item->price;
                $data['observations'] = $orden_item->observations;
                RegisterMovementTrait::registerDelete(
                    $orden_item,
                    $request,
                    $description,
                    $data
                );
            }

        );
    }
    public function stockRestaurant()
    {
        $configuration = Configuration::first();
        if ($configuration->restaurant && $configuration->hot) {
            $establishment_id = auth()->user()->establishment_id;
            $warehouse = Warehouse::where('establishment_id', $establishment_id)->first();
            $warehouse_id = $warehouse->id;
            $item_id = $this->food->item_id;
            $quantity = $this->quantity;
            ItemWarehouse::where('item_id', $item_id)
                ->where('warehouse_id', $warehouse_id)
                ->decrement('stock', $quantity);
            DB::connection('tenant')->table('stock_order_item')
                ->insert([
                    'order_item_id' => $this->id,
                ]);
        }
    }
    public function restoreRestaurant()
    {
        $configuration = Configuration::first();
        if ($configuration->restaurant) {
            $orden = $this->orden;
            $table = $orden->mesa;
            $establishment = $table->establishment_id;
            $warehouse = Warehouse::where('establishment_id', $establishment)->first();
            $exist = DB::connection('tenant')->table('stock_order_item')
                ->where('order_item_id', $this->id)
                ->first();
            if($exist){
                

            }
            if($warehouse){
                
            }
            if ($warehouse && $exist) {
                $warehouse_id = $warehouse->id;
                $item_id = $this->food->item->id;
                $quantity = $this->quantity;
                
                
                ItemWarehouse::where('item_id', $item_id)
                    ->where('warehouse_id', $warehouse_id)
                    ->increment('stock', $quantity);
                DB::connection('tenant')->table('stock_order_item')
                    ->where('order_item_id', $this->id)
                    ->delete();
            }
        }
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }
    public function info_item()
    {
        $food  = $this->food->description;
        $price = "S/." . number_format($this->price, 2);
        $quantity = $this->quantity;
        return "*" . $quantity . " - " . $food . " - " . $price . "*";
    }
    public function info_to_message($reason = null)
    {
        $message = "🚨🚨🚨 Se acaba de cancelar un item de la orden N°: *" . $this->orden->id . "*, el item eliminado es *" . $this->food->description . "* con el precio de S/. *" . number_format($this->price, 2) . "* y la cantidad de *" . $this->quantity . "*";

        if ($reason) {
            $message .= " por el motivo: *" . $reason . "*";
        }
        $message .= " por el usuario: *" . auth()->user()->name . "*";

        $message .= " 🚨🚨🚨";
        return $message;
    }

    public function status_orden()
    {

        return  $this->belongsTo(StatusOrden::class);
    }
    public function food()
    {
        return  $this->belongsTo(Food::class);
    }
    public function user()
    {
        return  $this->belongsTo(User::class, "user_id");
    }

    public function orden()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }
    public function ordens_delete()
    {
        return $this->hasMany(OrdenDelete::class, 'orden_item_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function getUsuarioCuandoOcupado()
    {
        return $this->orden && $this->orden->estatus_orden_id == 'ocupado'
            ? $this->user
            : null;
    }
}
