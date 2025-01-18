<?php
namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;


class Diagnosis_Types extends ModelTenant
{
    protected $table = "diagnosis_types";  
    protected $fillable = [
       'CIE10',
       'description'                      
        ];
}