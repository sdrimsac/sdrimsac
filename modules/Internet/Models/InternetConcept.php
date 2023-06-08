<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;

class InternetConcept extends ModelTenant
{
    public $timestamps = true;
    protected $table = "internet_concept";
    protected $fillable = [
        'item_id',
        'description',
        'default_price',
        'active',
        'item_id'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
    protected $with = ["variations", "item"];

    public function variations()
    {
        return $this->hasMany(InternetConceptVariation::class, 'concept_id', 'id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
