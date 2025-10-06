<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Modules\Finance\Models\GlobalPayment;
use Modules\Finance\Models\PaymentFile;

class SaleNotePayment extends ModelTenant
{
    protected $with = ['payment_method_type', 'card_brand'];
    public $timestamps = false;

    protected $fillable = [
        'extorned',
        'payment_id', 
        'sale_note_id',
        'date_of_payment',
        'payment_method_type_id',
        'has_card',
        'card_brand_id',
        'reference',
        'change',
        'payment',
        'user_id',
        'method',
        'number_method',
        'date_time_issue'
    ];
    
    //,'receipt'
    protected $casts = [
        'date_of_payment' => 'date',
        'extorned' => 'boolean',
    ];

  
    public function payment_register()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
    public function payment_method_type()
    {
        return $this->belongsTo(PaymentMethodType::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function card_brand()
    {
        return $this->belongsTo(CardBrand::class);
    }

    public function global_payment()
    {
        return $this->morphOne(GlobalPayment::class, 'payment');
    }
 
    public function associated_record_payment()
    {
        return $this->belongsTo(SaleNote::class, 'sale_note_id');
    }

    public function payment_file()
    {
        return $this->morphOne(PaymentFile::class, 'payment');
    }

    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class);
    }

}