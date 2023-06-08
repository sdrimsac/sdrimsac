<?php

namespace Modules\Internet\Http\Controllers;

use App\Models\Tenant\Cash;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Desarrollador;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\Person;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Internet\Models\InternetConcept;
use Modules\Internet\Models\InternetConceptVariation;
use Modules\Internet\Models\InternetPlan;
use Modules\Internet\Models\InternetPlanVariation;
use Modules\Restaurant\Models\WorkersType;
use Modules\Services\Data\ServiceData;

class InternetPlanVariationController extends Controller
{

    public function store(Request $request)
    {
        $id = $request->id;
        $plan_id = $request->type_id;
        $price = $request->price;
        $description = $request->description;
        $variation = InternetPlanVariation::findOrNew($id);
        $variation->plan_id = $plan_id;
        $variation->price = $price;
        $variation->description = $description;
        $variation->save();
        return ["success" => true, "message" => $id ? "Variación editada" : "Variación creada"];
    }
}
