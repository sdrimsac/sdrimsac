<?php

namespace Modules\Restaurant\Models;
use App\Models\Tenant\ModelTenant;


class BoxesDetail extends ModelTenant
{

    public $timestamps = true;
    protected $table = "boxes_detail";
    protected $with = ['item'];
    protected $fillable = [
        'item_detail_id',
        'quantity',
        'price',
        'price_extra',
        'boxes_id'
    ];
    protected $cast = [
        'price' => 'float',
        'price_extra' => 'float',
        'quantity' => 'float'
    ];

    public function item()
    {
        return $this->belongsTo(BoxesItemDetail::class, 'item_detail_id');
    }
}
