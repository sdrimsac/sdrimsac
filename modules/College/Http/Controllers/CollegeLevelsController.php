<?php

namespace Modules\College\Http\Controllers;

use App\Models\Tenant\Configuration;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\College\Models\CollegeDegree;
use Modules\College\Models\CollegeLevel;
use Modules\College\Models\CollegeSection;
use Modules\College\Models\CollegeTurn;

class CollegeLevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $configuration = Configuration::first();
        return view('college::levels', compact('configuration'));
    }

    public function records()
    {


        $levels = CollegeLevel::all();
        $sections = CollegeSection::all();
        $degrees = CollegeDegree::all();
        $turns = CollegeTurn::all();

        return compact('levels', 'sections', 'degrees', 'turns');
    }
    public function desactive($item, Request $request)
    {
        $id = $request->id;
        $model = null;
        switch ($item) {
            case 'turns':
                $model = CollegeTurn::class;
                break;
            case 'sections':
                $model = CollegeSection::class;
                break;
            case 'degrees':
                $model = CollegeDegree::class;
                break;
            case 'levels':
                $model = CollegeLevel::class;
                break;
        }

        if ($model) {
            $record = $model::find($id);
            $record->active = !$record->active;
            $record->save();
            return ["success" => true, "message" => $record->active ? "Activado con éxito" : "Desactivado con éxito"];
        }
        return ["success" => false, "message" => "No existe el tipo de registro."];
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('college::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store($item, Request $request)
    {
        $id = $request->id;
        $description = $request->description;
        $model = null;
        switch ($item) {
            case 'turns':
                $model = CollegeTurn::class;
                break;
            case 'sections':
                $model = CollegeSection::class;
                break;
            case 'degrees':
                $model = CollegeDegree::class;
                break;
            case 'levels':
                $model = CollegeLevel::class;
                break;
        }

        if ($model) {
            $record = $model::findOrNew($id);
            $record->description = mb_strtoupper($description);
            $record->save();
            return ["success" => true, "message" => $id ? "Editado con éxito" : "Creado con éxito"];
        }
        return ["success" => false, "message" => "No existe el tipo de registro."];
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('college::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('college::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
