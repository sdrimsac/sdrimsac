<?php

namespace App\Models\Tenant;



class CashIncomePrincipal extends ModelTenant
{
    // protected $with = ['cash_documents'];
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $table = 'cash_income_principal';
    protected $fillable = [

        'cash_principal_id',
        'cash_id',
        'comment',
        'amount',
        'status',
        'active',
    ];


    public function cash()
    {
        return $this->belongsTo(Cash::class);
    }

    //obtiene documentos y notas venta
    public function cash_principal()
    {
        return $this->hasMany(Cash::class, 'id', 'cash_principal_id');
    }



    // public function get_ref
}
