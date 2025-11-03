<?php

namespace App\Models\Tenant;


use Illuminate\Foundation\Auth\User as Authenticatable;



class WorkerAdvance extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'tenant';
    protected $table = 'worker_advances';
    protected $fillable = [
        'person_id',
        'amount',
        'method',
        'date_time_advance',
        'obervation',
        'created_at',
        'updated_at',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
