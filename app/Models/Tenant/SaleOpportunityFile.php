<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class SaleOpportunityFile extends ModelTenant
{
    public $timestamps = false;

    protected $fillable = [
        'sale_opportunity_id',
        'filename',
    ];

    public function sale_opportunity()
    {
        return $this->belongsTo(SaleOpportunity::class, 'sale_opportunity_id');
    }
}
