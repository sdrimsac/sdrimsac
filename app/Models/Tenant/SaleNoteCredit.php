<?php

namespace App\Models\Tenant;


class SaleNoteCredit extends ModelTenant

{

    protected $fillable = [
        "cash_id",
        "sale_note_id",
        "penalty_amount_by_day",
        "reason_to_anulate_credit",
    ];

    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class);
    }

    public function cash()
    {
        return $this->belongsTo(Cash::class);
    }
}
