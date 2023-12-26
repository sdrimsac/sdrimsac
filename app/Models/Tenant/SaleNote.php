<?php

namespace App\Models\Tenant;

use App\Models\Tenant\Catalogs\CurrencyType;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Traits\RegisterMovementTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SaleNote extends ModelTenant

{
    use RegisterMovementTrait;
    protected $with = ['user', 'soap_type', 'state_type', 'currency_type', 'items', 'document_type'];

    protected $fillable = [
        'credit_cash',
        'to_carry',
        'seller_id',
        'from_consignment',
        'user_id',
        'external_id',
        'establishment_id',
        'establishment',
        'soap_type_id',
        'state_type_id',
        'month',
        'prefix',
        'document_type_id',
        'advances',
        'total_advances',
        'date_of_issue',
        'time_of_issue',
        'customer_id',
        'customer',
        'currency_type_id',
        'exchange_rate_sale',
        'total_prepayment',
        'total_discount',
        'total_charge',
        'total_exportation',
        'total_free',
        'total_taxed',
        'total_unaffected',
        'total_exonerated',
        'total_igv',
        'total_base_isc',
        'total_isc',
        'total_base_other_taxes',
        'total_other_taxes',
        'total_taxes',
        'total_value',
        'total',
        'charges',
        'discounts',
        'prepayments',
        'guides',
        'related',
        'perception',
        'detraction',
        'legends',
        'filename',
        'total_canceled',
        'quotation_id',
        'order_note_id',
        'apply_concurrency',
        'type_period',
        'quantity_period',
        'automatic_date_of_issue',
        'enabled_concurrency',
        'series',
        'number',
        'paid',
        'license_plate',
        'observation',
        'total_rounded',
        'total_payment',
        'additional_information',
        'orden_id',
        'variation_document_id'
    ];

    protected $casts = [
        'to_carry' => 'boolean',
        'from_consignment' => 'boolean',
        'date_of_issue' => 'date',
        'automatic_date_of_issue' => 'date',
        'credit_cash' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        //created
        static::created(function ($model) {
            $request = Request::capture();
            $description = "Nota de venta creada";
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
            $description = null;
            $original_model = SaleNote::find($model->id);
            $description = "Nota de venta actualizado";
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
                $description = "Nota de venta eliminada";
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
    public function boxes(){
        return $this->hasMany(Box::class);
    }
    public function variationDocument()
    {
        return $this->belongsTo(Document::class, 'variation_document_id');
    }
    public function updateCreditsPayment()
    {
        $to_paid = Payment::where('sale_note_id', $this->id);
        $amount = $to_paid->first()->amount;
        $amount_to_paid = $to_paid->sum('amount');
        $to_paids = $to_paid->get();
        //get the divition between the amount to paid and the amount 
        $divition = $amount_to_paid / $amount;
        $limit = intval($divition);
        //for each to_paids until the limit
        // foreach ($to_paids as $key => $value) {
        //     if ($key + 1 <= $limit) {

        //         break;
        //     }
        //     $value->
        // }


        $payments = SaleNotePayment::where('sale_note_id', $this->id)->get();
    }
    public function customer()
    {
        return $this->belongsTo(Person::class, 'customer_id');
    }
    public function creditPayments()
    {
        return $this->hasMany(Payment::class);
    }
    public function getEstablishmentAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setEstablishmentAttribute($value)
    {
        $this->attributes['establishment'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getCustomerAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setCustomerAttribute($value)
    {
        $this->attributes['customer'] = (is_null($value)) ? null : json_encode($value);
    }
    public function dispatches()
    {
        return $this->hasMany(Dispatch::class, 'reference_sale_note_id');
    }
    public function getChargesAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setChargesAttribute($value)
    {
        $this->attributes['charges'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getDiscountsAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setDiscountsAttribute($value)
    {
        $this->attributes['discounts'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getPrepaymentsAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setPrepaymentsAttribute($value)
    {
        $this->attributes['prepayments'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getGuidesAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setGuidesAttribute($value)
    {
        $this->attributes['guides'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getRelatedAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setRelatedAttribute($value)
    {
        $this->attributes['related'] = (is_null($value)) ? null : json_encode($value);
    }
    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }
    public function getPerceptionAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setPerceptionAttribute($value)
    {
        $this->attributes['perception'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getDetractionAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }
    public function getDownloadExternalPdfAttribute()
    {
        return route('tenant.download.external_id', ['model' => 'saleNote', 'type' => 'pdf', 'external_id' => $this->external_id]);
    }
    public function setDetractionAttribute($value)
    {
        $this->attributes['detraction'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getLegendsAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setLegendsAttribute($value)
    {
        $this->attributes['legends'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getIdentifierAttribute()
    {
        return $this->series . '-' . $this->number;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function soap_type()
    {
        return $this->belongsTo(SoapType::class);
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function state_type()
    {
        return $this->belongsTo(StateType::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'customer_id');
    }


    public function currency_type()
    {
        return $this->belongsTo(CurrencyType::class, 'currency_type_id');
    }

    public function items()
    {
        return $this->hasMany(SaleNoteItem::class);
    }

    public function kardex()
    {
        return $this->hasMany(Kardex::class);
    }

    public function inventory_kardex()
    {
        return $this->morphMany(InventoryKardex::class, 'inventory_kardexable');
    }



    public function documents()
    {
        return $this->hasMany(Document::class);
    }


    public function getNumberToLetterAttribute()
    {
        $legends = $this->legends;
        $legend = collect($legends)->where('code', '1000')->first();
        return $legend->value;
    }

    public function getNumberFullAttribute()
    {
        $number_full = ($this->series && $this->number) ? $this->series . '-' . $this->number : $this->prefix . '-' . $this->id;

        return $number_full;
    }


    public function scopeWhereTypeUser($query)
    {
        $user = auth()->user();
        return ($user->type == 'seller') ? $query->where('user_id', $user->id) : null;
    }


    public function scopeWhereStateTypeAccepted($query)
    {
        return $query->whereIn('state_type_id', ['01', '03', '05', '07', '13']);
    }

    public function scopeWhereNotChanged($query)
    {
        return $query->where('changed', false);
    }

    public function payments()
    {
        return $this->hasMany(SaleNotePayment::class);
    }
    public function credit_payments()
    {
        return $this->hasMany(Payment::class);
    }
    // public function quotation()
    // {
    //     return $this->belongsTo(Quotation::class);
    // }
}
