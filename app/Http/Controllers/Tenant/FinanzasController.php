<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use Modules\Finance\Traits\FinanceTrait;

class FinanzasController extends Controller
{

    use StorageDocument, FinanceTrait;

    protected $quotation;
    protected $company;

    public function index()
    {
        /* $company = Company::select('soap_type_id')->first();
        $soap_company  = $company->soap_type_id; */

        return view('tenant.finanzas.index' );
    }
}
