<?php

namespace App\Models\Tenant;


class CashTransfer extends ModelTenant
{

    public $table = 'cash_transfers';

    
    protected $fillable = [
        'cash_principal_id',
        'cash_destination_id',
        'amount',
        'date_of_issue',
        'observation',
    ];
 

  
    public function cash_principal()
    {
        return $this->belongsTo(Cash::class, 'cash_principal_id');
    }

    public function cash_destination()
    {
        return $this->belongsTo(Cash::class, 'cash_destination_id');
    }

 
}