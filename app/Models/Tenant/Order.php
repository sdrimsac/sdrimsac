<?php

namespace App\Models\Tenant;


use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tenant\StatusOrder;
use Illuminate\Database\Eloquent\Model;

class Order extends ModelTenant
{
    use SoftDeletes;

    protected $fillable = [
        'external_id',
        'customer',
        'shipping_address',
        'items',
        'total',
        'reference_payment',
        'document_external_id',
        'number_document',
        'document',
        'status_order_id',
        'user_id',
        'to_carry'
    ];

    protected $casts = [
        'customer' => 'object',
        'items' => 'object',
        'to_carry' => 'boolean',
    ];

    public function status_order()
    {
        return $this->belongsTo(StatusOrder::class);
    }


}
