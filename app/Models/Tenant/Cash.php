<?php

namespace App\Models\Tenant;

use App\Traits\RegisterMovementTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Finance\Models\GlobalPayment;
use Modules\Restaurant\Models\Turns;
use Carbon\Carbon;

class Cash extends ModelTenant
{
    use RegisterMovementTrait;
    // protected $with = ['cash_documents'];
    protected $casts = [
        'bill_series' => 'array',
        'counter' => 'array',
        'principal' => 'boolean',
        'is_loading_report' => 'boolean',

    ];
    protected $table = 'cash';
    protected $fillable = [
        'is_loading_report',
        'cash_type_id',
        'group_code',
        'bill_series',
        'stock_file',
        'principal',
        'user_id',
        'date_opening',
        'time_opening',
        'date_closed',
        'time_closed',
        'beginning_balance',
        'final_balance',
        'income',
        'state',
        'reference_number',
        'counter',
        'turn_id',
        'difference',
        'pharmacy_info'

    ];


    protected static function boot()
    {
        parent::boot();
        //created
        static::created(function ($model) {
            $request = Request::capture();
            $description = "Caja abierta";
            $original_model = Cash::find($model->id);
            $original_model->set_or_create_code();
            $data = $model->toArray();
            RegisterMovementTrait::registerCreate(
                $model,
                $request,
                $description,
                $data
            );
        });
        static::updated(function ($model) {
            $request = Request::capture();
            $original_model = Cash::find($model->id);
            $description = "Caja cerrada";
            $data = $original_model->toArray();
            RegisterMovementTrait::registerUpdate(
                $model,
                $request,
                $description,
                $data
            );
        });

        static::deleted(
            function ($model) {
                $request = Request::capture();
                $description = "Registro de caja eliminado";
                $data = $model->toArray();
                RegisterMovementTrait::registerDelete(
                    $model,
                    $request,
                    $description,
                    $data
                );
            }

        );
    }
    public function getPharmacyInfoAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setPharmacyInfoAttribute($value)
    {
        $this->attributes['pharmacy_info'] = (is_null($value)) ? null : json_encode($value);
    }
    public function cash_transfers()
    {
        return $this->hasMany(CashTransfer::class, 'cash_principal_id','id');
    }
    public function turn()
    {
        return $this->belongsTo(Turns::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //obtiene documentos y notas venta
    public function cash_documents()
    {
        return $this->hasMany(CashDocument::class);
    }
    function create_code($after = false)
    {
        $date = Carbon::now('America/Lima')->format('Y-m-d');
        if ($after) {
            $date = Carbon::parse($date)->addDay()->format('Y-m-d');
        }
        $date = str_replace('-', '', $date);
        $code = $date;
        return $code;
    }
    function set_or_create_code()
    {
        $user = User::find($this->user_id);
        $establishment_id = $user->establishment_id;
        $configuration = Configuration::first();
        if ($configuration->turn_principal) {
            $turn_id = $configuration->turn_principal;
            //si la caja actual tiene el  id del turno principal
            if ($this->turn_id == $turn_id) {
                if ($turn_id != 3) {
                    $code = $this->create_code(true);
                } else {
                    $code = $this->create_code();
                }
                $this->group_code = $code;
                $this->save();
            } else {
                //se busca la ultima caja con el id del turno principal y se obtiene el codigo
                $last_cash = Cash::where('turn_id', $turn_id)
                    ->whereHas('user', function ($query) use ($establishment_id) {
                        $query->where('establishment_id', $establishment_id);
                    })->orderBy('id', 'desc')->first();
                if ($last_cash) {
                    $this->group_code = $last_cash->group_code;
                    $this->save();
                }
            }
        }
    }

    public function scopeWhereTypeUser($query, $fromAdmin)
    {
        $user = auth()->user();
        if ($fromAdmin) {
            return $query->where('user_id', $user->id);
        }
        return ($user->type == 'seller') ? $query->where('user_id', $user->id) : null;
    }

    public function global_destination()
    {
        return $this->morphMany(GlobalPayment::class, 'destination');
    }
    public function boxes()
    {
        return $this->hasMany(Box::class);
    }
    // public function get_ref
}
