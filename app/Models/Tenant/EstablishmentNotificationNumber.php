<?php

namespace App\Models\Tenant;



class EstablishmentNotificationNumber extends ModelTenant
{
    protected $table = "establishments_notification_numbers";
    protected $fillable = [
        'establishment_id',
        'number',
    ];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function getNumber(){
        $number = NumberActivity::find($this->number);
        return $number->number;
    }
    
 
}