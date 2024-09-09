<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;

class PromotionDocument extends ModelTenant
{
   // protected $table = 'pr';
  
    protected $fillable = [
        'description',
        'date_start',
        'date_end',
        'total',
        'active'
    ];


    public function items()
    {
        return $this->hasMany(PromotionDocumentItem::class);
    }


   
}