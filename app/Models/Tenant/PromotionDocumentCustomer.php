<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;

class PromotionDocumentCustomer extends ModelTenant
{
    protected $table = 'promotion_document_customers';

    protected $fillable = [
        'promotion_document_id',
        'customer_id',
        'acc_total',
        'points',
        'active',
    ];

    public function customer()
    {
        return $this->belongsTo(Person::class);
    }

    public function promotion_document()
    {
        return $this->belongsTo(PromotionDocument::class);
    }

    public function receiveds()
    {
        return $this->hasMany(PromotionReceived::class);
    }

    public function details()
    {
        return $this->hasMany(PromotionDocumentCustomerDetail::class, 'promotion_customer_id');
    }
}
