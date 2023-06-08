<?php

namespace Modules\College\Models;


use App\Models\Tenant\ModelTenant;

class CollegePlan extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_plans";
    protected $with = ['period', 'penalty'];
    protected $fillable = [
        'name',
        'description',
        'period_id',
        'type_id',
        'count',
        'active',
        'penalty_id'
    ];



    public function penalty()
    {

        return $this->belongsTo(CollegePenalty::class, 'penalty_id');
    }
    public function type()
    {

        return $this->belongsTo(CollegePlanType::class, 'type_id');
    }

    public function period()
    {
        return $this->belongsTo(CollegePeriod::class);
    }
}
