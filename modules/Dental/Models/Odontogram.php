<?php
namespace Modules\Dental\Models;

use App\Models\Tenant\ModelTenant;


class Odontogram extends ModelTenant
{
    protected $table = 'odontogram';

    protected $fillable = [
        'patient_id',
        'tooth',
        'data',
    ];
}