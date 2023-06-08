<?php

namespace Modules\College\Models;

use App\Models\Tenant\Person;
use App\Models\Tenant\ModelTenant;

class CollegeMember extends ModelTenant
{

    public $timestamps = true;
    protected $table = "members";
    protected $with = ["person", "parent"];
    protected $fillable = [
        'parent_id',
        'children_id',

    ];

    public function registers(){

        return $this->hasMany(CollegeRegister::class, 'member_id', 'id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'children_id');
    }
    public function parent()
    {
        return $this->belongsTo(CollegeParent::class, 'parent_id');
    }

    public function student()
    {

        return $this->hasMany(CollegeStudent::class, 'student_id', 'children_id');
    }
}
