<?php

namespace App\Models\Tenant;



class ConfEstablishment extends ModelTenant
{
    protected $table = "conf_establishment";
    protected $casts = [
        'sale_credit_notes' => 'boolean',
        'show_discounts_payment' => 'boolean',
        'show_payment_method' => 'boolean',
        'print_command'  => 'boolean',
        "direct_sale" => "boolean",
        "pos_quick_sale" => "boolean",
        "company_address" => "boolean",
    ];
    protected $fillable = [
        'show_discounts_payment',
        'show_payment_method',
        'print_command',
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
