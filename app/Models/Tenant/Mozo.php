<?php

namespace App\Models\Tenant;



class Mozo extends ModelTenant
{
    protected $table = 'seller_mozo';

    protected $fillable = [
        'establishment_id',
        'user_id',
        'document_type_id',
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

    /* public function documents()
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
    } */
    /* public function soldItems()
    {
        return $this->hasManyThrough(
            DocumentItem::class, 
            Document::class,     
            'seller_id',          
            'document_id',        
            'id',                 
            'id'                  
        );
    } */
    /* public function salesItems ()
    {
        return $this->hasManyThrough(
            SaleNoteItem::class,
            SaleNote::class,
            'seller_id',
            'sale_note_id',
            'id',
            'id'
        );
    } */
}
