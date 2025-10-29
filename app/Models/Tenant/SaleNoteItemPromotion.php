<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class SaleNoteItemPromotion extends ModelTenant
{
    protected $table = "sale_note_item_promotions";
    protected $fillable = [
        'sale_note_item_id',
        'promotion_item_id',
        'item_id',
        'quantity',
        'created_at',
        'updated_at',
    ];

    // public function sales_payments()
    // {
    //     return $this->belongsTo(SaleNotePayment::class,'sale_note_payment_id','id');
    // }
    public function document()
    {

        return $this->belongsTo(Document::class, 'document_item_id');
    }
    public function sale_note()
    {
        return $this->belongsTo(SaleNoteItem::class, 'sale_note_item_id');
    }
    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
