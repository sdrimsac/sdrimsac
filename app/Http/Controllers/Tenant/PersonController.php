<?php

namespace App\Http\Controllers\Tenant;
use Illuminate\Support\Str;

use Exception;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\Tenant\Person;
use Barryvdh\DomPDF\Facade as PDF;
use App\Imports\PersonsImport;
use App\Models\Tenant\Company;
use App\Models\Tenant\PersonType;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Catalogs\Country;
use App\Models\Tenant\Catalogs\District;
use App\Models\Tenant\Catalogs\Province;
use App\Models\Tenant\Catalogs\Department;
use App\Http\Requests\Tenant\PersonRequest;
use App\Http\Resources\Tenant\PersonResource;
use App\Http\Resources\Tenant\PersonCollection;
use App\Models\Tenant\Catalogs\IdentityDocumentType;
use App\Models\Tenant\ClientZone;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\PersonParient;
use App\Models\Tenant\UnitTypePerson;
use App\Models\Tenant\Warehouse;
use App\Services\RoleService;
use GuzzleHttp\Client;
use Modules\Report\Exports\ExportPersonsImport;
use Carbon\Carbon;
use Modules\Vip\Models\SocialMedias;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{

    public function generateNumber()
    {
        $regex = '/^1[0-9]{7}$/';
        $new_code = "";

        $persons = Person::where('number', 'regexp', '^1[0-9]{7}$')->orderBy('number', 'desc')->first();

        if (!$persons) {
            $new_code = "10000001";
        } else {
            $number = $persons->number;
            if (preg_match($regex, $number) === 1) {
                $new_code = str_pad(intval($number) + 1, 8, '0', STR_PAD_LEFT);
            } else {
                $new_code = "10000001";
            }
        }

        return response()->json(['number' => $new_code]);
    }
    public function index($type)
    {
        $is_arca = (new RoleService)->isArca();
        $api_service_token = config('configuration.api_service_token');
        return view('tenant.persons.index', compact('type', 'api_service_token', 'is_arca'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $new_request = [
                'file' => $request->file('file'),
                'type' => $request->input('type'),
            ];

            return $this->upload_image($new_request);
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
    function upload_image($request)
    {
        $file = $request['file'];
        $type = $request['type'];

        $temp = tempnam(sys_get_temp_dir(), $type);
        file_put_contents($temp, file_get_contents($file));

        $mime = mime_content_type($temp);
        $data = file_get_contents($temp);

        return [
            'success' => true,
            'data' => [
                'filename' => $file->getClientOriginalName(),
                'temp_path' => $temp,
                'temp_image' => 'data:' . $mime . ';base64,' . base64_encode($data)
            ]
        ];
    }


    public function client_default()
    {
        $establishment_id = auth()->user()->establishment_id;
        $establishment = Establishment::find($establishment_id);
        $customer_id = $establishment->customer_id;
        if ($customer_id) {
            $customer = Person::find($customer_id);
            return new PersonResource($customer);
        }
        return null;
    }
    public function serviceCe($cee)
    {
        $url = config('app.api_factiliza_service_url');
        $token = config('app.api_factiliza_service_token');
        $client = new Client(['base_uri' => $url]);
        $api = "/cee/info/" . $cee;
        $path = "/pe/v1";
        $response = $client->request('GET', $path . $api, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
        ]);
        $data = json_decode($response->getBody()->getContents());
        return $data;
    }
    public function clientsForGenerateCPE()
    {
        $typeFile = request('type');
        $filter = request('name');
        $persons = Person::without(['identity_document_type', 'country', 'department', 'province', 'district'])
            ->select('id', 'name', 'identity_document_type_id', 'number')
            ->where('type', 'customers')
            ->orderBy('name');
        if ($filter && $typeFile) {
            if ($typeFile === 'document') {
                $persons = $persons->where('number', 'like', "{$filter}%");
            }
            if ($typeFile === 'name') {
                $persons = $persons->where('name', 'like', "%{$filter}%");
            }
        }
        $persons = $persons->take(10)
            ->get();
        return response()->json([
            'success' => true,
            'data' => $persons,
        ], 200);
    }
    public function distritos()
    {
        $asesores = User::where('active', 1)->get();
        $district = District::where('province_id', '0501')->get();
        return compact('district', 'asesores');
    }
    public function columns()
    {
        return [
            'name' => 'Nombre',
            'number' => 'Número de DNI o RUC',
            'district_id' => 'Distritos',
            'alias' => 'Alias',
            'description' => 'Zona'

        ];
    }
    public function recordsApp(Request $request)
    {
        $records = Person::where('name', 'like', "%{$request->value}%")
            ->orWhere('number', 'like', "%{$request->value}%")
            ->orwhere('alias', 'like', "%{$request->value}")
            ->where('type', 'customers');

        return new PersonCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function listcustomer($type, Request $request)
    {
        //  return 'sd';
        $records = Person::where($request->column, 'like', "%{$request->value}%")
            ->where('type', $type)
            ->orderBy($request->column)->get();
        return $records;
        // return new PersonCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function records($type, Request $request)
    {
        $records = $this->getRecords($type, $request);

        return new PersonCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function getRecords($type, Request $request)
    {
        $has_credit_line = $request->credit === 'true';

        $user = auth()->user();

        $records = Person::where('type', $type);
        if (!$user || $user->type !== 'superadmin') {
            
            $records = $records->whereNotIn('name', ['CLIENTES VARIOS', 'CLIENTES VARIOS-MODIFICADO']);
        }

        if ($request->filled('column') && $request->column === 'description') {
            $records = $records->whereHas('zone', function ($query) use ($request) {
                $query->where('description', 'like', "%{$request->value}%");
            })
                ->join('client_zones', 'persons.client_zone_id', '=', 'client_zones.id')
                ->orderBy('client_zones.description');
        } elseif ($request->filled('column') && !empty($request->column)) {
            $records = $records->where($request->column, 'like', "%{$request->value}%")
                ->orderBy($request->column);
        }

        if ($has_credit_line) {
            $records = $records->where('has_credit_line', $has_credit_line);
        }

        return $records;
    }

    public function printer(Request $request)
    {
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        if ($request['seller_id'] != null && $request['district_id'] == null) {
            $records = Person::where('type', 'customers')->where('seller_id', $request->seller_id)->orderBy('name', 'asc')->get();
        } else if ($request['seller_id'] == null && $request['district_id'] != null) {
            $records = Person::where('type', 'customers')->where('district_id', $request->district_id)->orderBy('name', 'asc')->get();
        } else if ($request['seller_id'] == null && $request['district_id'] == null) {
            $records = Person::where('type', 'customers')->orderBy('name', 'asc')->get();
        } else {
            $records = Person::where('type', 'customers')->where('seller_id', $request->seller_id)->where('district_id', $request->district_id)->orderBy('name', 'asc')->get();
        }
        $pdf = PDF::loadView('tenant.persons.report', compact("records", "establishment", "company"))->setPaper('a4', 'landscape');
        return $pdf->stream('Listado_Clientes' . date('YmdHis') . '.pdf');

        //return new PersonCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function create()
    {
        return view('tenant.customers.form');
    }

    public function tables()
    {
        $users = User::orderBy('name')->get();
        $parent = PersonParient::all();
        // $item_unit_types = ItemUnitType::
        $item_unit_types = ItemUnitType::pluck('description')->unique()->values();
        $countries = Country::whereActive()->orderByDescription()->get();
        $departments = Department::whereActive()->orderByDescription()->get();
        $provinces = Province::whereActive()->orderByDescription()->get();
        $districts = District::whereActive()->orderByDescription()->get();
        $identity_document_types = IdentityDocumentType::whereActive()->get();
        $person_types = PersonType::get();
        $social_media = SocialMedias::all();
        $zones = ClientZone::all();
        $configuration = Configuration::first();
        $locations = $this->getLocationCascade();
        $api_service_token = config('configuration.api_service_token');
        $api_factiliza_token = config('configuration.api_factiliza_token');
        return compact(
            'item_unit_types',
            'configuration',
            'social_media',
            'zones',
            'countries',
            'departments',
            'provinces',
            'districts',
            'identity_document_types',
            'locations',
            'person_types',
            'api_service_token',
            'users',
            'parent',
        );
    }

    public function record($id)
    {
        $record = new PersonResource(Person::findOrFail($id));

        return $record;
    }

    function isClientesVarios($person){
        $name = $person->name;
        $number = $person->number;

        return (str_contains(strtolower($name), 'clientes varios') || $number == '99999999');

    }

    public function store(PersonRequest $request)
    {
        try{
        if ($request->state) {
            if ($request->state != "ACTIVO") {
                return [
                    'success' => false,
                    'message' => 'El estado del contribuyente no es activo, no puede registrarlo',
                ];
            }
        }
        $id = $request->input('id');
        $person = Person::firstOrNew(['id' => $id]);
        if($id){
            $is_clientes_varios = $this->isClientesVarios($person);
            if($is_clientes_varios){
                return [
                    'success' => false,
                    'message' => 'El cliente no puede ser editado',
                ];
            }
        }
        $person->fill($request->all());
        $user_id = auth()->id();
        $person->user_id = $user_id;

        $person->save();
        $temp_path = $request->input('temp_path');
        UnitTypePerson::where('customer_id', $person->id)->delete();
        $item_unit_types = $request->input('item_unit_types');
        if ($request->input('item_unit_types')) {
            foreach ($item_unit_types as $row) {
                $person->item_unit_types()->create(['description' => $row]);
            }
        }

        $person->addresses()->delete();
        $addresses = $request->input('addresses');
        if ($request->input('addresses')) {
            foreach ($addresses as $row) {
                $person->addresses()->updateOrCreate(['id' => $row['id']], $row);
            }
        }
    

            if ($temp_path) {
                $directory = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'persons' . DIRECTORY_SEPARATOR;
                
                // Check if directory exists and create it if not
                if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
                }
    
                $file_name_old = $request->input('image');
                $extension = 'jpg';
                
                if ($file_name_old) {
                $file_name_old_array = explode('.', $file_name_old);
                $extension = end($file_name_old_array) ?: 'jpg';
                }
                $temp_path = strtolower($temp_path);
                if (file_exists($temp_path) && is_readable($temp_path)) {
                    $file_content = file_get_contents($temp_path);
                    $datenow = date('YmdHis');
                    $file_name = Str::slug($person->name) . '-' . $datenow . '.' . $extension;
    
                    if ($file_content !== false) {
                        Storage::put($directory . $file_name, $file_content);
                    } else {
                        throw new \Exception('Could not read temporary file');
                    }
                } else {
                    throw new \Exception('Temporary file not accessible');
                }
                $person->image = $file_name;
    
            } elseif (!$request->input('image') && !$request->input('temp_path') && !$request->input('image_url')) {
                $person->image = Person::DEFAULT_USER_IMAGE;
            }
    
            // Guardar imagen adicional 1
            if ($request->input('temp_path_extra1')) {
                $directory = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'persons' . DIRECTORY_SEPARATOR;
                
                if (!Storage::exists($directory)) {
                    Storage::makeDirectory($directory);
                }
    
                $temp_path = $request->input('temp_path_extra1');
                // Verificar si existe el archivo (insensible a mayúsculas/minúsculas)
                if (!file_exists($temp_path)) {
                    $temp_path = strtolower($temp_path);
                }
                
                if (file_exists($temp_path)) {
                    $file_content = file_get_contents($temp_path);
                    $datenow = date('YmdHis');
                    $file_name = Str::slug($person->name) . '-extra1-' . $datenow . '.' . $extension;
                    
                    Storage::put($directory . $file_name, $file_content);
                    $person->image_extra1 = $file_name;
                } else {
                    throw new Exception('No se puede encontrar el archivo temporal');
                }
            }
    
            // Guardar imagen adicional 2
            if ($request->input('temp_path_extra2')) {
                $directory = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'persons' . DIRECTORY_SEPARATOR;
                
                if (!Storage::exists($directory)) {
                    Storage::makeDirectory($directory);
                }
    
                $file_name_old = $request->input('image_extra2');
                $extension = 'jpg';
                
                if ($file_name_old) {
                    $file_name_old_array = explode('.', $file_name_old);
                    $extension = end($file_name_old_array) ?: 'jpg';
                }
                
                $temp_path = $request->input('temp_path_extra2');
                // Verificar si existe el archivo (insensible a mayúsculas/minúsculas)
                if (!file_exists($temp_path)) {
                    $temp_path = strtolower($temp_path);
                }
                
                if (file_exists($temp_path)) {
                    $file_content = file_get_contents($temp_path);
                    $datenow = date('YmdHis');
                    $file_name = Str::slug($person->name) . '-extra2-' . $datenow . '.' . $extension;
                    
                    Storage::put($directory . $file_name, $file_content);
                    $person->image_extra2 = $file_name;
                } else {
                    throw new Exception('No se puede encontrar el archivo temporal');
                }
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }


        $person->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Cliente editado con éxito' : 'Cliente registrado con éxito',
            'data' => $person,
            'id' => $person->id
        ];
    }

    public function destroy($id)
    {
        try {

            $person = Person::findOrFail($id);
            $person_type = ($person->type == 'customers') ? 'Cliente' : 'Proveedor';
            $person->delete();

            return [
                'success' => true,
                'message' => $person_type . ' eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => "El {$person_type} esta siendo usado por otros registros, no puede eliminar"] : ['success' => false, 'message' => "Error inesperado, no se pudo eliminar el {$person_type}"];
        }
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new PersonsImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }

    public function getLocationCascade()
    {
        $locations = [];
        $departments = Department::where('active', true)->get();
        foreach ($departments as $department) {
            $children_provinces = [];
            foreach ($department->provinces as $province) {
                $children_districts = [];
                foreach ($province->districts as $district) {
                    $children_districts[] = [
                        'value' => $district->id,
                        'label' => $district->description
                    ];
                }
                $children_provinces[] = [
                    'value' => $province->id,
                    'label' => $province->description,
                    'children' => $children_districts
                ];
            }
            $locations[] = [
                'value' => $department->id,
                'label' => $department->description,
                'children' => $children_provinces
            ];
        }

        return $locations;
    }

    public function enabled($type, $id)
    {

        $person = Person::findOrFail($id);
        $person->enabled = $type;
        $person->save();

        $type_message = ($type) ? 'habilitado' : 'inhabilitado';

        return [
            'success' => true,
            'message' => "Cliente {$type_message} con éxito"
        ];
    }

    public function exportClients()
    {
        ini_set('memory_limit', '2048M');
        $records = Person::where('type', 'customers')->get();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No hay datos para exportar.'], 204);
        }

        $company = Company::first();

        return (new ExportPersonsImport)
            ->records($records)
            ->company($company)
            ->download('Clientes' . '_' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }
}
