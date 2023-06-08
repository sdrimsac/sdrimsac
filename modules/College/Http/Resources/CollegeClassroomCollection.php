<?php

namespace Modules\College\Http\Resources;

use CreateCollegeStudents;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\College\Models\CollegeMember;
use Modules\College\Models\CollegeStudent;

class CollegeClassroomCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {
            $students = CollegeStudent::where('classroom_id', $row->id)->get();
            return [
                'id'          => $row->id,
                'degree' => $row->degree->description,
                'degree_id' => $row->degree_id,
                'section' => $row->section->description,
                'section_id' => $row->section_id,
                'level' => $row->level->description,
                'level_id' => $row->level_id,
                'turn' => $row->turn->description,
                'turn_id' => $row->turn_id,
                'places' => $row->places,
                'year' => $row->year,
                'students' => $students,
                'description' => mb_strtoupper($row->description),
                'active' => $row->active

            ];
        });
    }
}
