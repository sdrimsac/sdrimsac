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
    
    public function establishment() {
        return $this->belongsTo(Establishment::class);
    }
    
    public function user() {
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

}