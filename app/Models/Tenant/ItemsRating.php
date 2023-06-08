<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class ItemsRating extends ModelTenant
{
    protected $table = 'items_rating';

    protected $fillable = [
        'user_id',
        'item_id',
        'item_id',
        'value'
    ];

}