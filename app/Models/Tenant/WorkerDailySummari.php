<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class WorkerDailySummari extends Model
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
        'pairs',
        'date_daily',
        'date_end_daily',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'pairs' => 'array',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
