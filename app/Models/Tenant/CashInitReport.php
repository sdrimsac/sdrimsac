<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class   CashInitReport extends ModelTenant
{

    protected $connection = 'tenant';
    protected $table = 'cash_init_stock'; //nombre tabla
    protected $fillable = ['cash_id', 'item_id', 'initial_stock'];

    /* protected $casts = [
        'initial_stock' => 'decimal:4',
    ]; */
    public function cash()
    {
        return $this->belongsTo(Cash::class, 'cash_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

}