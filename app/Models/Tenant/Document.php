<?php

namespace App\Models\Tenant;

use App\Models\Tenant\Catalogs\CurrencyType;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Traits\RegisterMovementTrait;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Http\Request;

//use Modules\BusinessTurn\Models\DocumentHotel;
//use Modules\BusinessTurn\Models\DocumentTransport;

class Document extends ModelTenant
{
    use RegisterMovementTrait, UsesTenantConnection;

    protected $with = ['user', 'establecimientos', 'soap_type', 'user', 'state_type', 'document_type', 'currency_type', 'group', 'items', 'invoice', 'payments'];
    public $timestamps = true;
    protected $fillable = [
        'cash_id',
        'seller_id',
        'discount_variant',
        'from_consignment',
        'id',
        'user_id',
        'external_id',
        'establishment_id',
        'establishment',
        'soap_type_id',
        'state_type_id',
        'ubl_version',
        'group_id',
        'document_type_id',
        'series',
        'series_id',
        'operation_type_id',
        'number',
        'date_of_issue',
        'date_of_due',
        'time_of_issue',
        'customer_id',
        'customer',
        'currency_type_id',
        'purchase_order',
        'quotation_id',
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
        'additional_information',
        'filename',
        'hash',
        'qr',
        'has_xml',
        'has_pdf',
        'has_cdr',
        'has_prepayment',
        'affectation_type_prepayment',
        'data_json',
        'send_server',
        'shipping_status',
        'sunat_shipping_status',
        'query_status',
        'total_plastic_bag_taxes',
        'sale_note_id',
        'success_shipping_status',
        'success_sunat_shipping_status',
        'success_query_status',
        'plate_number',
        'total_canceled',
        'soap_shipping_response',
        'token_user',
        'observation',
        'payment_condition_id',
        'total_rounded',
        'total_payment',
        'afectar_caja',
        'payment',
        'dispatch_id'
    ];

    protected $casts = [
        'from_consignment' => 'boolean',
        //  'date_of_issue' => 'date',
    ];
    protected static function boot()
    {
        parent::boot();
        //created
        static::created(function ($model) {
            $type = $model->get_document_type();
            $request = Request::capture();
            $description = "$type creada";
            RegisterMovementTrait::registerCreate(
                $model,
                $request,
                $description,
                $model->toArray()
            );
        });
        // static::updated(function ($model) {
        //     $type = $model->get_document_type();
        //     $request = Request::capture();
        //     $description = null;
        //     $original_model = Document::find($model->id);
        //     $description = "$type actualizado";
        //     $data = $original_model->toArray();
        //     RegisterMovementTrait::registerUpdate(
        //         $model,
        //         $request,
        //         $description,
        //         $data
        //     );
        // });

        static::deleted(
            function ($model) {
                $type = $model->get_document_type();
                $request = Request::capture();
                $description = "$type eliminada";
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

  public function canceled(){
    $boxes = Box::where('document_id', $this->id)->sum('amount');
    if($boxes > 0){
        if($boxes == $this->total){
            $this->total_canceled = true;
            $this->save();
        }
    }
  }
  public function getGlobalDiscountsNoBase()
    { 

        //descuentos globales que no afectan la base
        $allowance_total_amount = 0;
    
        if($this->discounts){
            
            $allowance_total_amount = collect($this->discounts)->sum(function($discount){
                return (in_array($discount->discount_type_id, ['03', '63'])) ? $discount->amount : 0;
            });

        }

        return $allowance_total_amount;
    }
    public function boxes(){
        return $this->hasMany(Box::class,'document_id');
    }
    public function get_document_type(){
        $document_type_id = $this->document_type_id;
        return $document_type_id == "03" ? "BOLETA" : "FACTURA";
    }
    public function reference_guides()
    {
        return $this->hasMany(Dispatch::class, 'reference_document_id', 'id');
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

    public function getDataJsonAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setDataJsonAttribute($value)
    {
        $this->attributes['data_json'] = (is_null($value)) ? null : json_encode($value);
    }


    public function getSoapShippingResponseAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setSoapShippingResponseAttribute($value)
    {
        $this->attributes['soap_shipping_response'] = (is_null($value)) ? null : json_encode($value);
    }


    public function getAdditionalInformationAttribute($value)
    {
        $arr = explode('|', $value);
        return $arr;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function soap_type()
    {
        return $this->belongsTo(SoapType::class);
    }
    public function establecimientos()
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

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }

    public function currency_type()
    {
        return $this->belongsTo(CurrencyType::class, 'currency_type_id');
    }

    public function getCompanyAttribute()
    {
        return Company::first();
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }



    public function items()
    {
        return $this->hasMany(DocumentItem::class);
    }

    public function kardex()
    {
        return $this->hasMany(Kardex::class);
    }

    public function payments()
    {
        return $this->hasMany(DocumentPayment::class);
    }

    public function fee()
    {
        return $this->hasMany(DocumentFee::class);
    }

    public function inventory_kardex()
    {
        return $this->morphMany(InventoryKardex::class, 'inventory_kardexable');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class, 'sale_note_id');
    }

    // public function hotel()
    // {
    //     return $this->hasOne(DocumentHotel::class);
    // }

    // public function transport()
    // {
    //     return $this->hasOne(DocumentTransport::class);
    // }

    public function getNumberFullAttribute()
    {
        return $this->series . '-' . $this->number;
    }

    public function getNumberToLetterAttribute()
    {
        $legends = $this->legends;
        $legend = collect($legends)->where('code', '1000')->first();
        return $legend->value;
    }

    public function getDownloadExternalXmlAttribute()
    {
        return route('tenant.download.external_id', ['model' => 'document', 'type' => 'xml', 'external_id' => $this->external_id]);
    }

    public function getDownloadExternalPdfAttribute()
    {
        return route('tenant.download.external_id', ['model' => 'document', 'type' => 'pdf', 'external_id' => $this->external_id]);
    }

    public function getDownloadExternalCdrAttribute()
    {
        return route('tenant.download.external_id', ['model' => 'document', 'type' => 'cdr', 'external_id' => $this->external_id]);
    }


    public function scopeWhereTypeUser($query)
    {
        $user = auth()->user();
        return ($user->type == 'seller') ? $query->where('user_id', $user->id) : null;
    }

    public function scopeWhereNotSent($query)
    {
        return  $query->whereIn('state_type_id', ['01', '03'])->where('date_of_issue', '<=', date('Y-m-d'));
    }


    public function scopeWhereHasPrepayment($query)
    {
        return $query->where([['has_prepayment', true], ['was_deducted_prepayment', false], ['state_type_id', '05']]);
    }



    public function summary_document()
    {
        return $this->hasOne(SummaryDocument::class);
    }

    public function scopeWhereAffectationTypePrepayment($query, $type)
    {
        return $query->where('affectation_type_prepayment', $type);
    }

    public function scopeWhereStateTypeAccepted($query)
    {
        return $query->whereIn('state_type_id', ['01', '03', '05', '07', '13']);
    }

    public function payment_condition()
    {
        return $this->belongsTo(PaymentCondition::class, 'payment_condition_id');
    }

    public function note()
    {
        return $this->hasOne(Note::class);
    }
}
