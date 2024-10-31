<?php

namespace Modules\Workshop\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Client\Request;
use Modules\Workshop\Http\Requests\HistorialItemRequest;
use Modules\Workshop\Http\Resources\HistorialItemCollection;
use Modules\Workshop\Http\Resources\HistorialItemResource;
use Modules\Workshop\Models\Historial;
use Modules\Workshop\Models\HistorialItem;

class HistorialItemController extends Controller
{
    public function index()
    {
        return view('workshop::historialItem.index');
    }
    public function records()
    {
        $records = HistorialItem::all();

        return new HistorialItemCollection($records);
    }

    /* public function record($historialId)
    {
        $record = HistorialItem::where('historial_id', $historialId)->get();
        $record->load('items');


        return $record;
    } */
    public function record($historialId)
    {
        // Obtiene todos los items relacionados con el historial_id proporcionado
        $items = HistorialItem::where('historial_id', $historialId)->with('item')->get();

        return response()->json($items); // Devuelve los datos en formato JSON
    }
    public function updateItem(Request $request, $historialItemId)
    {
        $historialItem = HistorialItem::findOrFail($historialItemId);
        $historialItem->update($request->all());

        return response()->json(['message' => 'Producto actualizado correctamente', 'data' => $historialItem]);
    }
    public function deleteItem($historialItemId)
    {
        $historialItem = HistorialItem::findOrFail($historialItemId);
        $historialItem->delete();

        return response()->json(['message' => 'Producto eliminado correctamente']);
    }



    public function store(HistorialItemRequest $request)
    {
        $id = $request->input('id');
        $bank = HistorialItem::firstOrNew(['id' => $id]);
        $bank->fill($request->all());
        $bank->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Mecanico editado con éxito' : 'Mecanico registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        try {

            $bank = HistorialItem::findOrFail($id);
            $bank->delete();

            return [
                'success' => true,
                'message' => 'Mecanico eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El Mecanico esta siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar Mecanico'];
        }
    }
}
