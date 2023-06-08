<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Modules\LevelAccess\Models\ModuleLevel;

class Module extends ModelTenant
{
 
    protected $with = ['levels'];

    protected $fillable = [
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
    public function levels()
    {
        return $this->hasMany(ModuleLevel::class);
    }
}