<?php

namespace App\Models\Tenant;


class PromotionReceived extends ModelTenant
{

    protected $table = 'promotion_received';

    protected $fillable = [
        'promotion_document_customer_id',
        'item_id',
        'quantity',
        'document_id',
        'sale_note_id',
        'user_id',
    ];

    public function promotion_document_customer()
    {
        return $this->belongsTo(PromotionDocumentCustomer::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
