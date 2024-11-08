<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;

class PromotionDocument extends ModelTenant
{
  
    protected $fillable = [
        'description',
        'date_start',
        'date_end',
        'total',
        'active',
        'is_points',
    ];
    protected $casts = [
        'is_points' => 'boolean',
    ];

    public function getFormattedItems(){
        $items = $this->items->transform(function($item){

            $return_item = $item->item;
            $return_item->quantity = $item->quantity;
            return $return_item;
        });

        return $items;
    }
    public function items()
    {
        return $this->hasMany(PromotionDocumentItem::class);
    }



   
}