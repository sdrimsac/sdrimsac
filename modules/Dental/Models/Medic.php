<?php
namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;

class Medic extends ModelTenant
{
    protected $table = "medic";
    protected $fillable = [
        'specialty_id',
        'name',             
        'number',
        'country_id',
        'department_id',
        'province_id',
        'district_id',
        'email',
        'address',
        'telephone',
        'sexo',
        'created_at',
        'updated_at'

    ];
    public function specialty()
    {
        return $this->belongsTo(Specialty::class, 'specialty_id');
    }
}