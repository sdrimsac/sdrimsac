<?php

namespace App\Models\Tenant;


use Illuminate\Foundation\Auth\User as Authenticatable;



class PersonAttendance extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'tenant';
    protected $table = 'person_attendances';
    protected $fillable = [
        'person_id',
        'date_time_attendance',
        'date_attendance',
        'time_attendance',
        'type',
        'biometrio',
        'created_at',
        'updated_at',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
