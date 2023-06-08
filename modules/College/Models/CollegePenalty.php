<?php

namespace Modules\College\Models;


use App\Models\Tenant\ModelTenant;

class CollegePenalty extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_penalties";
    protected $with = ["services"];
    protected $fillable = [
        'description',
        'percentage',
        'active',
    ];

    public function services()
    {
        return $this->hasMany(CollegePenaltyService::class, 'penalty_id', 'id');
    }
}
