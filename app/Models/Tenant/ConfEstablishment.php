<?php

namespace App\Models\Tenant;


use Illuminate\Database\Eloquent\Model;

class ConfEstablishment extends ModelTenant
{
    protected $table = "conf_establishment";
    protected $casts = [
        "direct_sale" => "boolean",
        "pos_quick_sale" => "boolean",
    ];
    protected $fillable = [
        'establishment_id',
        'direct_sale',
        'pos_quick_sale'
    ];


    public function establishment()
    {

        return $this->belongsTo(Establishment::class);
    }
}
