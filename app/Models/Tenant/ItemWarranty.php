<?php

namespace App\Models\Tenant;



class ItemWarranty extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'item_warranty';
    protected $fillable = [
        'warranty_end_date',
        'sale_note_item_id',
        'document_item_id', 
    ];

    public function Documentitem()
    {
        return $this->belongsTo(DocumentItem::class, 'document_item_id');
    }
    public function SaleNoteItem()
    {
        return $this->belongsTo(SaleNoteItem::class, 'sale_note_item_id');
    }
}