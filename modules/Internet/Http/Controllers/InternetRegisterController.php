<?php

namespace Modules\Internet\Http\Controllers;

use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Series;
use Carbon\Carbon;
use Exception;
use App\Models\Tenant\ModelTenant;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Internet\Http\Resources\InternetPaymentCollection;
use Modules\Internet\Models\InternetConcept;
use Modules\Internet\Models\InternetConceptOperation;
use Modules\Internet\Models\InternetConceptVariation;
use Modules\Internet\Models\InternetOperation;
use Modules\Internet\Models\InternetPayment;
use Modules\Internet\Models\InternetPaymentMonth;
use Modules\Internet\Models\InternetPlan;
use Modules\Internet\Models\InternetPlanOperation;
use Modules\Internet\Models\InternetPlanVariation;
use Modules\Internet\Models\InternetRegister;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Modules\Internet\Exports\RegisterExport;
use Modules\Internet\Models\InternetSuspension;

class InternetRegisterController extends Controller
{
    public function update_plan(Request $request)
    {
        $rest = $request->rest ?? 0;
        $operation_id = $request->operation_id;
        $operation = InternetOperation::find($operation_id);
        InternetPlanOperation::where('operation_id', $operation_id)->delete();
        InternetConceptOperation::where('operation_id', $operation_id)->delete();

        $plan_id = $request->plan_variation_id;
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
        $document_type_id = $request->document_type_id;
        $document_id = $request->document_id;
        $type = $request->type;
        $payment = new InternetPayment([
            "type" => $type ?? "complete",
            "document_id" => $document_type_id != "80" ? $document_id : null,
            "sale_note_id" => $document_type_id == "80" ? $document_id : null,
            "operation_id" => $operation_id,
        ]);
        $model = Model::class;
        $model = $document_type_id != "80" ? Document::class : SaleNote::class;
        $model = $model::find($document_id);
        $payment->save();
        $day = Carbon::parse($operation->register->pay_date)->format('d');
        $total_document = floatval($model->total);
        $lastPayment = InternetPaymentMonth::whereHas('payment', function ($query) use ($operation_id) {
            $query->where('operation_id', $operation_id);
        })->orderBy('id', 'desc')->first();
        $start_date = $lastPayment ? Carbon::parse($lastPayment->end_date) : Carbon::parse($operation->register->pay_date);
        $end_date = $start_date->copy()->addMonth();
        $month_payment = new InternetPaymentMonth([
            "month" => $start_date->format('m'),
            "payment_id" => $payment->id,
            "year" => $this->create_date($start_date->format('m'), $day),
            "start_date" => $start_date->format("Y-m-d"),
            "end_date" => $end_date->format("Y-m-d"),
            "state" => $rest == 0 ? "complete" : "incomplete",
            "amount" => $total_document,
            "rest" =>  $rest,
        ]);
        $month_payment->save();
        $operation->set_plan_concept_json();
        return ["success" => true];
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
                    ->orWhere(function ($query) use ($value) {
                        $query->where('persons.name', 'LIKE', "%$value%")
                            ->orWhere('persons.number', 'LIKE', "%$value%");
                    });
            });
        }


        return $records;
    }

    public function export(Request $request)
    {
        $type = $request->type ?? 'pdf';
        $company = Company::first();
        if (Auth::user()) {

            $establishment = Establishment::find(Auth::user()->establishment_id);
        } else {
            $establishment = Establishment::first();
        }
        $category = $request->category ?? 1;
        $value = $request->value;
        if ($category < 3) {
            $active = $category == 1 ? 1 : 0;
            $records = InternetRegister::where('active', $active);
            if ($value) {
                $records = $records->where('identifier', 'like', '%' . $value . '%')
                    ->orWhereHas('person', function ($query) use ($value) {
                        $query->where('number', 'like', '%' . $value . '%')
                            ->orWhere('name', 'like', '%' . $value . '%');
                    });
            }
        } else {
            $records = $this->filter_by_payment($category, $value);
        }
        $records = $records->orderBy('id', 'desc')->get();

        if ($type == 'pdf') {
            $pdf = PDF::loadView('internet::formats.report_pdf', [
                'category' => $category,
                'records' => $records,
                'company' => $company,
                'establishment' => $establishment
            ]);
            return $pdf->download('reporte.pdf');
        } else {
            return (new RegisterExport)
                ->category($category)
                ->records($records)
                ->company($company)
                ->establishment($establishment)
                ->download('Reporte_de_registros' . Carbon::now() . '.xlsx');
        }
    }
    public function reconnection(Request $request)
    {
        $id = $request->register_id;
        $register = InternetRegister::find($id);
        $register->active = !$register->active;
        $register->save();
    }

    public function update__service(Request $request)
    {

        $id = $request->register_id;


        $register = InternetRegister::find($id);
        $register->active = !$register->active;
        $register->save();

        return ["success" => true];
    }
    public function update__date(Request $request)
    {
        $id = $request->register_id;
        $date = $request->date;

        InternetRegister::where('id', $id)->update(["pay_date" => $date]);

        return ["success" => true];
    }
    public function get_payments($id)
    {
        $register = InternetRegister::find($id);
        $operation = InternetOperation::where('register_id', $register->id)->first();
        $payments =  InternetPayment::where('operation_id', $operation->id)
            ->orderBy('created_at', 'desc');

        return new InternetPaymentCollection($payments->paginate(20));
    }
    public function print_payments($id)
    {
        $register = InternetRegister::find($id);
        $person = $register->person;
        $operation = InternetOperation::where('register_id', $register->id)->first();
        $payments =  InternetPayment::where('operation_id', $operation->id)->orderBy('created_at', 'desc')->get();

        $height = 250;

        if ($payments->count() == 1) {
            $height = $height + $payments->count() * 35;
        } else {
            $height = $height + $payments->count() * 35;
        }

        // 

        $last_payment = InternetPaymentMonth::wherehas('payment', function ($query) use ($operation) {
            $query->where('operation_id', $operation->id);
        })
            ->latest()->first();

        $company = Company::first();
        try {
            $pdf = PDF::loadView('internet::formats.payments', compact(
                'payments',
                'company',
                'person',
                'last_payment'
            ))
                ->setPaper(array(0, 0, 249.45, $height));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }
        $name = $register->person->name;
        return $pdf->stream('estado de cuenta ' . $name . '.pdf');
    }
    function create_date($month, $day)
    {
        $today = Carbon::now();
        $year = $today->year;
        $create_date = Carbon::create($year, $month, $day);
        // if ($create_date->lt($today)) {
        //     $create_date->addYear();
        // }
        return $create_date->format("Y-m-d");
    }
    public function register_payments(Request $request)
    {


        $operation_id = $request->operation_id;
        $operation = InternetOperation::find($operation_id);
        $reconnection = $request->reconnection;
        $register = InternetRegister::find($operation->register_id);
        $reconnection_date = $request->reconnection_date;
        if ($reconnection && $reconnection_date) {
            $reconnection_date = Carbon::parse($reconnection_date)->format("Y-m-d");
            $register->pay_date = $reconnection_date;
            $register->active = 1;
            $register->save();
            $suspension = InternetSuspension::where('register_id', $register->id)
                ->whereNull('reconnect_date')
                ->first();
            if ($suspension) {
                $suspension->reconnect_date = $reconnection_date;
                $suspension->save();
            }
        }
        $day = Carbon::parse($operation->register->date)->format('d');

        $months = $request->months ?? [];
        $document_type_id = $request->document_type_id;
        $document_id = $request->document_id;
        $model = Model::class;
        $model = $document_type_id != "80" ? Document::class : SaleNote::class;
        $model = $model::find($document_id);
        $type = $request->type;
        //check if months is empty
        $rest = 0;

        if (count($months) == 0) {
            $last_general_payment = InternetPayment::where('operation_id', $operation_id)->latest()->first();
            if ($last_general_payment && $last_general_payment->type == "incomplete") {
                $rest = floatval($last_general_payment->rest) - floatval($model->total);

                InternetPayment::where("operation_id", $operation_id)
                    ->update([
                        "type" => "complete",
                        "rest" => 0,
                    ]);
            }
        }
        $payment = new InternetPayment([
            "type" => $type ?? "complete",
            "document_id" => $document_type_id != "80" ? $document_id : null,
            "sale_note_id" => $document_type_id == "80" ? $document_id : null,
            "operation_id" => $operation_id,
            "rest" => $rest,
        ]);
        $payment->save();
        $total_document = floatval($model->total);
        $total = $operation->get_operation_amount();
        InternetPaymentMonth::wherehas("payment", function ($q) use ($operation_id) {
            $q->where("operation_id", $operation_id);
        })->update([
            "state" => "complete",
        ]);
        foreach ($months as $idx => $month) {

            $start_date = Carbon::parse($month);
            $end_date = $start_date->copy()->addMonth();
            $month_payment = new InternetPaymentMonth([
                "month" => $start_date->format('m'),
                "payment_id" => $payment->id,
                "year" => $this->create_date($start_date->format('m'), $day),
                "start_date" => $start_date->format("Y-m-d"),
                "end_date" => $end_date->format("Y-m-d"),
                "state" => "complete",
                "amount" => $total,
                "rest" => 0,
            ]);
            if ($idx == count($months) - 1 && $total_document != $total * count($months) && $total_document < ($total * count($months))) {
                $total_months = count($months) * $total;
                $total_remain = $total_months - $total_document;
                $month_payment->amount = $total - $month_payment->amount;
                $month_payment->rest = $total_remain;
                $month_payment->state = "incomplete";
            }
            $month_payment->save();
        }

        return ["success" => true];
    }
    public function register($id)
    {
        $register = InternetRegister::find($id);
        $phone = $register->person->telephone;
        $register['telephone'] = $phone;
        return compact('register');
    }
    public function update_register(Request $request)
    {
        $id = $request->id;
        $register = InternetRegister::find($id);
        $register->fill($request->all());
        $register->save();
        $telephone = $request->telephone;
        $person = $register->person;
        $person->telephone = $telephone;
        $person->save();

        return [
            "success" => true,
            "message" => "Registro actualizado correctamente"
        ];
    }
    public function register_data($id)
    {
        $register = InternetRegister::find($id);
        $operation = InternetOperation::where('register_id', $id)->first();
        $payment_months = InternetPaymentMonth::whereHas('payment', function ($query) use ($operation) {
            $query->where('operation_id', $operation->id);
        })->orderBy('start_date', 'desc')
            ->take(12)
            ->get();

        $payments = InternetPayment::where('operation_id', $operation->id)->get();

        $plan_operation = InternetPlanOperation::where('active', 1)->where('operation_id', $operation->id)->first();
        $plan_variation = InternetPlanVariation::find($plan_operation->plan_id);
        $plan = InternetPlan::find($plan_variation->plan_id);
        $capacity = $plan->capacity;
        $plan_description = $plan_variation->description;
        $name = $capacity . " " . $plan_description;
        $concept_operation = InternetConceptOperation::where('active', 1)->where('operation_id', $operation->id)
            ->get();
        $concept_price = 0;
        if (count($concept_operation) > 0) {
            foreach ($concept_operation as $op) {
                $cp = InternetConceptVariation::find($op->concept_id);
                $general = InternetConcept::find($cp->concept_id);
                $name .= " + " . $general->description . " " . $cp->description;
                $concept_price += $cp->price;
            }
        }

        $item = $plan->item;
        $install_date = $register->date;
        $total = $operation->get_operation_amount();
        $operation_id = $operation->id;
        $person = $register->person;
        $credit = $register->credit;
        $series = Series::where('establishment_id', auth()->user()->establishment_id)->get();
        return compact("payment_months", "name", "credit", "total", "install_date", "person", "item", "payments", "series", "operation_id");
    }
}
