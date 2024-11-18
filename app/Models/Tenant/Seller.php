<?php

namespace App\Models\Tenant;



class Seller extends ModelTenant
{
    protected $table = 'sellers';

    protected $fillable = [
        'document_type_id',
        'establishment_id',
        'user_id',
        'name',
        'document',
        'telephone',
        'active',
    ];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'seller_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'seller_id');
    }
    public function saleNotes()
    {
        return $this->hasMany(SaleNote::class, 'seller_id');
    }
    public function soldItems()
    {
        return $this->hasManyThrough(
            DocumentItem::class,  // Modelo final al que queremos acceder
            Document::class,      // Modelo intermedio
            'seller_id',          // Clave foránea en `documents` (de `Seller` a `Document`)
            'document_id',        // Clave foránea en `document_items` (de `Document` a `DocumentItem`)
            'id',                 // Llave primaria local en `sellers`
            'id'                  // Llave primaria local en `documents`
        );
    }
    public function salesItems ()
    {
        return $this->hasManyThrough(
            SaleNoteItem::class,
            SaleNote::class,
            'seller_id',
            'sale_note_id',
            'id',
            'id'
        );
    }
}
