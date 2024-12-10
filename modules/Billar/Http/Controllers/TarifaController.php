<?php

namespace Modules\Billar\Http\Controllers;


use Modules\Billar\Http\Requests\TarifaCasinoRequest;
use App\Http\Controllers\Controller;
use Exception;
use Modules\Billar\Http\Resources\TarifaCasinoCollection;
use Modules\Billar\Http\Resources\TarifaCasinoResource;
use Modules\Billar\Models\TarifaCasino;

class TarifaController extends Controller
{
    public function index()
    {
        return view('billar::Tarifa.index');
    }
    public function records()
    {
        $records = TarifaCasino::all();

        return new TarifaCasinoCollection($records);
    }

    public function record($id)
    {
        $record = new TarifaCasinoResource(TarifaCasino::findOrFail($id));

        return $record;
    }

    public function store(TarifaCasinoRequest $request)
    {
        $id = $request->input('id');
        $billar = TarifaCasino::firstOrNew(['id' => $id]);
        $billar->fill($request->all());
        $billar->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Tarifa editado con éxito' : 'Tarifa registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        try {
            $service = TarifaCasino::findOrFail($id);
            $service->delete();

            return [
                'success' => true,
                'message' => 'Tarifa eliminado con éxito'
            ];
        } catch (Exception $e) {
            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'La Tarifa está siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar tarifa'];
        }
    }
}
