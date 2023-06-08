<?php

namespace Modules\College\Http\Controllers;

use App\Models\Tenant\Configuration;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\College\Http\Resources\CollegeStudentCollection;
use Modules\College\Models\CollegeStudent;

class CollegeStudentController extends Controller
{

    public function index()
    {
        $configuration = Configuration::first();
        return view('college::students', compact('configuration'));
    }

    public function records(Request $request)
    {

        $records = CollegeStudent::query();
        if ($request->column && $request->column == "description" && $request->value) {
            $description = $request->value;
            $records->whereHas('person', function ($query) use ($description) {
                $query->where('name', 'like', '%' . $description . '%')
                    ->orWhere('number', 'like', '%' . $description . '%');
            });
        }
        $records = $records->latest();
        

        return new CollegeStudentCollection($records->paginate(20));
    }

    public function columns()
    {
        return [
            'description' => 'Nombre/Documento',
        ];
    }
}
