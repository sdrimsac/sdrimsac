<?php

namespace Modules\Item\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemUnitType;
use Carbon\Carbon;
use Exception;
use Illuminate\Routing\Controller;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Modules\Item\Imports\ItemListPriceImport;
use Maatwebsite\Excel\Excel;
use Modules\Item\Imports\ItemPointsValueImport;
use Modules\Report\Exports\ItemExportGeneralForImportInternalCode;

class ItemController extends Controller
{

    public function importPointsValueFile(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new ItemPointsValueImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
    }
    public function importPointsValue()
    {
        $records = Item::select('id', 'internal_id', 'description', 'points_value')->get();

        return (new ItemExportGeneralForImportInternalCode)
            ->records($records)
            ->download('Productos_actualizacion_valor_puntos_' . '_' . Carbon::now() . '.xlsx');
    }
    public function generateBarcode($id)
    {

        $item = Item::findOrFail($id);

        $colour = [150, 150, 150];

        $generator = new BarcodeGeneratorPNG();

        $temp = tempnam(sys_get_temp_dir(), 'item_barcode');

        file_put_contents($temp, $generator->getBarcode($item->internal_id, $generator::TYPE_CODE_128, 5, 70, $colour));

        $headers = [
            'Content-Type' => 'application/png',
        ];

        return response()->download($temp, "{$item->internal_id}.png", $headers);
    }


    public function importItemPriceLists(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new ItemListPriceImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
}
