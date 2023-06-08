<?php

namespace Modules\College\Models;

use App\Models\Tenant\Person;
use App\Models\Tenant\ModelTenant;

class CollegeListSupplies extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_list_supplies";
    
    protected $fillable = [
        'list_supp_id',
        'list_supp_s_supp_id', // id del alumno 
        'list_supp_classroom_id',
        'list_supp_cantidad'
    ];

   
}
