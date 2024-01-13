<?php

namespace Modules\College\Http\Controllers;

use App\Models\Tenant\Configuration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\College\Http\Resources\CollegeClassroomCollection;
use Modules\College\Models\CollegeClassroom;
use Modules\College\Models\CollegeDegree;
use Modules\College\Models\CollegeLevel;
use Modules\College\Models\CollegePayment;
use Modules\College\Models\CollegePlanService;
use Modules\College\Models\CollegeRegister;
use Modules\College\Models\CollegeSection;
use Modules\College\Models\CollegeStudent;
use Modules\College\Models\CollegeTurn;

class CollegeClassroomController extends Controller
{

    public function changeClassroom(Request $request)
    {
        $classroom = CollegeStudent::where('student_id', $request->student_id)
            ->where('classroom_id', $request->classroom_id_old)->first();

        if (!isset($classroom)) {
            $classroom = new CollegeStudent();
            $classroom->student_id = $request->student_id;
            $classroom->classroom_id = $request->classroom_id_new;
            $classroom->save();
        } else {
            $classroom->classroom_id = $request->classroom_id_new;
            $classroom->save();
        }
        return [
            'success' => true,
            'message' => 'Salón cambiado'
        ];
    }
    public function students($classroom_id)
    {

        $students = CollegeStudent::where('active', 1)
            ->where('classroom_id', $classroom_id)->get()->transform(function ($row) {
                $member = $row->member;
                $incomplete = false;
                $registers = CollegeRegister::where('active', 1)->where('member_id', $member->id)->get();
                foreach ($registers as $register) {
                    $lastPayment =  CollegePayment::where('register_id', $register->id)
                        ->latest()->first();
                    if (isset($lastPayment)) {
                        if ($lastPayment->type == "incomplete") {
                            $incomplete = true;
                            break;
                        }
                    } else {
                        Log::info($register->id);
                    }
                }
                $person = $row->person;

                return [
                    "id" => $row->id,
                    "name" => $person->name,
                    "number" => $person->number,
                    "member" => $member,
                    "incomplete" => $incomplete,
                ];
            });

        return $students;
    }

    public function index()
    {
        $configuration = Configuration::first();
        return view('college::classrooms', compact('configuration'));
    }

    public function records(Request $request)
    {
        $degree_id = $request->degree_id;
        $turn_id = $request->turn_id;
        $section_id = $request->section_id;
        $level_id = $request->level_id;

        $records = CollegeClassroom::query();
        if ($degree_id) {
            $records = $records->where('degree_id', $degree_id);
        }
        if ($turn_id) {
            $records = $records->where('turn_id', $turn_id);
        }
        if ($section_id) {
            $records = $records->where('section_id', $section_id);
        }
        if ($level_id) {
            $records = $records->where('level_id', $level_id);
        }

        $records = $records->orderBy('created_at', 'desc');

        return new CollegeClassroomCollection($records->paginate(20));
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $degree_id = $request->degree_id;
        $turn_id = $request->turn_id;
        $section_id = $request->section_id;
        $level_id = $request->level_id;
        $places = $request->places;
        $year = Carbon::now();

        if (!isset($id)) {
            $exist = CollegeClassroom::where('degree_id', $degree_id)
                ->where('turn_id', $turn_id)
                ->where('section_id', $section_id)
                ->where('level_id', $level_id)->first();
            if (isset($exist->id)) {
                return
                    ["success" => false, "message" => "Ya existe el salón"];
            }
        }
        $classroom =  CollegeClassroom::findOrNew($id);
        $classroom->degree_id = $degree_id;
        $classroom->turn_id = $turn_id;
        $classroom->section_id = $section_id;
        $classroom->level_id = $level_id;
        $classroom->places = $places;
        $classroom->year = $year;
        $classroom->save();
        return ['success' => true, 'message' => $id ? 'Salón editado' : 'Salón creado'];
    }

    public function tables()
    {
        $sections = CollegeSection::all();
        $turns = CollegeTurn::all();
        $levels = CollegeLevel::all();
        $degrees = CollegeDegree::all();

        return compact('sections', 'turns', 'levels', 'degrees');
    }
}

// if ($request->service) {
//     $items = $items->where('unit_type_id', 'ZZ');
// }
