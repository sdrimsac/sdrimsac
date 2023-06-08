<?php

namespace Modules\College\Http\Controllers;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\Item;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\College\Models\CollegePenalty;
use Modules\College\Models\CollegePeriod;
use Modules\College\Models\CollegePlan;
use Modules\College\Models\CollegePlanService;
use Modules\College\Models\CollegePlanType;

class CollegePlanController extends Controller
{

    public function active(Request $request)
    {

        $plan_id = $request->id;

        $plan = CollegePlan::find($plan_id);

        $plan->active = !$plan->active;
        $plan->save();

        return ["success" => true, "message" =>
        $plan->active ? "El plan se activó" : "El plan se desactivó"];
    }
    public function index()
    {
        $configuration = Configuration::first();
        return view('college::plans', compact('configuration'));
    }

    public function records(Request $request)
    {
        $see_all = (bool) $request->see_all;
        $column =  $request->column;
        $value =  $request->value;
        $date = Carbon::now();
        CollegePlan::where('validity_date', '<', $date)->update(["active" => 0]);

        $records = CollegePlan::orderByRaw('-validity_date DESC');

        switch ($column) {
            case 'description':
                $records = $records->where('description', 'like', '%' . $value . '%')
                    ->orWhere('name', 'like', '%' . $value . '%');
                break;
            case 'validity_date':
                $value = Carbon::parse($value);
                $records = $records->whereDate('validity_date', $value);
                break;
            case 'payment_date':
                $value = Carbon::parse($value);
                $records = $records->whereDay('payment_date', $value->format('d'));
                //$q->whereDay('created_at', '=', date('d'));
                break;
        }
        if ($see_all == false) {
            $records = $records->where('active', 1);
        } else {
            $records = $records->where('active', 0);
        }
        $records = $records->get()->transform(function ($row) {
            $services = CollegePlanService::where('plan_id', $row->id)->get();
            return [
                "id" => $row->id,
                "name" => $row->name,
                "period" => $row->period,
                "period_id" => $row->period_id,
                "description" => $row->description,
                "services" => $services,
                "penalty" => $row->penalty,
                "days_extension" => $row->days_extension,
                "penalty_id" => isset($row->penalty) ? $row->penalty->id : null,
                "validity_date" => isset($row->validity_date) ? Carbon::parse($row->validity_date)->format("d/m/y") : null,
                "payment_date" => isset($row->payment_date) ? Carbon::parse($row->payment_date)->format("d/m/Y") : null,
                "active" => !!$row->active,
                'type_id' => $row->type_id,
                'type' => $row->type
            ];
        });
        return $records;
    }

    public function store(Request $request)
    {
        $id = $request->id;
        CollegePlanService::where('plan_id', $id)->delete();
        $plan = CollegePlan::findOrNew($id);
        $plan->name = $request->name;
        $plan->description = $request->description;
        $plan->period_id = $request->period_id;
        $plan->type_id = $request->type_id;
        $plan->days_extension = $request->days_extension;
        $plan->penalty_id = $request->penalty_id;
        $plan->validity_date = isset($request->validity_date) ? Carbon::parse($request->validity_date) : null;
        $plan->payment_date = isset($request->payment_date) ? Carbon::parse($request->payment_date) : null;
        $services = $request->services;

        $plan->count = 1;
        $plan->save();
        try {
            foreach ($services as $service) {
                $college_service = new CollegePlanService;
                $college_service->plan_id = $plan->id;
                $college_service->item_id = $service['item_id'];
                $college_service->price = $service['price'];
                $college_service->save();
            }
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage(),

                'success' => false, 'message' => 'Ocurrió un error al agregar los servicios'
            ];
        }


        return ['success' => true, 'message' => $id ? 'Plan editado' : 'Plan creado'];
    }

    public function tables()
    {
        $penalties = CollegePenalty::all();
        $periods = CollegePeriod::all();
        $types = CollegePlanType::all();
        $items = Item::where('unit_type_id', 'ZZ')->get()->take(15);

        return compact('periods', 'items', 'types', 'penalties');
    }

    public function columns()
    {
        return [
            'description' => 'Nombre/Descripción',
            "validity_date" => 'Fecha de vigencia',
            "payment_date" => 'Fecha de pago',
        ];
    }
}

// if ($request->service) {
//     $items = $items->where('unit_type_id', 'ZZ');
// }