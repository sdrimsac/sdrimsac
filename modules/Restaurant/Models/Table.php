<?php

namespace Modules\Restaurant\Models;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\HotelRentItem;
use App\Traits\RegisterMovementTrait;
  use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\NumberActivity;
use Illuminate\Http\Request;

class Table extends ModelTenant
{
 use RegisterMovementTrait;
    public $timestamps = false;
    protected $with = ["type","area", "status_table","floor"];
    protected $fillable = [
        'month_price',
        'is_cleaning',
        'cleaning_start_date',
        'is_room',
        'floor_id',
        'table_type_id',
        'number',
        'area_id',
        'status_table_id',
        'establishment_id',
        'price',
        'description'
    ];
    protected $casts = [
        'is_cleaning' => 'boolean',
    ];
    protected static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
        

            // Lógica adicional utilizando la información obtenida
        });
        //created
        static::created(function ($table) {
            $request = Request::capture();
            $description = "Mesa creada";
            RegisterMovementTrait::registerCreate(
               $table,
                $request,
                $description,
                $table->toArray()
            );
        });
        static::updated(function ($table) {
         
            ////
            $request = Request::capture();
            $description = null;
            $table_origin = Table::find($table->id);
           
            $newStatus = $table_origin->status_table->description;
            $description = "Mesa actualizada: $newStatus";
            RegisterMovementTrait::registerUpdate(
               $table,
                $request,
                $description,
                $table->toArray()
            );
        });
        static::deleted(
            function ($table) {
                $request = Request::capture();
                $description = "Mesa eliminada";
                $data = [];
                $data['area_id'] = $table->area_id;
                $data['number'] = $table->number;
                RegisterMovementTrait::registerDelete(
                   $table,
                    $request,
                    $description,
                    $data
                );
            }

        );
    }

    public  function maintenance(){
        return $this->hasMany(TableUserMaintenance::class);
    }
    public  function services(){
        return $this->hasMany(TableRoomService::class);
    }
    public  function last_hotel_rent_item(){
        return $this->hasOne(HotelRentItem::class)->latestOfMany();
    }
    public  function hotel_rent_items(){
        return $this->hasMany(HotelRentItem::class);
    }
    public static function get_caja(){
        $user = auth()->user();
        $establishment_id = $user->establishment_id;
        $table = Table::where('establishment_id',$establishment_id)->where('is_room',false)
        ->where('number','like','CAJA%')->first();
        if($table) return $table->id;
        return null;
    }
 
    public function establishment(){
        return $this->belongsTo(Establishment::class);
    }

    public function type(){
        return $this->belongsTo(TableType::class, 'table_type_id');
    }
    public function floor(){
        return $this->belongsTo(Floor::class);
    }

    public function sendMessageDesocupied($word = "desocupada"){
            if($this->is_room){
                $number = $this->number;
                $tower = $this->floor->tower->name;
                $message = "La habitación $number - $tower ha sido $word";
                $configuration = Configuration::first();
                $number_activity = $configuration->number_activity;
                $numbers_activity = NumberActivity::all();
                if($number_activity){
                    (new WhatsappController)->sendMessage($message,$number_activity);
                }
                foreach ($numbers_activity as $number) {
                    (new WhatsappController)->sendMessage($message,$number->number);
                }
            }
    }
  
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function status_table()
    {
        return $this->belongsTo(StatusTable::class);
    }

 

    
}
