<?php

namespace App\Models\Tenant;



class ConfEstablishment extends ModelTenant
{
    protected $table = "conf_establishment";
    protected $casts = [
        "direct_sale" => "boolean",
        "pos_quick_sale" => "boolean",
        "company_address" => "boolean",
    ];
    protected $fillable = [
        'establishment_id',
        'direct_sale',
        'pos_quick_sale',
        'company_address'
    ];


    public function establishment()
    {

        return $this->belongsTo(Establishment::class);
    }
}
