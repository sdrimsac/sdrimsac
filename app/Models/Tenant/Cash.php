<?php

namespace App\Models\Tenant;

use App\Traits\RegisterMovementTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Finance\Models\GlobalPayment;

class Cash extends ModelTenant
{
    use RegisterMovementTrait;
    // protected $with = ['cash_documents'];
    protected $casts = [
        'counter' => 'array',
        'principal' => 'boolean',
    ];
    protected $table = 'cash';
    protected $fillable = [
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
        'difference'

    ];


    protected static function boot()
    {
        parent::boot();
        //created
        static::created(function ($model) {
            $request = Request::capture();
            $description = "Caja abierto";
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
            $description = "Caja actualizado";
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


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //obtiene documentos y notas venta
    public function cash_documents()
    {
        return $this->hasMany(CashDocument::class);
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

    // public function get_ref
}
