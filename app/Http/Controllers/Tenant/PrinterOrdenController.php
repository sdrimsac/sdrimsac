<?php

namespace App\Http\Controllers\Tenant;
use Exception;
use Carbon\Carbon;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use App\Models\Tenant\Company;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Establishment;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Barryvdh\DomPDF\Facade as PDF;
class PrinterOrdenController extends Controller
{
    public function printTicket(Request $request)
    {
        $company = Company::first();
        $orden = $request->id;
        $ordenes = Orden::where('id', $request->id)->first();

        $user=User::findOrFail($ordenes->user_id);


        $establishment=Establishment::where('id',$user->establishment_id)->first();
        //
        $ordens=OrdenItem::where('orden_id', $orden);
        $orden_items =$ordens->get();

        $date = Carbon::today()->format('d-m-y');
        $height=8*40;
        $height=$height+$ordens->count()*20;
        try {
            $pdf = PDF::loadView('restaurant::ordens.ticket', compact('establishment','date', 'company', 'orden', 'ordenes', 'orden_items'))
                ->setPaper(array(0, 0, 249.45, $height));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_file.pdf');
    }
}
