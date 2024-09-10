<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Exports\ReportProductWarehouse;
use App\Models\Tenant\User;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\Table;
use App\Http\Resources\Tenant\UserCollection;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Series;
use App\Models\Tenant\UserSerie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Restaurant\Http\Requests\TableRequest;
use Modules\Restaurant\Http\Requests\WorkerRequest;

class WorkerController extends Controller
{


    public function index()
    {
        $establishments = Establishment::all();
        $configuration = Configuration::first();
        return view('restaurant::workers', compact('establishments', 'configuration'));
    }
    public function columns()
    {
        return [
            'nombre' => 'name',
            'estado' => 'active',
            'tipo usuario' => 'type'
        ];
    }

    public function report_products_w(Request $request)
    {
        $user_id = $request->user_id;
        $cash_id = $request->cash_id;
        $cash = Cash::find($cash_id);
        $user = $user_id ? User::find($user_id) : auth()->user();
        $establishment_id = isset($user->establishment_id) ? $user->establishment_id : auth()->user()->establishment_id;
        $establishment = Establishment::find($establishment_id);
        $company = Company::active();
        $records = ItemWarehouse::where('warehouse_id', $establishment_id)
            ->whereHas('item', function ($query) {
                $query->where('unit_type_id', '<>', 'ZZ');
            })
            ->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->item->description,
                    'stock' => $row->stock,
                    'internal_id' => $row->item->internal_id,
                    'category' => optional($row->item->category)->name,
                    'unit_type_id' => $row->item->unit_type_id,
                ];
            });
        $turn = $cash->turn->turn_desc;
        return (new ReportProductWarehouse)
            ->records($records)
            ->company($company)
            ->user($user)
            ->turn($turn)
            ->establishment($establishment)
            ->download('Stock_al_cerrar_caja_' . Carbon::now() . '.xlsx');
    }
    public function report_products()
    {
        $user = auth()->user();
        //el ultimo registro de Cash del usuario
        $cash = Cash::where('user_id', $user->id)->latest()->first();
        $turn = $cash->turn->turn_desc;
        $company = Company::active();
        $establishment_id = auth()->user()->establishment_id;
        $establishment = Establishment::find($establishment_id);
        $records = ItemWarehouse::where('warehouse_id', $establishment_id)
            ->whereHas('item', function ($query) {
                $query->where('unit_type_id', '<>', 'ZZ');
            })
            ->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->item->description,
                    'stock' => $row->stock,
                    'internal_id' => $row->item->internal_id,
                    'category' => optional($row->item->category)->name,
                    'unit_type_id' => $row->item->unit_type_id,
                ];
            });
        return (new ReportProductWarehouse)
            ->records($records)
            ->company($company)
            ->user($user)
            ->turn($turn)
            ->establishment($establishment)
            ->download('Stock_al_cerrar_caja_' . Carbon::now() . '.xlsx');
    }
    public function records(Request $request)
    {
        $configuration =  Configuration::first();

        $user_type = auth()->user()->type;
        $establishment_id = auth()->user()->establishment_id;
        $status = $request->input('qty_type');
        $name = $request->input('name');
        if ($user_type == 'admin') {
            $records = User::where('type', '<>', 'superadmin');
        } else {
            $records = User::query();
        }
        if ($user_type == 'seller') {
            $records = $records->where('type', '<>', 'superadmin')
                ->where('type', '<>', 'admin');
            if ($configuration->health_network) {
                $records =  $records->where('establishment_id', $establishment_id);
            }
        }
        if ($status !== null) {
            // Filtrar por estado (0 o 1)
            $records = $records->where('active', $status);
        }else {
            $records = $records->where('active', 1);
        }
        if ($name) {
            $records = $records->where('name', 'like', '%' . $name . '%');
        }

        return new UserCollection($records->paginate(150),);
    }
    public function record($id) //8
    {
        $worker = User::find($id);
        // $worker->series = 12;
        $user_serie = UserSerie::where('user_id', $id)
            ->whereHas('seriexxx', function ($oo) {
                $oo->where('document_type_id', '01');
            })
            ->first();
        if ($user_serie) {
            $worker->series = $user_serie->serie_id;
        }
        return [
            'success' => true,
            'data' => $worker,
            'has_series' => $user_serie ? true : false,
        ];
    }
    private function newPin()
    {
        $pin = $this->generatePIN();
        $isNew = false;

        while (!$isNew) {
            $pinExist = User::where('pin', $pin)->first();
            if ($pinExist) {
                $pin = "";
                $pin = $this->generatePIN();
            } else {
                $isNew = true;
            }
        }
        return $pin;
    }
    private function generatePIN($digits = 4)
    {
        $i = 0;
        $pin = "";
        while ($i < $digits) {
            $pin .= mt_rand(0, 9);
            $i++;
        }


        return $pin;
    }
    public function store(WorkerRequest $request)
    {
        $docs = [
            "NV"    => "80",
            "B"     => "03",
            "F"     => "01",
            "FD"    => "08",
            "ND"    => "08",
            "FC"    => "07",
            "BC"    => "07",
            "T"     => "09",
        ];
        $serie_id = $request->series;
        $id = $request->input('id');

        $user = User::firstOrNew(['id' => $id]);
        UserSerie::where('user_id', $id)->delete();
        //establishment_id
        $establishment_id = $user->establishment_id; //1
        if ($serie_id) {

            $serie = Series::where('id', $serie_id)->first();
            $number = $serie->number;
            $prefix = substr($number, -3); //F003 003


            foreach ($docs as $key => $value) {
                $prefix_serie = $key;
                $largo = strlen($prefix_serie);
                $prefix_to_search = null;
                if ($largo == 1) {
                    $prefix_to_search = $key . $prefix;
                } else {
                    $prefix_to_search = $key . substr($prefix, -2);
                }

                //NV002 F002 B002
                $serie_db = Series::where('document_type_id', $value)
                    ->where('number', $prefix_to_search)
                    ->where('establishment_id', $establishment_id)
                    ->first();
                if (!$serie_db) {
                    $serie_db = new Series;
                    $serie_db->document_type_id = $value;
                    $serie_db->number = $prefix_to_search;
                    $serie_db->establishment_id = $establishment_id;
                    $serie_db->save();
                }

                $user_serie = new UserSerie;
                $user_serie->user_id = $id;
                $user_serie->serie_id = $serie_db->id;
                $user_serie->save();
            }
        }

        //actualización
        if ($id) {
            $user->fill($request->all());

            // $user->establishment_id = auth()->user()->establishment_id;
        }
        //creando
        else {
            $pin =  $this->newPin();
            $user->pin = $pin;
            $user->type = 'seller';
            $user->fill($request->all());
            // $user->establishment_id = auth()->user()->establishment_id;
        }
        $user->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Trabajador actualizado con éxito' : 'Trabajador creado con éxito'
        ];
    }

    public function active($id)
    {
        $workers = User::find($id);
        $workers->active = !$workers->active;
        $workers->save();
        return [
            'success' => true,
            'data' => $workers,
            'message' => 'Usuario ' . ($workers->active ? 'activado' : 'desactivado')
        ];
    }
    public function destroy($id)
    {
        // $woker=User::findOrFail($id);
        // $woker->active=;
        // return [
        //     'success' => true,
        //     'message' => 'Eliminado con éxito'
        // ];
    }
}
