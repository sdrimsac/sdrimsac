<?php

namespace App\Models\Tenant\Catalogs;



class PaymentMethodType extends ModelCatalog
{
    

    protected $table = "cat_payment_method_types";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'active',
        'description',
    ];
}
