<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\ModelTenant;

class InternetConceptOperation extends ModelTenant
{
    public $timestamps = true;
    protected $table = "internet_concept_operation";
    protected $fillable = [
        'concept_id',
        'operation_id',
        'active'
    ];




    protected $casts = [
        'active' => 'boolean'
    ];
    public function concept()
    {
        return $this->belongsTo(InternetConceptVariation::class, 'concept_id');
    }
    public function operation()
    {
        return $this->belongsTo(InternetOperation::class, 'operation_id');
    }
}
