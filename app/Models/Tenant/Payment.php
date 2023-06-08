<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Payment extends ModelTenant
{
    protected $table = "payments";
    //protected $with = ["sale_note","user"];
    protected $fillable = [
        'user_id',
        'date_payment',                   
        'sale_note_id',
        'amount',
        'type_payment',
        'payment_method_type_id',
        'tasa'
    ];
    
    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class);
    }
     
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethodType::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
