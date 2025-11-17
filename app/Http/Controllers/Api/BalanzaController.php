<?php
namespace App\Http\Controllers\Api;
use App\CoreFacturalo\Facturalo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanzaController extends Controller
{
    public function getItemList(Request $request)

    {
        // lsitar los item codigo interno description precio_venta y almacen_id
        $items = DB::connection('tenant')->table('items')
            ->select('internal_id', 'description', 'sale_unit_price', 'warehouse_id')
            ->where('is_active', true)
            ->get();
        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    
    }
}