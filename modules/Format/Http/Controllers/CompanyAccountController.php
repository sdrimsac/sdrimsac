<?php
namespace Modules\Format\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Format\Models\CompanyAccount;
use Modules\Format\Http\Requests\CompanyAccountRequest;
use Modules\Format\Http\Resources\CompanyAccountResource;

class CompanyAccountController extends Controller
{
    public function create() {
        return view('account::company_accounts.form');
    }

    public function record() {
        $company_account = CompanyAccount::first();
        $record = new CompanyAccountResource($company_account);

        return $record;
    }

    public function store(CompanyAccountRequest $request) {
        $id = $request->input('id');
        $company_account = CompanyAccount::find($id);
        $company_account->fill($request->all());
        $company_account->save();

        return [
            'success' => true,
            'message' => 'Cuentas actualizadas'
        ];
    }
}
