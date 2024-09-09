<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;

class PromotionDocumentCustomerDetail extends ModelTenant
{
    protected $table = 'promotion_document_customer_detail';

    protected $fillable = [
        'document_id',
        'sale_note_id',
        'promotion_customer_id',
        'total',
    ];

    public function promotion_customer()
    {
        return $this->belongsTo(PromotionDocumentCustomer::class, 'promotion_customer_id');
    }

    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class, 'sale_note_id');
    }

    public function document()
    {
        return $this->belongsTo(PromotionDocument::class, 'document_id');
    }
}
