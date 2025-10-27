<?php

namespace App\Models\Tenant;
use Illuminate\Foundation\Auth\User as Authenticatable;

class WorkerConsumption extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'tenant';
    protected $table = 'worker_consumptions';
    protected $fillable = [
        'person_id',
        'amount',
        'date_time_consumption',
        'obervation',
        'created_at',
        'updated_at',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
