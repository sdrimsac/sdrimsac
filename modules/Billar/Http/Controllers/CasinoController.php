<?php

namespace Modules\Billar\Http\Controllers;


use Modules\Billar\Http\Requests\CasinoRequest;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Billar\Http\Resources\CasinoCollection;
use Modules\Billar\Http\Resources\CasinoResource;
use Modules\Billar\Models\Casino;

class CasinoController extends Controller
{
    public function index()
    {
        return view('billar::Casino.index');
    }
    public function records()
    {
        $records = Casino::all();

        return new CasinoCollection($records);
    }

    public function record($id)
    {
        $record = new CasinoResource(Casino::findOrFail($id));

        return $record;
    }

    public function store(CasinoRequest $request)
    {
        $id = $request->input('id');
        $billar = Casino::firstOrNew(['id' => $id]);
        $billar->fill($request->all());
        $billar->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Casino editado con éxito' : 'Casino registrado con éxito',
        ];
    }

    public function destroy($id)
    {
        try {
            $service = Casino::findOrFail($id);
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
