<?php

namespace Modules\Internet\Http\Controllers;

use App\Models\Tenant\Cash;
use App\Models\Tenant\ClientZone;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Desarrollador;
use App\Models\Tenant\Document;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\Person;
use App\Models\Tenant\SaleNote;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use App\Models\Tenant\ModelTenant;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Internet\Http\Resources\InternetRegisterCollection;
use Modules\Internet\Models\InternetConcept;
use Modules\Internet\Models\InternetConceptOperation;
use Modules\Internet\Models\InternetConceptVariation;
use Modules\Internet\Models\InternetOperation;
use Modules\Internet\Models\InternetPayment;
use Modules\Internet\Models\InternetPlan;
use Modules\Internet\Models\InternetPlanOperation;
use Modules\Internet\Models\InternetPlanVariation;
use Modules\Internet\Models\InternetRegister;
use Modules\Restaurant\Models\WorkersType;
use Modules\Services\Data\ServiceData;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

use Modules\Internet\Models\InternetItem;
use Modules\Internet\Models\InternetPaymentMonth;
use Modules\Internet\Models\InternetTech;
use Modules\Item\Models\ItemLot;

class InternetController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('internet::index');
    }
    function delete_image($image)
    {
        $imagePath = parse_url($image)['path'];
        return Storage::delete($imagePath);
    }
    public function image(Request $request)
    {
        $register_id = $request->id;
        $image = $request->image;
        $register = InternetRegister::find($register_id);
        if ($register->house_photo != null) {
            $this->delete_image($register->house_photo);
        }

        if ($image) {
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $imageBase64 = $image;
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageBase64));
            $fileName = uniqid() . '.' . $extension;
            Storage::disk('public')->put($fileName, $imageData);
            $imageUrl = asset('storage/' . $fileName);
            $register->house_photo = $imageUrl;
            $register->save();
        }
        return [
            "success" => true,
            "image" => $register->house_photo,
        ];
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
    public function create_tech($id)
    {
        $new_tech = new InternetTech([
            "person_id" => $id
        ]);
        $new_tech->save();

        return ["success" => true, "id" => $new_tech->id];
    }

    public function person($number)
    {
        $customers = Person::where('number', $number)->where('type', 'customers')->first();

        if (isset($customers)) {
            return ["success" => true, "data" => $customers];
        }
        $type = strlen($number) == 8 ? 'dni' : 'ruc';
        $data = ServiceData::service($type, $number);
        if ($data["success"]) {
            $id = $this->save_person($type, $number, $data["data"]);
            if ($id != null) {
                $customers = Person::find($id);
                return ["success" => true, "data" => $customers];
            }
        }


        return ["success" => false, "message" => "Verifique los datos"];
    }
    public function techs()
    {
        $techs = InternetTech::all();
        return compact('techs');
    }
    public function tables()
    {
        $zones  = ClientZone::all();
        $plans = InternetPlan::all();
        $concepts = InternetConcept::all();
        $techs = InternetTech::where('active', 1)->get();
        $items = Item::where('unit_type_id', '<>', 'ZZ')->get()->take(10);
        $service_item = Item::where('description', 'SERVICIO')->where('unit_type_id', 'ZZ')->first();
        return compact('plans', 'zones', 'concepts', 'items', 'service_item', 'techs');
    }
    public function pos()
    {
        $user = auth()->user();
        $cash_worker = WorkersType::where('description', 'like', '%CAJ%')->orWhere('description', 'like', '%caj%')->first();
        if ($cash_worker) {
            $id = $cash_worker->id;

            if ($user->worker_type_id != $id) {
                return redirect('/');
            }
        }
        $user_id = $user->id;
        $cash = Cash::where('user_id', $user_id)
            ->where('state', 1)
            ->get()
            ->last();
        $worker = true;
        $area_id = auth()->user()->area_id;
        $company = Company::first();
        $desarrollador = Desarrollador::first();
        $configuration = Configuration::first();
        $establishments = Establishment::where('id', auth()->user()->establishment_id)->first();
        $auth_login = auth()->user()->id;
        $cash_id = $cash ? $cash->id : 0;

        $pending_order = 0;
        return view('internet::worker.pos', compact('pending_order', 'area_id', 'cash_id', 'worker', 'establishments', 'configuration', 'auth_login', 'company', 'desarrollador'));
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('internet::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function contract($register_id)
    {
        $register = InternetRegister::find($register_id);
        $company = Company::first();
        $operation = InternetOperation::where('description', 'Instalación')->where('register_id', $register->id)->first();
        $total = $operation->get_operation_amount();
        $plan_operation = InternetPlanOperation::where('operation_id', $operation->id)->first();
        $plan_variation = InternetPlanVariation::where('id', $plan_operation->plan_id)->first();
        $plan = InternetPlan::find($plan_variation->plan_id);
        $concept_operation = InternetConceptOperation::where('operation_id', $operation->id)->first();
        $concept_price = 0;
        if ($concept_operation) {

            $concetp_variation = InternetConceptVariation::where('concept_id', $concept_operation->concept_id)->get();
            $concept_price = $concetp_variation->sum('price');
        }
        $items = InternetItem::where('register_id', $register_id)->get()->transform(function ($item) {

            return [
                "description" => $item->item->description,
                "quantity" => $item->quantity,
                "series" => count($item->series) == 0 ? null : array_map(function ($serie) {
                    return [
                        "series" => $serie["series"]
                    ];
                }, $item->series)
            ];
        })->toArray();


        try {
            $pdf = PDf::loadView("internet::formats.contracts", compact(
                'total',
                'register',
                'company',
                'operation',
                'plan_variation',
                'plan',
                'items',
                'concept_price'
            ))
                ->setPaper('a4', 'portrait');
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_file.pdf');
        // return view("internet::formats.contracts", compact('register', 'company', 'operation', 'plan_variation', 'plan','items','concept_price'));
    }

    public function records(Request $request)
    {
        $category = $request->category ?? 1; // 1 todos, 2 desactivados, 3 los que estan al dia, 4 los  que deben
        $value = $request->value;

        if ($category < 3) {
            $active = $category == 1 ? 1 : 0;
            $records = InternetRegister::where('active', $active);
            if ($value) {
                $records = $records->where('identifier', 'like', '%' . $value . '%')
                    ->whereHas('person', function ($query) use ($value) {
                        $query->where('enabled', 1);
                    })
                    ->orWhereHas('person', function ($query) use ($value) {
                        $query->where('enabled', 1)
                            ->where('number', 'like', '%' . $value . '%')
                            ->orWhere('name', 'like', '%' . $value . '%');
                    });
            }
        } else {
            $records = $this->filter_by_payment($category, $value);
        }




        $records = $records->orderBy('id', 'desc');

        return new InternetRegisterCollection($records->paginate(20));
    }

    function filter_by_payment($category, $value)
    {
        $today = Carbon::now()->format("Y-m-d");
        $sign = $category == 3 ? '>' : '<';
        $records = InternetRegister::join('persons', 'persons.id', '=', 'internet_register.person_id')
            ->join('internet_operations', 'internet_register.id', '=', 'internet_operations.register_id')
            ->join('internet_payments', function ($join) {
                $join->on('internet_operations.id', '=', 'internet_payments.operation_id')
                    ->whereRaw('internet_payments.id = (SELECT MAX(id) FROM internet_payments WHERE operation_id = internet_operations.id)');
            })
            ->join('internet_payment_month', 'internet_payments.id', '=', 'internet_payment_month.payment_id')->whereRaw("DATE_FORMAT(DATE_ADD(internet_payment_month.year, INTERVAL 1 MONTH), '%Y-%m-%d') $sign '$today'")
            ->where('internet_register.active', "=", "1")
            ->select('internet_register.*')
            ->distinct()
            ->groupBy('internet_register.id');

        if ($value != null) {
            $records = $records->where(function ($query) use ($value) {
                $query->where('internet_register.identifier', 'LIKE', "%$value%")
                    ->where('persons.enabled', 1)
                    ->orWhere(function ($query) use ($value) {
                        $query
                            ->where('persons.name', 'LIKE', "%$value%")
                            ->orWhere('persons.number', 'LIKE', "%$value%");
                    });
            });
        }


        return $records;
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $pay_month = $request->payMonth;
            $advance = $request->advance;
            $install = $request->install ?? 0;

            $exist = InternetRegister::where('identifier', $request->mac)->first();
            if ($exist) {
                return response()->json(["message" => "El id ya existe"], 400);
            }
            $person = Person::find($request->person_id);
            if ($request->phone) {

                if ($person && $person->telephone == null) {
                    $person->telephone = $request->phone;
                    $person->save();
                }
            }
            if ($request->zone_id) {
                $person->client_zone_id = $request->zone_id;
                $person->save();
            }
            $register = new InternetRegister([
                "person_id" => $request->person_id,
                "type" => $request->type,
                "installation_address" => $request->address,
                "reference_installation_address" => $request->address_reference ?? "-",
                "identifier" => $request->identifier,
                "pay_date" => $request->pay_date,
                "tech_id" => $request->tech_id,
                "mac" => $request->mac,
                "supplie" => $request->supplie,
                "date" => Carbon::parse($request->date)->format('Y-m-d'),
                "pay_date" => Carbon::parse($request->pay_date)->format('Y-m-d'),
                "end_date" => $request->end_date ?  Carbon::parse($request->end_date)->format('Y-m-d') : null,
                "active" => 1,
            ]);

            $register->save();
            $image = $request->image;
            if ($image) {

                $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                $imageBase64 = $image;
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageBase64));
                $fileName = uniqid() . '.' . $extension;
                Storage::disk('public')->put($fileName, $imageData);
                $imageUrl = asset('storage/' . $fileName);
                $register->house_photo = $imageUrl;
                $register->save();
            }

            $operation = new InternetOperation([
                "description" => "Instalación",
                "total" => floatval($request->total ?? 0) + floatval($request->install ?? 0),
                "register_id" => $register->id,
                "period" => 'unique',
                "active" => 1,
            ]);

            $operation->save();
            $plan_id = $request["plan_variation"]["id"];
            $plan_operation = new InternetPlanOperation([
                "operation_id" => $operation->id,
                "plan_id" => $plan_id
            ]);

            $plan_operation->save();
            $concepts = $request->concepts ?? [];
            foreach ($concepts as $concept) {
                $concept_operation = new InternetConceptOperation([
                    "operation_id" => $operation->id,
                    "concept_id" => $concept["id"]
                ]);
                $concept_operation->save();
            }
            $document_type = $request->document_type_id;
            $document_id = $request->documentId;
            $total = 0;
            $total_operation = $operation->get_operation_amount();
            $document_total = $install;
            if ($pay_month) {
                $document_total += $total_operation;
            }
            $old_client = $request->oldClient ?? false;
            if ($document_type && $document_id) {
                $model = $document_type == "80" ? SaleNote::class : Document::class;
                $document = $model::find($document_id);
                $total = $document->total;
                if ($advance) {
                    $total = $total - $advance["amount"];
                }
                $rest_document =  $document_total - $document->total;
                $payment = new InternetPayment([
                    "document_id" => $document_type != '80' ? $document_id : null,
                    "sale_note_id" => $document_type == '80' ? $document_id : null,
                    "operation_id" => $operation->id,
                    "type" => $old_client ? "complete" : (floatval($total) == (floatval($request->total ?? 0) + floatval($request->install ?? 0)) ? 'complete' : 'incomplete'),
                    "rest" => $rest_document > 0 ? $rest_document : 0,
                ]);



                $payment->save();
                $paid_date = $request->paidDate;

                // if ($pay_month && $paid_date == null) {
                if ($old_client == false) {
                    $date = Carbon::parse($request->date);
                    $pay_date = Carbon::parse($request->pay_date);
                    if ($date->eq($pay_date)) {
                        $pay_date->addMonth();
                    }

                    if ($pay_month) {
                        $payment_month = new InternetPaymentMonth([
                            "payment_id" => $payment->id,
                            "month" => $date->month,
                            "year" => $date->format("Y-m-d"),
                            "start_date" => $date->format("Y-m-d"),
                            "end_date" => $pay_date->format("Y-m-d"),
                            "state" => ($total_operation + $install) - $total == 0 ? "complete" : "incomplete",
                            "amount" => $total,
                            "rest" => $total_operation + $install - $total,
                        ]);
                        $payment_month->save();
                    }

                    if ($advance) {
                        $start_date = $advance["startDate"];
                        $end_date = $advance["lastDate"];
                        $amount = $advance["amount"];
                        $state = $advance["state"];
                        $total_operation = $this->get_operation_amount($operation->id);
                        $start_month = Carbon::parse($start_date)->month;
                        $payment_month = new InternetPaymentMonth([
                            "payment_id" => $payment->id,
                            "month" => $start_month,
                            "year" => Carbon::parse($start_date)->format("Y-m-d"),
                            "start_date" => Carbon::parse($start_date)->format("Y-m-d"),
                            "end_date" => Carbon::parse($end_date)->format("Y-m-d"),
                            "state" => $state,
                            "amount" => $amount,
                            "rest" => $total_operation - $amount,

                        ]);
                        $payment_month->save();
                    }
                } else {

                    $start_date = $request->date;
                    $paid_date = $request->paidDate;

                    $current_month = Carbon::parse($start_date);
                    $end_month = Carbon::parse($paid_date);
                    $payment_months = [];

                    while ($current_month->lte($end_month)) {
                        $payment_months[] = [
                            "payment_id" => $payment->id,
                            "month" => $current_month->month,
                            "year" =>  $current_month->format('Y-m-d')
                        ];
                        $current_month->addMonth();
                    }
                    DB::connection('tenant')->table("internet_payment_month")->insert($payment_months);
                }
            }


            $items = $request->installItems;

            foreach ($items as $item) {
                $series = $item["series"];
                foreach ($series as $serie) {
                    ItemLot::where('id', $serie["id"])->update(["has_sale" => 1]);
                }
                $newItem = new InternetItem([
                    "register_id" => $register->id,
                    "item_id" => $item["id"],
                    "quantity" => $item["quantity"],
                    "series" => $item["series"],
                ]);

                $newItem->save();
            }
            $operation->set_plan_concept_json();

            DB::commit();

            return ["success" => true];
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return ["success" => false];
        }
    }
    public function get_operation_amount($id)
    {
        $plan_operation = InternetPlanOperation::where('operation_id', $id)->first();
        $concept_operation = InternetConceptOperation::where('operation_id', $id)->get();
        $total = $plan_operation->plan->price;
        foreach ($concept_operation as $concept) {
            $total += $concept->concept->price;
        }
        return $total;
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('internet::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('internet::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
