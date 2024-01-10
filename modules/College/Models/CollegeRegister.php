<?php

namespace Modules\College\Models;


use App\Models\Tenant\ModelTenant;

class CollegeRegister extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_registers";
    protected $fillable = [
        'member_id',
        'plan_id',
        'classroom_id',
        'first_pay',
        'last_pay',
        'payment_count',
        'active',
    ];

    public function member()
    {
        return $this->belongsTo(CollegeMember::class, 'member_id');
    }
    public function plan()
    {

        return $this->belongsTo(CollegePlan::class, 'plan_id');
    }
    public function lastCollegePayment()
{
    return $this->hasOne(CollegePayment::class, 'register_id')->latest('created_at');
}

    public function payments()
    {

        return $this->hasMany(CollegePayment::class, 'register_id', 'id');
    }
}
