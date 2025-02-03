<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Catalog extends ModelTenant
{

    protected $connection = 'tenant';
    protected $table = 'catalog'; 
    protected $fillable = ['image_past', 'image_fond', 'image_footer'];

}
