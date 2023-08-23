<?php

namespace App\Models\Tenant;


class SaleNoteCredit extends ModelTenant

{

    protected $fillable = [
      "cash_id",
      "sale_note_id"
    ];

    public function sale_note(){
        return $this->belongsTo(SaleNote::class);
    }
    public function cash(){
        return $this->belongsTo(Cash::class);
    }
 
}
