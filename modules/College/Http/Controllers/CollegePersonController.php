<?php

namespace Modules\College\Http\Controllers;

use App\Models\Tenant\Catalogs\Country;
use App\Models\Tenant\Catalogs\Department;
use App\Models\Tenant\Catalogs\District;
use App\Models\Tenant\Catalogs\IdentityDocumentType;
use App\Models\Tenant\Catalogs\Province;
use Illuminate\Http\Request;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Person;
use Illuminate\Routing\Controller;
use Modules\College\Http\Resources\CollegeParentCollection;
use Modules\College\Http\Resources\CollegeParentUpdateResource;
use Modules\College\Models\CollegeAttorney;
use Modules\College\Models\CollegeMember;
use Modules\College\Models\CollegeParent;
use Modules\College\Models\CollegeStudent;
use Modules\Services\Data\ServiceData;

class CollegePersonController extends Controller
{
    public function members($parent_id)
    {
        $records = CollegeMember::where('parent_id', $parent_id)
            ->whereDoesntHave('student', function ($query) {
                $query->where('active', 1); 
            })
            // ->where(function ($query){
            //     $query->doesntHave('student')->orWhereHas('student', function ($query) {
            //         $query->where('active', 0);
            //     });
            // })
            ->get();
        return $records;
    }

    public function person($number, Request $request)
    {

        $type = $request->type;

        if ($type == 'student') {
            $child = Person::where('number', $number)->first();
            if ($child) {
                $student = CollegeStudent::where('student_id', $child->id)->first();
                if ($student) {
                    $classroom = $student->classroom;

                    return ["success" => false, "message" => mb_strtoupper($child->name . " ya se encuentra en " . $classroom->description)];
                } else {
                    return ["success" => false, "message" => mb_strtoupper($child->name . " ya se encuentra registrado/a")];
                }
            }
        }
        $type = strlen($number) == 8 ? 'dni' : 'ruc';
        $data = ServiceData::service($type, $number);
        if ($data["success"]) {
            return $data["data"];
        }


        return ["success" => false, "message" => "Verifique los datos"];
    }

    public function index()
    {
        $configuration = Configuration::first();

        return view('college::persons', compact('configuration'));
    }
    public function columns()
    {
        return [
            'description' => 'Nombre/Documento',
            'children'      => 'Hijo/a'
        ];
    }
    public function records_attorney(Request $request)
    {

        $description = $request->description;
        $records = CollegeAttorney::query();
        if ($description) {
            $records = $records->where('description', 'like', '%' . $description . '%');
        };
        $records = $records->get()->take(10);

        return compact('records');
    }
    public function create_attorney_type(Request $request)
    {
        $description = $request->description;

        $last_letter = strtolower(substr($description, -1));
        if ($last_letter == "a") {
            $description = substr_replace($description, "o", -1) . "/" .  $description;
        } elseif ($last_letter == "o") {
            $description = $description . "/" . substr_replace($description, "a", -1);
        }
        $description = mb_strtoupper($description);
        $exists = CollegeAttorney::where('description', $description)->first();
        if (isset($exists->id)) {
            return ["success" => false, "message" => "Ya existe esa relación"];
        }
        $attorney_type = new CollegeAttorney;
        $attorney_type->description = $description;
        $attorney_type->save();

        return [
            "success" => true,
            "message" => "Se creó el tipo",
            "id" => $attorney_type->id,
        ];
    }
    public function tables()
    {
        $departments = Department::whereActive()->get();
        $provinces = Province::whereActive()->get();
        $countries = Country::whereActive()->get();
        $districts = District::whereActive()->get();
        $identity_documents = IdentityDocumentType::whereIn('description', ['DNI', 'RUC', 'CE', 'CPP'])->get();
        return compact('departments', 'provinces', 'countries', 'districts', 'identity_documents');
    }

    public function records(Request $request)
    {
        $records = CollegeParent::query();
        $column = $request->column;
        $description = $request->value;
        if ($column == "description") {
            $records->whereHas('person', function ($query) use ($description) {
                $query->where('name', 'like', '%' . $description . '%')
                    ->orWhere('number', 'like', '%' . $description . '%');
            });
        }
        if ($column == "children") {
            $records->whereHas('member', function ($query) use ($description) {
                $query->whereHas('person', function ($query) use ($description) {
                    $query->where('name', 'like', '%' . $description . '%')
                        ->orWhere('number', 'like', '%' . $description . '%');
                });
            });
        }
        $records->orderBy('id', 'desc');
        return new CollegeParentCollection($records->paginate(20));
    }

    public function get_children($parent_id)
    {
        $members = CollegeMember::where('parent_id', $parent_id)->get();
        $records = [];
        foreach ($members as $member) {
            $children_id = $member['children_id'];
            $person = Person::find($children_id);
            $student = [];
            $student["name"] = $person->name;
            $student["number"] = $person->number;
            $exists = CollegeStudent::where('student_id', $children_id)
                ->where('active', 1)->first();
            if (isset($exists)) {
                $student["section"] = $exists->classroom->section;
                $student["degree"] = $exists->classroom->degree;
                $student["level"] = $exists->classroom->level;
                $student["turn"] = $exists->classroom->turn;
            }
            $records[] = $student;
        }

        return $records;
    }
    public function update_record($id, Request $request)
    {
        $from_person = $request->from_person;
        if ($from_person) {
            $parent = CollegeParent::where('parent_id', $id)->first();
        } else {
            $parent = CollegeParent::find($id);
        }

        $parent = new CollegeParentUpdateResource($parent);
        return $parent;
    }
    public function record($id)
    {
        $member = CollegeMember::find($id);

        return [
            'success' => true,
            'data' => $member
        ];
    }
    public function updateRecord(Request $request)
    {
        $number = $request->number;
        $children = $request->children;


        //actualizar los que tienen id
        // foreach ($children as $child) {
        //     $exist = Person::firstOrNew($child["id"]);
        //     if (isset($exist->id)) {
        //         return ["success" => false, "message" => "El estudiante " . $exist->name . " ya existe."];
        //     }
        // }
        $id = $request->id;
        $parent = CollegeParent::find($id);
        $person =  Person::find($parent->parent_id);
        $person->country_id = $request->country_id;
        $person->name = $request->name;
        $person->address = $request->address;
        $person->department_id = $request->department_id;
        $person->province_id = $request->province_id;
        $person->district_id = $request->district_id;
        $person->telephone = $request->phone;
        $person->email = $request->email;
        $person->type = 'customers';
        $person->identity_document_type_id = $request->identity_document_type_id;
        $person->number = $request->number;
        $person->save();

        $parent =  CollegeParent::where('parent_id', $person->id)->first();
        $parent->parent_id = $person->id;
        $parent->type = $request->type;
        $parent->attorney_id = $request->attorney_id;
        $parent->extra_phone = $request->extra_phone;
        $parent->save();
        foreach ($children as $child) {
            $student =  Person::firstOrNew(["number" => $child["number"]]);
            $student->country_id = $request->country_id;
            $student->name = $child["name"];
            $student->address = $request->address;
            $student->department_id = $request->department_id;
            $student->province_id = $request->province_id;
            $student->district_id = $request->district_id;
            $student->type = 'customers';
            $student->identity_document_type_id = $child["identity_document_type_id"];
            $student->number = $child["number"];
            $student->save();
            $member =  CollegeMember::firstOrNew(["children_id" => $student->id]);
            $member->parent_id = $parent->id;
            $member->children_id = $student->id;
            $member->save();
        }
        return [
            'success' => true,
            'message' => 'Registro Actualizado'
        ];
    }
    public function store(Request $request)
    {
        $exist = Person::where('number', $request->number)->first();
        $children = $request->children;
        if (isset($exist->id)) {

            return ["success" => false, "message" => "El cliente ya existe."];
        }
        foreach ($children as $child) {
            $exist = Person::where('number', $child["number"])->first();
            if (isset($exist->id)) {
                return ["success" => false, "message" => "El estudiante " . $exist->name . " ya existe."];
            }
        }

        $person = new Person;
        $person->country_id = $request->country_id;
        $person->name = $request->name;
        $person->address = $request->address;
        $person->department_id = $request->department_id;
        $person->province_id = $request->province_id;
        $person->district_id = $request->district_id;
        $person->telephone = $request->phone;
        $person->email = $request->email;
        $person->type = 'customers';
        $person->identity_document_type_id = $request->identity_document_type_id;
        $person->number = $request->number;
        $person->save();

        $parent = new CollegeParent;
        $parent->parent_id = $person->id;
        $parent->type = $request->type;
        $parent->attorney_id = $request->attorney_id;
        $parent->extra_phone = $request->extra_phone;
        $parent->save();

        foreach ($children as $child) {
            $student = new Person;
            $student->country_id = $request->country_id;
            $student->name = $child["name"];
            $student->address = $request->address;
            $student->department_id = $request->department_id;
            $student->province_id = $request->province_id;
            $student->district_id = $request->district_id;
            $student->type = 'customers';
            $student->identity_document_type_id = $child["identity_document_type_id"];
            $student->number = $child["number"];
            $student->save();
            $member = new CollegeMember;
            $member->parent_id = $parent->id;
            $member->children_id = $student->id;
            $member->save();
        }
        return [
            'success' => true,
            'message' => 'Registro creado'
        ];
    }
    public function destroy($id)
    {
        //
    }
}
