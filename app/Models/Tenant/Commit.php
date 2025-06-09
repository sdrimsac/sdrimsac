<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Commit extends ModelTenant
{
    protected $table = 'commits';
    protected $fillable = [
        'commit',
        'message',
        'created_at',
        'updated_at',
    ];
}
