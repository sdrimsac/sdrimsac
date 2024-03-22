<?php

namespace App\Models\Tenant;


class SaleNoteCreditPenalty extends ModelTenant

{
    public $timestamps = false;
    protected $table = "penalties_sale_note_credit";
    protected $fillable = [
        "type",
        "amount_by_day"
    ];


 
}
