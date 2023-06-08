<?php

namespace Modules\College\Models;

use App\Models\Tenant\ModelTenant;

class CollegeClassroom extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_classrooms";
    protected $with = [
        'degree', 'section', 'turn', 'level',
    ];
    protected $fillable = [
        'degree_id',
        'turn_id',
        'section_id',
        'level_id',
        'places',
        'year',
        'active',

    ];

    public function getDescriptionAttribute()
    {
        $degree = $this->degree->description;
        $section = $this->section->description;
        $level = $this->level->description;
        $turn = $this->turn->description;

        return $degree . "-" . $section . " Nivel " . $level . " Turno " . $turn;
    }

    public function degree()
    {
        return $this->belongsTo(CollegeDegree::class, 'degree_id');
    }

    public function section()
    {
        return $this->belongsTo(CollegeSection::class, 'section_id');
    }

    public function level()
    {
        return $this->belongsTo(CollegeLevel::class, 'level_id');
    }

    public function turn()
    {
        return $this->belongsTo(CollegeTurn::class, 'turn_id');
    }
}
