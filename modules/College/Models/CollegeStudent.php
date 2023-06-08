<?php

namespace Modules\College\Models;

use App\Models\Tenant\Person;
use App\Models\Tenant\ModelTenant;

class CollegeStudent extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_students";
    protected $with = ["classroom"];
    protected $fillable = [
        'student_id',
        'classroom_id',
        'active',
    ];

    public function classroom()
    {
        return $this->belongsTo(CollegeClassroom::class);
    }
    public function person()
    {
        return $this->belongsTo(Person::class, 'student_id');
    }
    public function member()
    {

        return $this->hasOne(CollegeMember::class, 'children_id', 'student_id');
    }
}
