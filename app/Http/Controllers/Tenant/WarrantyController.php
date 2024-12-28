<?php

namespace App\Http\Controllers\Tenant;


use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\WarrantyCollection;
use App\Http\Resources\Tenant\WarrantyResource;
use App\Imports\ItemColorSizeImport;
use App\Models\Tenant\Company;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemColorSize;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\ItemWarranty;
use App\Models\Tenant\Person;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Modules\Report\Exports\ExportWarranty;

class WarrantyController extends Controller
{
    public function index()
    {
        return view('tenant.warranty.index');
    }

    public function ExportarExcel(Request $request)
    {
        ini_set('memory_limit', '2048M');

        // Obtener los registros procesados
        $records = $this->getRecords($request)->get();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No hay datos para exportar.'], 204);
        }

        $processedRecords = $records->map(function ($row) {
            $productoSaleNote = $row->saleNoteItem->item ?? null;
            $productoDocument = $row->documentItem->item ?? null;

            $clienteSaleNote = $row->saleNoteItem->sale_note->customer ?? null;
            $clienteDocumento = $row->documentItem->document->customer ?? null;

            return [
                'warranty_start_date' => $row->warranty_start_date,
                'warranty_end_date' => $row->warranty_end_date,
                'producto_sale_note' => $productoSaleNote,
                'producto_document' => $productoDocument,
                'cliente_sale_note' => $clienteSaleNote,
                'cliente_documento' => $clienteDocumento,
                'description' => $productoDocument->description ?? $productoSaleNote->description ?? null,
                'internal_id' => $productoDocument->internal_id ?? $productoSaleNote->internal_id ?? null,
                'month_day' => $productoDocument->month_day ?? $productoSaleNote->month_day ?? null,
                'customer_name' => $clienteDocumento->name ?? $clienteSaleNote->name ?? null,
            ];
        });

        $company = Company::first();

        // Pasar los registros procesados a la clase de exportación
        return (new ExportWarranty)
            ->records($processedRecords)
            ->company($company)
            ->download('Productos_garantia' . '_' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }


    public function records(Request $request)
    {
        $records = $this->getRecords($request);

        return new WarrantyCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function getRecords(Request $request)
    {
        $records = ItemWarranty::query();
            /* ->with([
                'documentItem.document',
                'saleNoteItem.sale_note',
            ]); */

        $column = $request->input('column');
        $value = $request->input('value');
        if ($column && $value) {
            if ($column == 'description') {
                $records->whereHas('item', function ($query) use ($value) {
                    $query->where('', 'like', "%{$value}%");
                        
                });
            } else {
                $records->where($column, 'like', "%{$value}%");
            }
        }
        return $records;
    }
    public function record($id)
    {
        $record = new WarrantyResource(ItemWarranty::findOrFail($id));
        return $record;
    }
    public function columns()
    {
        return [
            'warranty_start_date' => 'garantía_inicio',
            'description' => 'Descripción',
            
        ];
    }
    public function tables ()
    {
        $items = Item::where('unit_type_id', 'ZZ')->get();
        $customers = Person::where('type', 'customer')->get();
        return compact('items', 'customers');
    }
}
