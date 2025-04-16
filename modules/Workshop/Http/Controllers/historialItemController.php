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
    public function record($historialId)
    {
        $items = HistorialItem::where('historial_id', $historialId)->with('item')->get();

        return response()->json($items);
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
}
