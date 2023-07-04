<?php

namespace Modules\Consignment\Models;
 

use App\Models\Tenant\ModelTenant;

class ConsignmentItemLot extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'consigment_item_lots'; 
    protected $fillable = [
        'consignment_item_id',
        'series',
        'has_sale',
        'has_return',
        'has_lost',
    ];

}