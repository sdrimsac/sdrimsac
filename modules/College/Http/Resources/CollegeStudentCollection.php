<?php

namespace Modules\College\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\College\Models\CollegeMember;
use Modules\College\Models\CollegePayment;
use Modules\College\Models\CollegePlanService;
use Modules\College\Models\CollegeRegister;

class CollegeStudentCollection extends ResourceCollection
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
            $member = CollegeMember::where('children_id', $row->student_id)->first();
            $incomplete = false;
         
            $registers = CollegeRegister::where('active', 1)->where('member_id', $member->id)
                ->select('id')
                ->get();
            $incomplete = $registers->contains(function ($register) {
                return $register->lastCollegePayment && $register->lastCollegePayment->type === 'incomplete';
            });
            $classroom = $row->classroom;
            $degree = $classroom->degree->description;
            $section = $classroom->section->description;
            $level = $classroom->level->description;
            $turn = $classroom->turn->description;
            $class = $degree . '-' . $section;

            return [
                'member' => $member,
                'id'          => $row->id,
                'student' => $row->person,
                'classroom_id' => $row->classroom_id,
                'turn' => $turn,
                'level' => $level,
                'classroom' => $class,
                'payCompleted' => !$incomplete,

            ];
        });
    }
}
