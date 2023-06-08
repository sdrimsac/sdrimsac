<?php

namespace Modules\Internet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Internet\Models\InternetConceptVariation;


class InternetConceptVariationController extends Controller
{

    public function store(Request $request)
    {
        $id = $request->id;
        $concept_id = $request->type_id;
        $price = $request->price;
        $description = $request->description;
        $variation = InternetConceptVariation::findOrNew($id);
        $variation->concept_id = $concept_id;
        $variation->price = $price;
        $variation->description = $description;
        $variation->save();
        return ["success" => true, "message" => $id ? "Concepto editado" : "Concepto creado"];
    }
}
