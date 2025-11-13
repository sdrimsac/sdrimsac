<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'tenant';
    protected $table = 'job_positions';
    protected $fillable = [
        'name',
        'sueldo_base',
        'factor_diario',
        'estado',
        'created_at',
        'updated_at',
    ];
}
