<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\User;
use App\Traits\HelperTrait;
use App\Traits\RegisterMovementTrait;
  use App\Models\Tenant\ModelTenant;
use Illuminate\Http\Request;

class OrdenItem extends ModelTenant
{
    use HelperTrait, RegisterMovementTrait;

    public $timestamps = false;
    protected $table = "orden_item";
    protected $with = ['food'];

    protected $fillable = [
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

    public function info_item(){
        $food  = $this->food->description;
        $price = "S/.". number_format($this->price, 2);
        $quantity = $this->quantity;
        return "*".$quantity." - ".$food." - ".$price."*";
    }
    public function info_to_message($reason = null){
        $message = "🚨🚨🚨 Se acaba de cancelar un item de la orden N°: *".$this->orden->id."*, el item eliminado es *". $this->food->description."* con el precio de S/. *".number_format($this->price, 2)."* y la cantidad de *".$this->quantity."*";

        if($reason){
            $message .= " por el motivo: *".$reason."*";
        }
        $message .= " por el usuario: *".auth()->user()->name."*";

        $message .= " 🚨🚨🚨";
        return $message;
    }

    public function status_orden(){

        return  $this->belongsTo(StatusOrden::class);
    }
    public function food()
    {
        return  $this->belongsTo(Food::class);
    }
    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
