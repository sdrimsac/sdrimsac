<?php

namespace Modules\College\Models;

use App\Models\Tenant\Person;
use App\Models\Tenant\ModelTenant;

class CollegeKardexSuppliesMov extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_kardex_supplies_mov";
    
    protected $fillable = [
        'k_supp_id' ,
        'k_supp_id_list' ,
        'k_supp_id_alum' ,
        'k_supp_id_profe' ,
        'k_supp_id_type_event' ,
        'k_supp_fecha_event' ,
        'k_supp_cantidad',
        'k_supp_DescMovimiento'
    ];

   
}
