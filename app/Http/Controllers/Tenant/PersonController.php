<?php

namespace App\Http\Controllers\Tenant;

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
use Modules\Vip\Models\SocialMedias;

class PersonController extends Controller
{
    public function index($type)
    {
        $api_service_token = config('configuration.api_service_token');
        return view('tenant.persons.index', compact('type', 'api_service_token'));
    }
    public function distritos()
    {
        $asesores = User::where('active',1)->get();
        $district = District::where('province_id', '0501')->get();
        return compact('district', 'asesores');
    }
    public function columns()
    {
        return [
            'name' => 'Nombre',
            'number' => 'Número',
            'district_id' => 'Distritos'
        ];
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
        //  return 'sd';
        $records = Person::where($request->column, 'like', "%{$request->value}%")
            ->where('type', $type)
            ->orderBy($request->column);

        return new PersonCollection($records->paginate(config('tenant.items_per_page')));
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

        $countries = Country::whereActive()->orderByDescription()->get();
        $departments = Department::whereActive()->orderByDescription()->get();
        $provinces = Province::whereActive()->orderByDescription()->get();
        $districts = District::whereActive()->orderByDescription()->get();
        $identity_document_types = IdentityDocumentType::whereActive()->get();
        $person_types = PersonType::get();
        $social_media = SocialMedias::all();
        $zones = ClientZone::all();
        $locations = $this->getLocationCascade();
        $api_service_token = config('configuration.api_service_token');
        return compact('social_media', 'zones', 'countries', 'departments', 'provinces', 'districts', 'identity_document_types', 'locations', 'person_types', 'api_service_token', 'users');
    }

    public function record($id)
    {
        $record = new PersonResource(Person::findOrFail($id));

        return $record;
    }

    public function store(PersonRequest $request)
    {

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
        $person->fill($request->all());
        $person->save();

        $person->addresses()->delete();
        $addresses = $request->input('addresses');
        if ($request->input('addresses')) {
            foreach ($addresses as $row) {
                $person->addresses()->updateOrCreate(['id' => $row['id']], $row);
            }
        }
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
}
