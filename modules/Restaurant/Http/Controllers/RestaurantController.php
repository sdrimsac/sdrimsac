<?php

namespace Modules\Restaurant\Http\Controllers;

use Illuminate\Support\Str;
use App\Events\OrderEvent;
use App\Events\ReceiveOrder;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Customer;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Person;
use App\Models\Tenant\Series;
use App\Models\Tenant\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Restaurant\Http\Requests\AreaRequest;
use Modules\Restaurant\Http\Requests\WorkersTypeRequest;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\WorkersType;

use Illuminate\Support\Facades\Session;
use Modules\College\Models\CollegeParent;
use Modules\College\Models\CollegeStudent;
use Modules\Restaurant\Models\Table;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('restaurant::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('restaurant::create');
    }


    public function workers_type()
    {
        return view('restaurant::configuration.workers_type');
    }
    public function search_customer(Request $request)
    {
        $configuration = Configuration::first();
        $value = $request->value;
        $parents = $request->parents;

        $persons = Person::query();



        $persons = $persons
            ->where('name', 'like', '%' . $value . '%')
            ->orWhere('number', 'like', '%' . $value . '%')
            ->orWhere('address', 'like', '%' . $value . '%')
            ->whereType('customers')->orderBy('name')
            ->whereIsEnabled();

        if ($parents) {
            $persons = $persons->whereIn('id', function ($query) {

                $query->select('parent_id')
                    ->from('parents');
            });
        }
        $persons = $persons->take(20)->get()->transform(function ($row) {
            $students = CollegeStudent::whereHas('member', function ($query) use ($row) {
                $query->whereHas('parent', function ($query) use ($row) {
                    $query->where('parent_id', $row->id);
                });
            })->get()->transform(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->person->name,
                    'class' => mb_strtoupper($student->classroom->description),
                ];
            });
            return [
                'students' => $students,
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id,
                'identity_document_type_code' => $row->identity_document_type->code,
                'addresses' => $row->addresses,
                'address' =>  $row->address,
                'seller_id' =>  $row->seller_id,
                'phone' => $row->telephone,
            ];
        });

        return compact('persons');
    }
    public function workers_type_records()
    {
        $workers_type = WorkersType::all();

        return [
            'success' => true,
            'data' => $workers_type
        ];
    }
    public function workers_type_record($id)
    {
        $workers_type = WorkersType::find($id);

        return [
            'success' => true,
            'data' => $workers_type
        ];
    }
    public function workers_type_store(WorkersTypeRequest $request)
    {
        $id = $request->input('id');
        $worker_type = WorkersType::firstOrNew(['id' => $id]);
        $worker_type->fill($request->all());
        $worker_type->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Tipo actualizado con éxito' : 'Tipo creado con éxito'
        ];
    }
    public function areas()
    {
        return view('restaurant::configuration.areas');
    }
    public function areas_records()
    {
        $areas = Area::where('active', 1)->get();

        return [
            'success' => true,
            'data' => $areas
        ];
    }
    public function areas_record($id)
    {
        $area = Area::find($id);

        return [
            'success' => true,
            'data' => $area
        ];
    }
    public function areas_store(AreaRequest $request)
    {
        $id = $request->input('id');
        $area = Area::firstOrNew(['id' => $id]);
        $area->fill($request->all());
        $area->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Área actualizada con éxito' : 'Área creada con éxito'
        ];
    }
    public function sendOrder(Request $request)
    {
        $data = $request->all();
        event(new OrderEvent($data));
        return [
            'success' => true,
            'message' => 'Orden enviada'
        ];
    }
    public function receiveOrder(Request $request)
    {
        $data = $request->all();
        event(new ReceiveOrder($data));
        return [
            'success' => true,
            'message' => 'Orden enviada'
        ];
    }
    public function login(Request $request)
    {
        try {
            if (!$request->pin) {
                return [
                    'success' => false,
                    'message' => "Ingrese el PIN de Usuario"
                ];
            }
            $pin = $request->pin;
            $user = User::where('pin', $pin)->first();
            if ($user != null) {
                if ($user->active == 0) {
                    return [
                        'success' => false,
                        'message' => "Usuario Desactivado"
                    ];
                }
            }
            if (!$user) {
                return [
                    'success' => false,
                    'message' => "Pin Incorrecto / Intente Nuevamente"
                ];
            }
            Auth::login($user);
            //comprobar si el $user tiene api_token en caso que no lo tuvieran crearle uno
            if (!$user->api_token) {
                $user->api_token = Str::random(60);
                $user->save();
            }
            $worker_type = $user->worker_type;
            $description =  "";
            if($worker_type){
                $description =  strtolower($worker_type->description);
            }
            if ($user->type == "admin" || $user->type == "superadmin" ||$description == "contador" || $description == "arca") {
                return ['success' => true,];
            }
            $pos = false;
            $kitchen = false;
            $waiter = false;
            $cleaner = false;
            $maintenance = false;
            $collector = false;
            $logistic = false;
            if (strtolower($user->worker_type->description) == "mozo") {
                $waiter = true;
            } else if (strtolower($user->worker_type->description) == "peaje") {
                $collector =  true;
            } 
            else if (strtolower($user->worker_type->description) == "limpieza") {
                $cleaner =  true;
            } 
            else if (strtolower($user->worker_type->description) == "logistica") {
                $logistic =  true;
            } 
            else if (strtolower($user->worker_type->description) == "mantenimiento") {
                $maintenance =  true;
            }
            
            else {
                $cocina = strripos(strtolower($user->area->description), "cocina");
                $caja = strripos(strtolower($user->area->description), "caja");
                $hotel = strripos(strtolower($user->area->description), "hotel");
                $peaje = strripos(strtolower($user->area->description), "peaje");
                if ($cocina !== false) {
                    $kitchen = true;
                } else if ($caja !== false) {
                    $pos = true;
                }
                
                else if($hotel !== false ){
                    $pos = true;
                }
                else {
                    $kitchen = true;
                }
            }
            $series = Series::whereIn('document_type_id', ["01","03","80"])->get();
            $establishment = Establishment::find($user->establishment_id);
            $configuration = Configuration::first();
            $area = Area::find($user->area_id);
            return [
                'area' => $area,
                'series' => $series,
                'establishment' => $establishment,
                'configuration' => $configuration,
                'success' => true,
                'kitchen' => $kitchen,
                'logistic' => $logistic,
                'pos' => $pos,
                'waiter' => $waiter,
                "collector" => $collector,
                "cleaner" => $cleaner,
                "maintenance" => $maintenance,
                'user' => $user,
            ];
        } catch (Exception $e) {
            return [
                "message" => $e->getMessage(),
                "success" => false,

            ];
        }
    }
    public function loginWorker()
    {
        $configuration = Configuration::first();
        $event_name = $configuration->socket_channel;
        if (!$event_name) {
            $configuration->socket_channel = Str::random(10);
            $configuration->save();
            $event_name = $configuration->socket_channel;
        }

        return view('restaurant::worker.login');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('restaurant::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('restaurant::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
