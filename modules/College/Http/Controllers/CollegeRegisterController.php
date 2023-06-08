<?php

namespace Modules\College\Http\Controllers;

use App\Models\Tenant\Cash;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Catalogs\CurrencyType;
use App\Models\Tenant\Catalogs\IdentityDocumentType;
use App\Models\Tenant\Catalogs\PaymentMethodType;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Series;
use App\Models\Tenant\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\College\Http\Resources\CollegeRegisterCollection;
use Modules\College\Models\CollegeMember;
use Modules\College\Models\CollegeParent;
use Modules\College\Models\CollegePayment;
use Modules\College\Models\CollegePaymentMonth;
use Modules\College\Models\CollegePlan;
use Modules\College\Models\CollegePlanService;
use Modules\College\Models\CollegeRegister;
use Modules\College\Models\CollegeStudent;
use Modules\Item\Models\CategoryItem;

class CollegeRegisterController extends Controller
{

    public function index()
    {
        $configuration = Configuration::first();
        return view('college::registers', compact('configuration'));
    }
    public function register_sale(Request $request)
    {
        $is_sale_note = $request->is_sale_note;
        $document_id = $request->document_id;
        $detail = $request->detail;
        $student_id = $request->student_id;
        $student = CollegeStudent::find($student_id);
        $date = Carbon::now()->format("Y-m-d");
        $plan = CollegePlan::where('name', 'like', '%OTROS%')->first();

        $register = new CollegeRegister([
            "classroom_id" => $student->classroom_id,
            "member_id" => $student->member->id,
            "plan_id" => $plan->id,
            "first_pay" => $date,
            "last_pay" => $date,
            "payment_count" => 1,
            "active" => 1,
        ]);
        $register->save();
        $payment = new CollegePayment;
        if ($is_sale_note) {
            $payment->sale_note_id = $document_id;
        } else {
            $payment->document_id = $document_id;
        }

        $payment->register_id = $register->id;
        $payment->type = 'complete';
        $payment->active = 1;
        $payment->details = $detail;

        $payment->save();

        return ["succes" => true];
    }
    public function records(Request $request)
    {
        $member_id = $request->member_id;
        $registers = CollegeRegister::where('member_id', $member_id);


        return new CollegeRegisterCollection($registers->paginate(15));
    }

    public function store(Request $request)
    {
        //emitir comprobante
        //guardar matricula

        $member_id = $request->member_id;
        $plan_id = $request->plan_id;
        $first_pay = $request->first_pay;
        $classroom_id = $request->classroom_id;
        $last_pay = $request->last_pay;
        $payment_count = $request->payment_count;
        $active = $request->active;
        $register = new CollegeRegister([
            "classroom_id" => $classroom_id,
            "member_id" => $member_id,
            "plan_id" => $plan_id,
            "first_pay" => $first_pay,
            "last_pay" => $last_pay,
            "payment_count" => $payment_count,
            "active" => $active,
        ]);
        $register->save();
        if ($register->id) {
            $member = CollegeMember::find($member_id);
            $student_id = $member->children_id;
            $exists  = CollegeStudent::where('student_id', $student_id)->first();

            if (!isset($exists)) {
                $student = new CollegeStudent([
                    "student_id" => $member->children_id,
                    "classroom_id" => $classroom_id,
                    "active" => 1
                ]);
                $student->save();
            }
        }
        return ['success' => true, 'message' => 'Registro creado', 'id' => $register->id];
    }
    public function parents(Request $request)
    {
        $records = CollegeParent::query();
        if ($request->description) {
            $description = $request->description;
            $records->whereHas('person', function ($query) use ($description) {
                $query->where('name', 'like', '%' . $description . '%')
                    ->orWhere('number', 'like', '%' . $description . '%');
            });
        }
        $records = $records->get()->take(15);
        return  $records;
    }

    public function payment_tables()
    {
        $affectation_igv_types = AffectationIgvType::whereActive()->get();
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $series = Series::where('establishment_id', $establishment->id)->get();
        $method_payment = PaymentMethodType::where('active', 1)->orderBy('description', 'asc')->get();
        if (!$establishment) {
            $establishment = Establishment::first();
        }
        $currency_types = CurrencyType::whereActive()->get();
        $documents_type = IdentityDocumentType::where('active', 1)->get();
        $user = User::findOrFail(auth()->user()->id);
        $company = Company::first();
        $categories = CategoryItem::all();
        $cash = Cash::where('state', 1)->where('user_id', $user->id)->first();
        if ($cash) {
            $cash_id = $cash->id;
        } else {
            $cash_id = null;
        }

        return compact(
            'cash_id',
            'series',
            'affectation_igv_types',
            'establishment',
            'method_payment',
            'currency_types',
            'documents_type',
            'user',
            'company',
            'categories',
        );
    }
    public function tables(Request $request)
    {


        $parents = CollegeParent::all()->take(15);
        CollegePlan::where('validity_date', '<', Carbon::now())->update(["active" => 0]);
        $plans = CollegePlan::where('active', 1);
        $months = [];
        if ($request->service) {
            $plans = $plans->where('type_id', 2)->where('period_id', 2);
        }
        if ($request->register) {
            $plans = $plans->where('type_id', 1);
        }
        if ($request->member_id) {
            $id = $request->member_id;
            $months = CollegePaymentMonth::whereHas('payment', function ($query) use ($id) {
                $query->whereHas('register', function ($query) use ($id) {
                    $query->where('member_id', $id);
                });
            })->get()->transform(function ($row) {
                $plan_id = $row->payment->register->plan_id;
                return [
                    "id" => $row->id,
                    "month" => $row->month,
                    "plan_id" => $plan_id
                ];
            });
        }
        $plans = $plans->orderBy('validity_date', 'desc')->get()->transform(function ($row) {
            $services = CollegePlanService::where('plan_id', $row->id)->get();

            return [
                "id" => $row->id,
                "name" => $row->name,
                "period" => $row->period,
                "period_id" => $row->period_id,
                "description" => $row->description,
                "services" => $services,
                "penalty" => $row->penalty,
                "validity_date" => isset($row->validity_date) ? Carbon::parse($row->validity_date)->format("d/m/y") : null,
                "payment_date" => isset($row->payment_date) ? Carbon::parse($row->payment_date)->format("d/m/y") : null,
                'type_id' => $row->type_id,
                'days_extension' => $row->days_extension,
                'type' => $row->type
            ];
        });

        return compact(
            'parents',
            'plans',
            'months'


        );
    }
}

// if ($request->service) {
//     $items = $items->where('unit_type_id', 'ZZ');
// }
