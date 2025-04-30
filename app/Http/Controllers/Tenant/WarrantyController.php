<?php

namespace App\Http\Controllers\Tenant;


use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\WarrantyBoxCollection;
use App\Http\Resources\Tenant\WarrantyCollection;
use App\Http\Resources\Tenant\WarrantyResource;
use App\Imports\ItemColorSizeImport;
use App\Models\Tenant\Company;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemColorSize;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\ItemWarranty;
use App\Models\Tenant\Person;
use App\Models\Tenant\Series;
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
    public function records2(Request $request)
    {
        $records = $this->getRecordsBox($request);

        return new WarrantyBoxCollection($records->paginate(10));
    }
    public function getRecords(Request $request)
    {
        $records = ItemWarranty::query();

        $customer_id = $request->customer_id;
        $item_id = $request->item_id;

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
        if ($customer_id) {
            $records->where(function ($query) use ($customer_id) {

                $query->whereHas('SaleNoteItem.sale_note', function ($subQuery) use ($customer_id) {
                    $subQuery->where('customer_id', $customer_id);
                })
                    ->orWhereHas('DocumentItem.document', function ($subQuery) use ($customer_id) {
                        $subQuery->where('customer_id', $customer_id);
                    });
            });
        }
        if ($item_id) {
            $records->where(function ($query) use ($item_id) {
                $query->whereHas('SaleNoteItem', function ($subQuery) use ($item_id) {
                    $subQuery->where('item_id', $item_id);
                })
                    ->orWhereHas('DocumentItem', function ($subQuery) use ($item_id) {
                        $subQuery->where('item_id', $item_id);
                    });
            });
        }
        return $records;
    }

    public function getRecordsBox(Request $request)
    {
        $records = ItemWarranty::query();

        $customer_id = $request->customer_id;
        $item_id = $request->item_id;

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
        if ($customer_id) {
            $records->where(function ($query) use ($customer_id) {

                $query->whereHas('SaleNoteItem.sale_note', function ($subQuery) use ($customer_id) {
                    $subQuery->where('customer_id', $customer_id);
                })
                    ->orWhereHas('DocumentItem.document', function ($subQuery) use ($customer_id) {
                        $subQuery->where('customer_id', $customer_id);
                    });
            });
        }
        if ($item_id) {
            $records->where(function ($query) use ($item_id) {
                $query->whereHas('SaleNoteItem', function ($subQuery) use ($item_id) {
                    $subQuery->where('item_id', $item_id);
                })
                    ->orWhereHas('DocumentItem', function ($subQuery) use ($item_id) {
                        $subQuery->where('item_id', $item_id);
                    });
            });
        }
        return $records;
    }

    public function record($id)
    {
        $record = new WarrantyResource(ItemWarranty::findOrFail($id));
        return $record;
    }
    /* public function columns()
    {
        return [
            'description' => 'Descripción',  
        ];
    } */
    public function tables()
    {
        $customers = $this->table('customers');
        $items = $this->table('items');
        $series = Series::whereIn('document_type_id', ['01', '03', '80'])->get()
            ->transform(function ($series) {
                return [
                    'id' => $series->id,
                    'number' => $series->number,
                    'document_type_id' => $series->document_type_id,
                    'label' => $series->number . ' ' . $series->establishment->description
                ];
            });
        return compact('items', 'customers', 'series');
    }

    private function table($type)
    {
        switch ($type) {
            case 'customers':
                return Person::whereType('customers')->get();
            case 'items':
                return Item::all();
            default:
                throw new Exception("Invalid table type: {$type}");
        }
    }
}
