<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Models\Tenant\Person;
use App\Models\Tenant\Warehouse;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Catalogs\Country;
use App\Models\Tenant\Catalogs\District;
use App\Models\Tenant\Catalogs\Province;
use App\Models\Tenant\Catalogs\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\EstablishmentRequest;
use App\Http\Resources\Tenant\EstablishmentResource;
use App\Http\Resources\Tenant\EstablishmentCollection;

use App\Models\Tenant\Company;
use App\Models\Tenant\ConfEstablishment;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Series;
use App\Models\Tenant\User;
use Illuminate\Http\Request;

class EstablishmentController extends Controller
{
    public function index()
    {
        $company = Company::first();
        $config = Configuration::first();
        return view('tenant.establishments.index', compact('company','config'));
    }

    public function create()
    {
        return view('tenant.establishments.form');
    }

    public function tables()
    {
        $countries = Country::whereActive()->orderByDescription()->get();
        $departments = Department::whereActive()->orderByDescription()->get();
        $provinces = Province::whereActive()->orderByDescription()->get();
        $customers = Person::where('type', 'customers')->get();
        $districts = District::whereActive()->orderByDescription()->get();

        return compact('countries', 'departments', 'provinces', 'districts', 'customers');
    }

    public function record($id)
    {
        $record = new EstablishmentResource(Establishment::findOrFail($id));

        return $record;
    }
    public function uploadFile(Request $request)
    {
        $id = $request->id;
        if ($request->hasFile('file')) {
            $establishment = Establishment::find($id);
            $name_file = join("_", explode(" ", $establishment->description));
            $company = Company::active();
            $type = $request->input('type');
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            $name = $type . '_' . $name_file . '_' . $company->number . '.' . $ext;
            if (($type === 'logo')) request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048']);
            $file->storeAs(($type === 'logo') ? 'public/uploads/logos' : 'certificates', $name);
            if (($type === 'logo_store')) request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048']);
            $file->storeAs(($type === 'logo_store') ? 'public/uploads/logos' : 'certificates', $name);
            if (($type === 'document_logo')) request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048']);
            $file->storeAs(($type === 'document_logo') ? 'public/uploads/logos' : 'certificates', $name);
            $establishment->$type = $name;
            $establishment->save();
            return [
                'success' => true,
                'message' => __('app.actions.upload.success'),
                'name' => $name,
                'type' => $type
            ];
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }

    public function update_conf(Request $request){
        $conf_id = $request->id;

        $conf = ConfEstablishment::findOrFail($conf_id);
        $conf->fill($request->all());
        $conf->save();
        return [
            'success' => true,
            'message' => 'Configuración actualizada'
        ];


    }
    public function store(EstablishmentRequest $request)
    {
        $id = $request->input('id');
        $conf = $request->conf;
        $establishment = Establishment::firstOrNew(['id' => $id]);

        $establishment->fill($request->all());
        $is_service = $establishment->is_service;
        $is_product = $establishment->is_product;
        $warehouse = Warehouse::where('establishment_id', $id)->first();
        if($is_service && $id == null){
            $item_id = Item::where('unit_type_id', 'ZZ')->pluck('id')->toArray();
            //crea en la tabla item_warehouse todo los registros
            foreach ($item_id as $item) {
                $item_warehouse = new ItemWarehouse();
                $item_warehouse->item_id = $item;
                $item_warehouse->warehouse_id = $warehouse->id;
                $item_warehouse->save();
            }
        }
        if($is_product && $id == null){
            $item_id = Item::where('unit_type_id','<>','ZZ')->pluck('id')->toArray();
            foreach ($item_id as $item) {
                $item_warehouse = new ItemWarehouse();
                $item_warehouse->item_id = $item;
                $item_warehouse->warehouse_id = $warehouse->id;
                $item_warehouse->save();
            }
        }
        $direct_printing = $request->input('direct_printing');
        if($direct_printing){
            $establishment->direct_printing = 1;
        }else{
            $establishment->direct_printing = 0;
        }
        $establishment->save();
        $series = $request->series;
        if (!$id) {
            $warehouse = new Warehouse();
            $warehouse->establishment_id = $establishment->id;
            $warehouse->description = 'Almacén - ' . $establishment->description;
            $warehouse->save();
        } else {
            $warehouse =  Warehouse::where('establishment_id', $id)->first();
            $warehouse->description = 'Almacén - ' . $establishment->description;
            $warehouse->save();
        }
        if (isset($conf)) {
            $exist = ConfEstablishment::firstOrNew(['establishment_id' => $establishment->id]);
            $exist->direct_sale =
                Functions::valueKeyInArray($conf, 'direct_sale', false);
            $exist->company_address =
                Functions::valueKeyInArray($conf, 'company_address', false);
                $exist->print_command =
                Functions::valueKeyInArray($conf, 'print_command', true);
                $exist->show_discounts_payment =
                Functions::valueKeyInArray($conf, 'show_discounts_payment', true);
                $exist->show_payment_method =
                Functions::valueKeyInArray($conf, 'show_payment_method', true);
                
            $exist->save();
        }
        //series
        if (isset($series)) {
            foreach ($series as  $serie) {
                $new_serie = new Series;
                $new_serie->contingency = 0;
                $new_serie->number = $serie["serie"];
                $new_serie->document_type_id = $serie["id"];
                $new_serie->establishment_id = $establishment->id;
                $new_serie->save();
            }
        }



      
        return [
            'success' => true,
            'message' => ($id) ? 'Establecimiento actualizado' : 'Establecimiento registrado'
        ];
    }

    public function records()
    {
        $records = Establishment::all();

        return new EstablishmentCollection($records);
    }

    public function destroy($id)
    {
        $establishment = Establishment::findOrFail($id);
        ConfEstablishment::where('establishment_id', $id)->delete();
        User::where('establishment_id', $id)->delete();
        Series::where('establishment_id', $id)->delete();
        $establishment->delete();

        return [
            'success' => true,
            'message' => 'Establecimiento eliminado con éxito'
        ];
    }
}
