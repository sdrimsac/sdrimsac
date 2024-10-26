<?php

namespace Modules\Workshop\Models;

use App\Models\Tenant\ModelTenant;

use App\Models\Tenant\Establishment;
use App\Models\Tenant\User;
use App\Models\Tenant\Document;
use App\Models\Tenant\Quotation;
use App\Models\Tenant\SaleNote;
class WorkshopPersonal extends ModelTenant
{
    protected $table = 'personal';
    
    protected $fillable = [
        'establishment_id',
        'user_id',
        'name',
        'telephone',
        'active',
        'number'
    ];
    
    public function establishment() {
        return $this->belongsTo(Establishment::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    /* public function documents()
    {
        return $this->hasMany(Document::class, 'seller_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'seller_id');
    }
    public function salenote() 
    {
        return $this->hasMany(SaleNote::class, 'seller_id');
    } */

}