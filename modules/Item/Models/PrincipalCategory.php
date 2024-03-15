<?php

namespace Modules\Item\Models;

use App\Models\Tenant\Item;

use App\Models\Tenant\ModelTenant;


class PrincipalCategory extends ModelTenant
{
    // protected $hidden = ["created_at", "updated_at"];
    protected $table = "principal_categories";

    protected $fillable = [
        'name',
        'identifier',
        'is_expanded',
        'active'
    ];



    public function items()
    {
        return $this->hasMany(Item::class, 'category_id', 'id');
    }
}
