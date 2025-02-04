<?php

namespace App\Models\Tenant;


use Illuminate\Database\Eloquent\Model;

class ItemCatalog extends ModelTenant
{
    protected $with = ['item_catalog'];
    public $timestamps = false;

    protected $fillable = [
        'id_item_catalog',
    ];
}