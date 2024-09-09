<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;

class PromotionDocumentItem extends ModelTenant
{
   protected $table = 'promotion_document_items';
  
    protected $fillable = [
        'promotion_document_id',
        'item_id',
        'quantity',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function promotion_document()
    {
        return $this->belongsTo(PromotionDocument::class);
    }


   
}