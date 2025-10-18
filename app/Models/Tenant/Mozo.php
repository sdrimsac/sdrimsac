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
}
