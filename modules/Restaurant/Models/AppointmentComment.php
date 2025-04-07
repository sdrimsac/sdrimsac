<?php

namespace Modules\Restaurant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Tenant\ModelTenant;

class AppointmentComment extends ModelTenant
{
    use HasFactory;

    protected $table = 'appointments_comments';
    protected $fillable = [
        'uuid',
        'user_schedule_appointments',
        'comment',
        'qualification',
        'completed',

    ];

    public function userScheduleAppointment()
    {
        return $this->belongsTo(UserScheduleAppointment::class);
    }
}




        

