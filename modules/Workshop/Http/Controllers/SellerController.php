<?php

namespace Modules\Workshop\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Seller;

class PlanesController extends Controller
{
    public function index()
    {
        return view('workshop::mecanico.index');
    }
    /* public function records()
    {
        $records = Seller::all();

        return new SellerCollection($records);
    } */

    /* public function record($id)
    {
        $record = new BankResource(Bank::findOrFail($id));

        return $record;
    } */

    /* public function store(BankRequest $request)
    {
        $id = $request->input('id');
        $bank = Bank::firstOrNew(['id' => $id]);
        $bank->fill($request->all());
        $bank->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Banco editado con éxito' : 'Banco registrado con éxito'
        ];
    } */

    /* public function destroy($id)
    {
        try {

            $bank = Bank::findOrFail($id);
            $bank->delete();

            return [
                'success' => true,
                'message' => 'Banco eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El banco esta siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar el banco'];
        }
    } */

}
