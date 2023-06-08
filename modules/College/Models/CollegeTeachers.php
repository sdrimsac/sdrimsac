<?php

namespace Modules\College\Models;

use App\Models\Tenant\Person;
use App\Models\Tenant\ModelTenant;

class CollegeTeachers extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_teachers";
    
    protected $fillable = [
        'teach_id',
        'teach_pers_id',
        'active',
    ];

   
}
