<?php

namespace Modules\College\Models;

use App\Models\Tenant\ModelTenant;

class CollegeBrandSuppli extends ModelTenant
{

    public $timestamps = false;
    protected $table = "college_brands_supplies";
    
    protected $fillable = [
        'brnd_supp_id',
        'brnd_supp_name',
        
    ];

    
}
