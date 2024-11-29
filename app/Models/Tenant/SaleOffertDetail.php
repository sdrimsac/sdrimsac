<?php

namespace App\Models\Tenant;





class SaleOffertDetail extends ModelTenant
{
    protected $table = 'sale_offerts_details';

    protected $fillable = [
        'quantity_total',
        'quantity_free',
    ];

    protected $casts = [
        'quantity_total' => 'integer',
        'quantity_free' => 'integer',
    ];
    

}