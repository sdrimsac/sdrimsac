<?php

namespace Modules\Workshop\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Item;

class HistorialItem extends ModelTenant
{
    protected $table = 'historial_item';

    protected $fillable = [
        'historial_id',
        'item_id',
        'cantidad',
        'price',
    ];
    public function item(){
        return $this->belongsTo(Item::class,'item_id');
    }
    public function historial(){
        return $this->belongsTo(Historial::class,'historial_id');
    }
    
}