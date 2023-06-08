<?php

namespace App\Models\Tenant;

 use Illuminate\Database\Eloquent\Model;

class Receipt extends ModelTenant
{
    protected $table = "receipts";
    protected $with = ["customer","sale_note"];
    protected $fillable = [
        'user_id',
        'date_of_issue',                   
        'hour',                
        'customer_id',
        'sale_note_id',
        'sale_note_payment_id',
        'number',
        'external_id',
        'detail',   
        'amount',
        'establishment_id',
        'state',
    ];
    
    // public function sales_payments()
    // {
    //     return $this->belongsTo(SaleNotePayment::class,'sale_note_payment_id','id');
    // }

    public function customer()
    {
        return $this->belongsTo(Person::class);
    }
    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class);
    }

}
