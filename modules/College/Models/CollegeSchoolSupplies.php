<?php

namespace Modules\College\Models;


use App\Models\Tenant\ModelTenant;

class CollegeSchoolSupplies extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_school_supplies";
    protected $fillable = [
        's_supp_name',
        's_supp_brand',
        's_supp_status',
        's_supp_codigo',
       

    ];
}
