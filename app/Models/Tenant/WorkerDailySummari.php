<?php

namespace App\Models\Tenant;
use Illuminate\Foundation\Auth\User as Authenticatable;

class WorkerDailySummari extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'tenant';
    protected $table = 'worker_daily_summaries';
    protected $fillable = [
        'person_id',
        'entrance',
        'exit',
        'horas_trabajadas',
        'overtime',
        'amount_extra',
        'lack',
        'date_daily',
        'created_at',
        'updated_at',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
