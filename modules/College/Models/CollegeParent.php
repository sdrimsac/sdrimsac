<?php

namespace Modules\College\Models;

use App\Models\Tenant\Person;
use App\Models\Tenant\ModelTenant;

class CollegeParent extends ModelTenant
{

    public $timestamps = true;
    protected $table = "parents";
    protected $with = ["person"];
    protected $fillable = [
        'parent_id',
        'attorney_id',
        'type'

    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'parent_id');
    }
    public function attorney()
    {

        return $this->belongsTo(CollegeAttorney::class, 'attorney_id');
    }
    public function member()
    {

        return $this->hasMany(CollegeMember::class, 'parent_id');
    }
}
