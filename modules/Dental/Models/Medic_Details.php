<?php
namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;

class Medic_Details extends ModelTenant
{
    protected $table = "dental_medic_details";
    protected $fillable = [
        'medic_id',
        'day_of_week',
        'start_time',
        'end_time',
        'active',
        'created_at',
        'updated_at'

    ];
    public function medic()
    {
        return $this->belongsTo(Medic::class, 'medic_id');
    }
}