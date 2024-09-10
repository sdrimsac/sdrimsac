<?php

namespace App\Models\Tenant;

class HistoryPayment extends ModelTenant
{
    protected $table = "history_payments";
    protected $fillable = [
        'user_id',
        'payment_id',                   
        'value',
        'type',
        'old_value',
    
    ];
    
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
