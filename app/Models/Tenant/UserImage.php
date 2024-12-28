<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class UserImage extends ModelTenant
{

    protected $fillable = [
        'user_id',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
