<?php

namespace App\Http\Controllers\Api;

use App\CoreFacturalo\Facturalo;
use App\Events\BalanzaItemReceived;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BalanzaController extends Controller
{
    public function getItemList(Request $request)

    {
        // lsitar los item codigo interno description precio_venta y almacen_id
        $items = DB::connection('tenant')->table('items')
            ->select('internal_id', 'description', 'sale_unit_price', 'warehouse_id')
            ->where('active', true)
            ->get();
        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }
    /* public function itemFoods(Request $request)
    {
        $itemFoods = $request->input('item_foods', []);
        $items = DB::connection('tenant')->table('items')
            ->select('internal_id', 'description', 'sale_unit_price', 'warehouse_id')
            ->whereIn('internal_id', $itemFoods)
            ->where('active', true)
            ->get();
        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    } */

    /* public function itemFoods(Request $request)
    {
        $request->validate([
            'item_foods' => 'required|array',
            'item_foods.*.internal_id' => 'required|string',
            'item_foods.*.peso' => 'required|numeric',
        ]);

        $itemFoods = $request->input('item_foods');

        // Obtener los códigos
        $internalIds = collect($itemFoods)->pluck('internal_id')->toArray();

        // Buscar productos
        $items = DB::connection('tenant')->table('items')
            ->select('internal_id', 'description', 'sale_unit_price', 'warehouse_id')
            ->whereIn('internal_id', $internalIds)
            ->where('active', true)
            ->get()
            ->map(function ($item) use ($itemFoods) {

                // Obtener peso enviado desde la balanza
                $peso = collect($itemFoods)
                    ->firstWhere('internal_id', $item->internal_id)['peso'];

                $item->peso = $peso;
                $item->total = round($peso * $item->sale_unit_price, 2);

                return $item;
            });

        // 🔥 Emitir evento al frontend
        event(new \App\Events\BalanzaItemReceived($items));

        return response()->json([
            'success' => true,
            'message' => 'Datos recibidos con éxito',
            'data' => $items
        ]);
    } */

    public function itemFoods(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
            'peso' => 'required|numeric',
        ]);

        $codigo = $request->codigo;
        $peso = $request->peso;

        $item = DB::connection('tenant')->table('items')
            ->select('internal_id', 'description', 'sale_unit_price', 'warehouse_id')
            ->where('internal_id', $codigo)
            ->where('active', true)
            ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $item->peso = $peso;
        $item->total = round($peso * $item->sale_unit_price, 2);

        // Enviar evento
        Log::info('Enviando evento BalanzaItemReceived', ['item' => $item]);
        event(new BalanzaItemReceived([$item]));
        Log::info('Evento enviado correctamente');

        return response()->json([
            'success' => true,
            'message' => 'Datos recibidos con éxito',
            'data' => $item
        ]);
    }
}
