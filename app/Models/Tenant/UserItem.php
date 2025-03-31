<?php

namespace App\Models\Tenant;

use App\Models\Tenant\ModelTenant;

class UserItem extends ModelTenant
{
    protected $fillable = ['user_id', 'item_id'];
    protected $table = 'users_items';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
            return $this->belongsTo(Item::class);
    }
}
