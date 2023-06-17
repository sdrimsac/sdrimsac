<?php

namespace Modules\Item\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\User;

use App\Models\Tenant\ModelTenant;


class CategoryItem extends ModelTenant
{
    protected $hidden = ["created_at", "updated_at"];
    protected $table = "categories";

    protected $fillable = [
        'name',
        'icono',
        'pos_drag',
        'user_id'

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function items()
    {
        return $this->hasMany(Item::class, 'category_id', 'id');
    }
}
