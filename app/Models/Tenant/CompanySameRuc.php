<?php

namespace App\Models\Tenant;


class CompanySameRuc extends ModelTenant
{
    public $timestamps = false;
    protected $table="company_same_ruc";
    protected $fillable = [
        'name',
        'website_id',
        'uuid',
    ];

}
