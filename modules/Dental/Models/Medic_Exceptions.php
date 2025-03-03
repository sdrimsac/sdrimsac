<?php
namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;

class Medic_Exceptions extends ModelTenant
{
    protected $table = "medic_exceptions";
    protected $fillable = [
        'medic_id',
        'day_of_week',
        'date',             
        'start_time',
        'end_time',
        'status',
        'active',
        'created_at',
        'updated_at'

    ];
    public function medic()
    {
        return $this->belongsTo(Medic::class, 'medic_id');
    }
}