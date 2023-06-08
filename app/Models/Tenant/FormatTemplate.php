<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class FormatTemplate extends ModelTenant
{
    protected $fillable = [
    	'id',
    	'formats'
    ];
}
