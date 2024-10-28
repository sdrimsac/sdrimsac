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
use App\Models\Tenant\Document;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Note;
use App\Models\Tenant\Series;
use App\Models\Tenant\User;
use App\Models\Tenant\VoidedDocument;
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

    public function salesMonthEstablishment(Request $request){
        $month = $request->month;
        $explode_month = explode('-', $month);
        $month = $explode_month[1];
        $year = $explode_month[0];
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $is_service = $establishment->is_service;
            $notes_ft = [];
            $notes_bv = [];
            $rejected_ft = [];
            $rejected_bv = [];
            $anulates_voided_ft = [];
            $anulates_voided_bv = [];
            $anulates_voided = VoidedDocument::whereHas('voided', function ($query) use ($month, $year) {
                $query->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            })
                ->whereHas('document', function ($query) use ($establishment) {
                    $query->where('establishment_id', $establishment->id);
                })
                ->get();
            foreach ($anulates_voided as $anulate_voided) {
                $series = $anulate_voided->document->series;
                $number = $anulate_voided->document->number;
                $document_full_number = $series . '-' . $number;
                if ($anulate_voided->document->document_type_id == '01')
                    $anulates_voided_ft[] = $document_full_number;
                if ($anulate_voided->document->document_type_id == '03')
                    $anulates_voided_bv[] = $document_full_number;
            }
            $ft_anulate = Document::select(['series', 'number'])->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '01')
                ->where('state_type_id', '11')
                ->get();

            foreach ($ft_anulate as $ft) {
                $series = $ft->series;
                $number = $ft->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $anulates_voided_ft)) {
                    $anulates_voided_ft[] = $document_full_number;
                }
            }
            $ft_rejected = Document::select(['series', 'number'])->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '01')
                ->where('state_type_id', '09')
                ->get();
            foreach ($ft_rejected as $ft) {
                $series = $ft->series;
                $number = $ft->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $rejected_ft)) {
                    $rejected_ft[] = $document_full_number;
                }
            }
            $fv_notes = Note::where('note_type', 'credit')->whereHas('affected_document', function ($query) use ($establishment, $month, $year) {
                $query->where('establishment_id', $establishment->id)
                    ->whereMonth('date_of_issue', $month)
                    ->where('document_type_id', '01')
                    ->whereYear('date_of_issue', $year);
            })->get();
            foreach ($fv_notes as $note) {
                $series = $note->document->series;
                $number = $note->document->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $notes_ft)) {
                    $notes_ft[] = $document_full_number;
                }
            }
            $bv_rejected = Document::select(['series', 'number'])->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '03')
                ->where('state_type_id', '09')
                ->get();
            foreach ($bv_rejected as $bv) {
                $series = $bv->series;
                $number = $bv->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $rejected_bv)) {
                    $rejected_bv[] = $document_full_number;
                }
            }
            $bv_notes = Note::where('note_type', 'credit')->whereHas('affected_document', function ($query) use ($establishment, $month, $year) {
                $query->where('establishment_id', $establishment->id)
                    ->whereMonth('date_of_issue', $month)
                    ->where('document_type_id', '03')
                    ->whereYear('date_of_issue', $year);
            })->get();

            foreach ($bv_notes as $note) {
                $series = $note->document->series;
                $number = $note->document->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $notes_bv)) {
                    $notes_bv[] = $document_full_number;
                }
            }

            $ft_total = Document::where('establishment_id', $establishment->id)
                ->where('state_type_id', '05')
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '01')
                ->sum('total');
            $bv_anulate = Document::select(['series', 'number'])->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '03')
                ->where('state_type_id', '11')
                ->get();
            foreach ($bv_anulate as $bv) {
                $series = $bv->series;
                $number = $bv->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $anulates_voided_bv)) {
                    $anulates_voided_bv[] = $document_full_number;
                }
            }
            $bv_total = Document::where('establishment_id', $establishment->id)
                ->where('state_type_id', '05')
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '03')
                ->sum('total');

            $first_ft = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '01')
                ->orderBy('number')
                ->first();

            $last_ft = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '01')
                ->orderBy('number', 'desc')
                ->first();

            $first_bv = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '03')
                ->orderBy('number')
                ->first();

            $last_bv = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '03')
        
                ->orderBy('number', 'desc')
                ->first();
            $has_bv_info = $first_bv || $last_bv || $bv_total || count($anulates_voided_bv) > 0;
            $has_ft_info = $first_ft || $last_ft || $ft_total || count($anulates_voided_ft) > 0;
            $records[] = [
                'notes_ft' => $notes_ft,
                'notes_bv' => $notes_bv,
                'rejected_ft' => $rejected_ft,
                'rejected_bv' => $rejected_bv,
                'has_bv_info' => $has_bv_info,
                'has_ft_info' => $has_ft_info,
                'establishment_id' => $establishment->id,
                'establishment' => $establishment->description,
                'is_service' => $is_service,
                'ft_total' => $ft_total,
                'bv_total' => $bv_total,
                'first_ft' => $first_ft,
                'last_ft' => $last_ft,
                'first_bv' => $first_bv,
                'last_bv' => $last_bv,
                'anulates_voided_ft' => $anulates_voided_ft,
                'anulates_voided_bv' => $anulates_voided_bv,
            ];


            return $records;
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
        // $warehouse = Warehouse::where('establishment_id', $establishment->id)->first();

        if($is_service && $id == null){
            $item_id = Item::where('unit_type_id', 'ZZ')->pluck('id')->toArray();
            //crea en la tabla item_warehouse todo los registros
            foreach ($item_id as $item) {
                $item_warehouse = new ItemWarehouse();
                $item_warehouse->item_id = $item;
                $item_warehouse->warehouse_id = $warehouse->id;
                $item_warehouse->stock = 0;
                $item_warehouse->save();
            }
        }
        if($is_product && $id == null){
            $item_id = Item::where('unit_type_id','<>','ZZ')->pluck('id')->toArray();
            foreach ($item_id as $item) {
                $item_warehouse = new ItemWarehouse();
                $item_warehouse->item_id = $item;
                $item_warehouse->warehouse_id = $warehouse->id;
                $item_warehouse->stock = 0;
                $item_warehouse->save();
            }
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
