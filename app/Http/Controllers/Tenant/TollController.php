<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Person;
use App\Models\Tenant\Series;
use App\Models\Tenant\Toll;
use Illuminate\Http\Request;
use Modules\Inventory\Traits\InventoryTrait;
use Modules\Restaurant\Models\Area;
use Modules\Services\Data\ServiceData;

class TollController extends Controller
{
    use InventoryTrait;
    public function index()


    {
        $configuration = Configuration::first();
        return view('tenant.toll.index', compact('configuration'));
    }

    public function records()
    {
        $records = Toll::all();
        return compact('records');
    }

    public function tables()
    {
        $user = auth()->user();
        $customers = Person::where('name', 'like', '%varios%')->where('type', 'customers')->get();
        $establishment = Establishment::find($user->establishment_id);
        $series = Series::whereIn('document_type_id', ['03', '01'])->where('establishment_id', $user->establishment_id)->get();
        $area = Area::find($user->area_id);
        $printer = $area->printer ?? $establishment->printer;
        return compact('customers', 'series', 'printer');
    }

    public function items($warehouse_id, Request $request)

    {
        $description = $request->description;
        return [
            'items' => $this->optionsItemWareHousexId($warehouse_id, $description,null,true),
        ];
    }

    public function store(Request $request)
    {
        $ids = $request->ids;
        $count = 0;
        foreach ($ids as $item_id) {
            $toll = new Toll(["item_id" => $item_id]);
            $toll->save();
            $count += 1;
        }
        return ["success" => true, "message" => $count . " Agregados exitosamente."];
    }

    public function person($number, Request $request)
    {
        $name = $request->name;

        if ($name == true) {
            $customers = Person::where('name', 'like', '%' . $number . '%')->where('type', 'customers')->get()->take(10);
            return compact("customers");
        }

        $customers = Person::where('number', $number)->where('type', 'customers')->get()->take(10);

        if (count($customers) != 0) {
            return compact("customers");
        }
        $type = strlen($number) == 8 ? 'dni' : 'ruc';
        $data = ServiceData::service($type, $number);
        if ($data["success"]) {
            $id = $this->save_person($type, $number, $data["data"]);
            if ($id != null) {
                $customers = Person::where('id', $id)->get();
                return compact('customers');
            }
        }


        return ["success" => false, "message" => "Verifique los datos"];
    }

    function save_person($type, $number, $data)
    {
        $person = new Person;
        $person->type = "customers";
        $person->status = 1;
        $person->perception_agent = 0;
        $person->enabled = 1;
        $person->country_id = "PE";
        $person->number = $number;
        $person->identity_document_type_id = $type == 'dni' ? 1 : 6;
        $person->address = $data["direccion_completa"];
        if (array_key_exists("ubigeo", $data) && count($data["ubigeo"]) == 3) {
            $person->department_id = $data["ubigeo"][0];
            $person->province_id = $data["ubigeo"][1];
            $person->district_id = $data["ubigeo"][2];
        }

        if ($type == 'ruc') {
            $person->name = $data["nombre_o_razon_social"];
            $person->trade_name = $data["nombre_o_razon_social"];
            $person->condition = $data["condicion"];
            $person->state = $data["estado"];
        } else {
            $person->name = $data["nombre_completo"];
        }
        $person->save();
        return $person->id;
    }
}
