<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\ModelTenant;

class InternetConceptVariation extends ModelTenant
{
    public $timestamps = true;
    protected $table = "internet_concept_variation";
    protected $fillable = [
        'concept_id',
        'description',
        'price',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
    public function concept()
    {
        return $this->belongsTo(InternetConcept::class, 'concept_id');
    }
}
