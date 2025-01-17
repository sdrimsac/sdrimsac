<?php

namespace App\Models\System;
use Hyn\Tenancy\Traits\UsesSystemConnection;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use UsesSystemConnection;

    protected $table = 'history_clients';
    protected $fillable = [
        'name',
        'number',
        'business_id',
        'telephone',
        'direccion',
        'direccion_secondary', 
        'email', 
        'ruc', 
        'user',
        'password',
        'user_secondary',
        'password_secondary',
        'password_certificate',
        'date_certificate',  
    ];

    /* public function business()
    {
        return $this->hasMany(Business::class, 'business_id');
    } */
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id'); // Ajusta el nombre del modelo y la clave foránea según tu base de datos.
    }
    
}
