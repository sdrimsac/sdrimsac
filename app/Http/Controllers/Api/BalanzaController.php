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

    public function entranceFoods(Request $request)
    {
        $sampleItem = (object)[
            'internal_id' => 'TEST123',
            'description' => 'Producto de prueba',
            'sale_unit_price' => 10.00,
            'warehouse_id' => 1,
            'peso' => 2.5,
            'total' => 25.00
        ];

        Log::info('Enviando evento de prueba BalanzaItemReceived', ['item' => $sampleItem]);
        event(new BalanzaItemReceived([$sampleItem]));
        Log::info('Evento de prueba enviado correctamente');

        return response()->json([
            'success' => true,
            'message' => 'Evento de prueba enviado con éxito',
            'data' => $sampleItem
        ]);
    }

    public function exitFoods(Request $request)
    {
        $sampleItem = (object)[
            'internal_id' => 'TEST123',
            'description' => 'Producto de prueba',
            'sale_unit_price' => 10.00,
            'warehouse_id' => 1,
            'peso' => 2.5,
            'total' => 25.00
        ];

        Log::info('Enviando evento de prueba BalanzaItemReceived', ['item' => $sampleItem]);
        event(new BalanzaItemReceived([$sampleItem]));
        Log::info('Evento de prueba enviado correctamente');

        return response()->json([
            'success' => true,
            'message' => 'Evento de prueba enviado con éxito',
            'data' => $sampleItem
        ]);
    }
}
