<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\Person;
use App\Models\Tenant\ModelTenant;

class InternetTech extends ModelTenant
{
    public $timestamps = true;
    protected $table = "internet_techs";
    protected $with = ["person"];
    protected $fillable = [
        'person_id'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
