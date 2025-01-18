<?php
namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;


class Disease_Types extends ModelTenant
{
    protected $table = "disease_types";
    protected $fillable = [
        'description',
        'active'
    ];
}