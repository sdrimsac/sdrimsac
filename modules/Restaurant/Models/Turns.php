<?php

namespace Modules\Restaurant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Tenant\ModelTenant;

class Turns extends ModelTenant
{
    use HasFactory;

    protected $fillable = [
        'turn_desc',
        'turn_active',

    ];
}
