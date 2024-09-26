<?php

namespace Modules\Restaurant\Models;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\HotelRent;
use App\Models\Tenant\HotelRentItem;
use App\Traits\RegisterMovementTrait;
use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\NumberActivity;
use Exception;
use Illuminate\Http\Request;

class Billar extends ModelTenant
{
    protected $table = 'casino';
    protected $with = ["type", "area", "status_table"];  
    protected $fillable = [
        'active',
        'table_id',
        'customer_id',
        'reference',
        'date_star',
        'time_start',
        'minutes',
        'date_end',
        'time_end',
    ];
    protected $casts = [
        'active' => 'boolean',
    ];
    public static function get_caja()
    {
        $user = auth()->user();
        $establishment_id = $user->establishment_id;
        $table = Table::where('establishment_id', $establishment_id)->where('has_billar', false)
            ->where('number', 'like', 'CAJA%')->first();
        if ($table) return $table->id;
        //crear una tabla
        $table = new Table();
        $table->establishment_id = $establishment_id;
        $table->is_room = false;
        $table->status_table_id = 1;
        $table->number = "CAJA";
        $area_id = Area::getAreaCajaId();
        if ($area_id == null) {
            throw new Exception("No se encontro el area de la caja");
        }
        $table->area_id = $area_id;
        $table->save();

        return $table->id;


        // return null;
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function type()
    {
        return $this->belongsTo(TableType::class, 'table_type_id');
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
