<?php

namespace App\Models\Tenant;


use Illuminate\Foundation\Auth\User as Authenticatable;



class UserSession extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'tenant';
    protected $table = 'user_sessions';
    protected $fillable = [
        'user_id',
        'session_id',
        'user_agent',
        'tab_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
