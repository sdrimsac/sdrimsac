<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesSystemConnection;

class MessageSendSchedule extends Model
{
    use UsesSystemConnection;

    protected $table = 'message_send_schedule';
    protected $fillable = [
        'send_day_at',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
