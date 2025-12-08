<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Exports\AccountsReceivable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Dashboard\Helpers\DashboardData;
use Modules\Dashboard\Helpers\DashboardUtility;
use Modules\Dashboard\Helpers\DashboardSalePurchase;
use Modules\Dashboard\Helpers\DashboardView;
use Modules\Dashboard\Helpers\DashboardStock;
use Modules\Dashboard\Helpers\DashboardCash;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\Document;
use App\Models\Tenant\Company;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Arr;
use Modules\Dashboard\Helpers\DashboardComparative;

class dashboardCashOpenController extends Controller
{
    /* public function globalData(Request $request)
    {
        return response()->json((new DashboardData())->globalData($request->all()), 200);
    } */

    public function index()
    {

        // if(auth()->user()->type != 'admin')
        //  return redirect()->route('tenant.documents.index');
        $company = Company::first();
        $soap_company  = $company->soap_type_id;

        return view('dashboard::index', compact('soap_company'));
    }

    /* public function filter()
    {
        return [
            'establishments' => DashboardView::getEstablishments()
        ];
    } */

    /* public function data(Request $request)
    {
        return [
            'data' => (new DashboardData())->data($request->all()),
        ];
    } */

    // public function unpaid(Request $request)
    // {
    //     return [
    //             'records' => (new DashboardView())->getUnpaid($request->all())
    //     ];
    // }

    // public function unpaidall()
    // {

    //     return Excel::download(new AccountsReceivable, 'Allclients.xlsx');

    // }

   /*  public function data_aditional(Request $request)
    {
        // RarEntry::setUsingExceptions(true);
        return [
            'data' => (new DashboardSalePurchase())->data($request->all()),
        ];
    } */

    /* public function stockByProduct(Request $request)
    {
        return (new DashboardStock())->data($request);
    } */

    /* public function Comparative(Request $request)
    {
        return (new DashboardComparative())->data($request);
    } */
   /*  public function cashDashboard(Request $request)
    {
        return response()->json((new DashboardCash())->data($request), 200);
    } */

    /**
     * Obtiene datos en tiempo real del dashboard de caja (restobar)
     */
    public function cashDashboard(Request $request)
    {
        return response()->json((new DashboardCash())->data($request), 200);
    }

    /**
     * Debug: Ver qué cajas existen (temporal)
     */
    public function debugCashes(Request $request)
    {
        return response()->json((new DashboardCash())->debugCashes(), 200);
    }

    public function utilities(Request $request)
    {
        return [
            'data' => (new DashboardUtility())->data($request->all()),
        ];
    }

    public function df()
    {
        $path = app_path();
        //df -m -h --output=used,avail,pcent /

        $used = new Process('df -m -h --output=used /');
        $used->run();
        if (!$used->isSuccessful()) {
            return ['error'];
            throw new ProcessFailedException($used);
        }
        $disc_used = $used->getOutput();
        $array[] = str_replace("\n", "", $disc_used);

        $avail = new Process('df -m -h --output=avail /');
        $avail->run();
        if (!$avail->isSuccessful()) {
            return ['error'];
            throw new ProcessFailedException($avail);
        }
        $disc_avail = $avail->getOutput();
        $array[] = str_replace("\n", "", $disc_avail);

        $pcent = new Process('df -m -h --output=pcent /');
        $pcent->run();
        if (!$pcent->isSuccessful()) {
            return ['error'];
            throw new ProcessFailedException($pcent);
        }
        $disc_pcent = $pcent->getOutput();
        $array[] = str_replace("\n", "", $disc_pcent);

        return $array;
    }
}
