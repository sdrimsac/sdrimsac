<?php

namespace App\Models\Tenant;

use App\Models\Tenant\User;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Traits\RegisterMovementTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Restaurant\Models\BoxesDetail;

class Box extends ModelTenant
{
    use RegisterMovementTrait;
    protected $with = ['groups', 'categories', 'subcategories', 'user', 'document', 'salenote']; //nombre tablas secundarias
    protected $table = "boxes";                                  //nombre tabla
    protected $primarykey = "id";
    // protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
        'bank_account_operation',
        'bank_account_id',
        'user_id',
        'group_id',                         //grupos
        'category_id',                     //categorias
        'subcategory_id',                  //subcategorias
        'amount',                         // monto
        'date',                           //fecha
        'description',                    //descripcion
        'close',
        'type',                           //Ingreso / Egreso
        'state',                           //Estado,
        'soap_type_id',
        'sale_note_id',
        'document_id',
        'method',
        'purchase_id',
        'document_payment_id',
        'sale_note_payment_id',
        'establishment_id',
        'incomes',
        'expenses',
        'cash_id'
    ];

    protected static function boot()
    {
        parent::boot();
        //created
        static::created(function ($model) {
            $request = Request::capture();
            $description = "Registro de caja creado";
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
            $original_model = Box::find($model->id);
            $description = "Registro de caja actualizado";
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

    public function groups()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function subcategories()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(BoxesDetail::class, 'boxes_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }
    public function salenote()
    {
        return $this->belongsTo(salenote::class, 'sale_note_id', 'id');
    }

    public function cash()
    {
        return $this->belongsTo(Cash::class);
    }
}
