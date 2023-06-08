<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desarrollador extends ModelTenant
{
    protected $table="desarrollador";
    protected $fillable = [
        'name'
    ];

}
