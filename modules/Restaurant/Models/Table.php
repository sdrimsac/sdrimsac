<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Establishment;
use App\Traits\RegisterMovementTrait;
  use App\Models\Tenant\ModelTenant;
use Illuminate\Http\Request;

class Table extends ModelTenant
{
 use RegisterMovementTrait;
    public $timestamps = false;
    protected $with = ["area", "status_table"];
    protected $fillable = [
        'is_room',
        'floor_id',
        'table_type_id',
        'number',
        'area_id',
        'status_table_id',
        'establishment_id',
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
    
    public function establishment(){
        return $this->belongsTo(Establishment::class);
    }

    public function type(){
        return $this->belongsTo(TableType::class, 'table_type_id');
    }
    public function floor(){
        return $this->belongsTo(Floor::class);
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
