<?php

namespace Modules\College\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\College\Models\CollegePayment;
use Modules\College\Models\CollegePaymentMonth;


class CollegePaymentController extends Controller
{




    public function store(Request $request)
    {
        $document_id = $request->document_id;
        $register_id = $request->register_id;
        $details = $request->details;
        $type = $request->type ?? 'complete';
        $active = $request->active;
        $months = $request->months ?? [];
        $payment = new CollegePayment([
            "document_id" => $document_id,
            "register_id" => $register_id,
            "type" => $type,
            "active" => $active,
            "details" => $details
        ]);
        $payment->save();

        foreach ($months as $month) {
            $paymentMonth = new CollegePaymentMonth(
                [
                    "payment_id" => $payment->id,
                    "month" => $month,
                    "year" => Carbon::now(),
                ]
            );
            $paymentMonth->save();
        }
        return ['success' => true, 'message' => 'Pago registrado'];
    }

    // public function tables()
    // {

    //     $periods = CollegePeriod::all();
    //     $items = Item::where('unit_type_id', 'ZZ')->get()->take(15);

    //     return compact('periods', 'items');
    // }
}

// if ($request->service) {
//     $items = $items->where('unit_type_id', 'ZZ');
// }