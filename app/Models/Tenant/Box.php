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
    protected $with = ['groups', 'categories', 'subcategories', 'user', 'SaleNote', 'items']; //nombre tablas secundarias - removed document from eager loading
    protected $table = "boxes";                                  //nombre tabla
    protected $primarykey = "id";
    // protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
        'currency_type_id',
        'exchange_rate_sale',
        'operation_number',
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
        // static::created(function ($model) {
        //     $request = Request::capture();
        //     $description = "Registro de caja creado";
        //     $data = $model->toArray();
        //     RegisterMovementTrait::registerCreate(
        //         $model,
        //         $request,
        //         $description,
        //         $data
        //     );
        // });
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
    public static function  createIncome(
        $amount = 0,
        $payment_method_description,
        $description_register,
        $cash_id,
        $sale_note_id = null,
        $document_id = null,
        $sale_note_payment_id = null
    ) {
        $boxes = new Box;
        $company = Company::first();
        $boxes->group_id = 2;
        $boxes->category_id = 2;
        $boxes->subcategory_id = 1;
        $boxes->amount = $amount;
        $boxes->date = date('Y-m-d');
        $boxes->expenses = 1;
        $boxes->type = 2;
        $boxes->state = '1';
        $boxes->method = $payment_method_description;
        $boxes->user_id = auth()->user()->id;
        $boxes->sale_note_id = $sale_note_id;
        $boxes->document_id = $document_id;
        $boxes->description =  $description_register;
        $boxes->soap_type_id = $company->soap_type_id;
        $boxes->sale_note_payment_id = $sale_note_payment_id;
        $boxes->cash_id = $cash_id;
        $boxes->save();
    }
    public static function  createExpense(
        $amount = 0,
        $payment_method_description,
        $description_register,
        $cash_id,
        $sale_note_id = null,
        $document_id = null,
        $sale_note_payment_id = null
    ) {
        $boxes = new Box;
        $company = Company::first();
        $boxes->group_id = 2;
        $boxes->category_id = 2;
        $boxes->subcategory_id = 1;
        $boxes->amount = $amount;
        $boxes->date = date('Y-m-d');
        $boxes->expenses = 1;
        $boxes->type = 2;
        $boxes->state = '1';
        $boxes->method = $payment_method_description;
        $boxes->user_id = auth()->user()->id;
        $boxes->sale_note_id = $sale_note_id;
        $boxes->document_id = $document_id;
        $boxes->description =  $description_register;
        $boxes->soap_type_id = $company->soap_type_id;
        $boxes->sale_note_payment_id = $sale_note_payment_id;
        $boxes->cash_id = $cash_id;
        $boxes->save();
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
        return $this->belongsTo(Document::class, 'document_id', 'id')
            ->select([
                'id',
                'document_type_id',
                'series',
                'number',
                'date_of_issue',
                'customer_id',
                'total',
                'state_type_id',
                'currency_type_id',
                'exchange_rate_sale',
                'total_taxes',
                'total_value',
                'filename',
                'total_exonerated',
                'total_unaffected',
                'total_free',
                'total_taxed',
                'establishment_id',
                'soap_type_id',
                'user_id',
                'total_igv',
                'total_discount',
                'total_isc',
                'payment_condition_id'
            ]);
    }

    // Use this method when you need the document with its relationships
    public function documentWithRelations()
    {
        return $this->belongsTo(Document::class, 'document_id', 'id')
            ->select([
                'id',
                'document_type_id',
                'series',
                'number',
                'date_of_issue',
                'customer_id',
                'total',
                'state_type_id',
                'currency_type_id',
                'exchange_rate_sale',
                'total_taxes',
                'total_value',
                'filename',
                'total_exonerated',
                'total_unaffected',
                'total_free',
                'total_taxed',
                'establishment_id',
                'soap_type_id',
                'user_id',
                'total_igv',
                'total_discount',
                'total_isc',
                'payment_condition_id'
            ])
            ->with([
                'user:id,name,email,type',
                'document_type:id,description,short',
                'currency_type:id,symbol,description',
                'state_type:id,description'
            ]);
    }
    public function SaleNote()
    {
        return $this->belongsTo(SaleNote::class, 'sale_note_id', 'id');
    }
    /* public function SaleNote()
    {
        return $this->belongsTo(SaleNote::class);
    } */

    public function init_stock()
    {
        return $this->hasMany(CashInitReport::class, 'cash_id', 'id');
    }

    public function cash()
    {
        return $this->belongsTo(Cash::class);
    }

    public function cash_transfer()
    {
        return $this->belongsTo(CashTransfer::class, 'cash_transfer_id');
    }

    public function sale_note_payment()
    {
        return $this->belongsTo(SaleNotePayment::class, 'sale_note_payment_id');
    }

    public function document_payment()
    {
        return $this->belongsTo(DocumentPayment::class, 'document_payment_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'id');
    }

    /**
     * Load document with minimal data for reports
     * Avoids loading heavy data like QR codes
     */
    public function documentForReporting()
    {
        return $this->belongsTo(Document::class, 'document_id', 'id')
            ->select([
                'id',
                'document_type_id',
                'series',
                'number',
                'date_of_issue',
                'total',
                'state_type_id',
                'currency_type_id'
            ])
            ->with([
                'document_type:id,description,short'
            ]);
    }
}
