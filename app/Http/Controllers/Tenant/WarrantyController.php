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

    /* public function getRecords(Request $request)
    {
        $records = ItemWarranty::query()
            ->with([
                'documentItem' => function ($query) {
                    $query->select('id', 'document_id', 'item')
                        ->with(['document:id,customer']);
                },
                'saleNoteItem' => function ($query) {
                    $query->select('id', 'sale_note_id', 'item')
                        ->with(['sale_note:id,customer']);
                },
            ]);

        $column = $request->input('column');
        $value = $request->input('value');

        if ($column && $value) {
            if ($column == 'name') {
                $records->where(function ($query) use ($value) {
                    // Filtro sobre la tabla 'item_warranty'
                    $query->where(function ($query) use ($value) {
                        // Si el item tiene un 'document_item_id', buscar en 'documents' a través de 'document_items'
                        $query->whereHas('documentItem.document', function ($query) use ($value) {
                            $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(customer, "$[*].name")) LIKE ?', ["%{$value}%"]);
                        });
                    })
                    ->orWhere(function ($query) use ($value) {
                        // Si el item tiene un 'sale_note_item_id', buscar en 'sale_notes' a través de 'sale_note_items'
                        $query->whereHas('saleNoteItem.sale_note', function ($query) use ($value) {
                            $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(customer, "$[*].name")) LIKE ?', ["%{$value}%"]);
                        });
                    });
                });
            } elseif ($column == 'description') {
                $records->where(function ($query) use ($value) {
                    $query->whereHas('documentItem', function ($query) use ($value) {
                        $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(item, "$.description")) LIKE ?', ["%{$value}%"]);
                    })
                        ->orWhereHas('saleNoteItem', function ($query) use ($value) {
                            $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(item, "$.description")) LIKE ?', ["%{$value}%"]);
                        });
                });
            } elseif ($column == 'series') {
                $records->where(function ($query) use ($value) {
                    $query->whereHas('documentItem', function ($query) use ($value) {
                        $query->where('series', 'like', "%{$value}%");
                    })
                        ->orWhereHas('saleNoteItem', function ($query) use ($value) {
                            $query->where('series', 'like', "%{$value}%");
                        });
                });
            } elseif ($column == 'customer') {
                $records->where(function ($query) use ($value) {
                    $query->whereHas('documentItem.document', function ($query) use ($value) {
                        $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(customer, "$[*].name")) LIKE ?', ["%{$value}%"]);
                    })
                    ->orWhereHas('saleNoteItem.sale_note', function ($query) use ($value) {
                        $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(customer, "$[*].name")) LIKE ?', ["%{$value}%"]);
                    });
                });
            }  else {
                $records->where($column, 'like', "%{$value}%");
            }
        }

        return $records;
    } */
    /* public function searchRecords(Request $request)
    {
        $column = $request->input('column');
        $value = $request->input('value');

        $records = ItemWarranty::query()
            ->with([
                'documentItem.document',
                'saleNoteItem.sale_note',
            ])
            ->get();

        $filteredRecords = $records->filter(function ($record) use ($column, $value) {
            $documentItem = $record->documentItem;
            $saleNoteItem = $record->saleNoteItem;

            $documentMatch = false;
            $saleNoteMatch = false;

            if ($documentItem) {
                $document = $documentItem->document;
                if ($document && $column == 'name') {
                    $documentMatch = stripos($document->customer['name'], $value) !== false;
                } elseif ($documentItem->item && $column == 'description') {
                    $documentMatch = stripos($documentItem->item['description'], $value) !== false;
                } elseif ($column == 'series') {
                    $documentMatch = stripos($documentItem->series, $value) !== false;
                }
            }

            if ($saleNoteItem) {
                $saleNote = $saleNoteItem->sale_note;
                if ($saleNote && $column == 'name') {
                    $saleNoteMatch = stripos($saleNote->customer['name'], $value) !== false;
                } elseif ($saleNoteItem->item && $column == 'description') {
                    $saleNoteMatch = stripos($saleNoteItem->item['description'], $value) !== false;
                } elseif ($column == 'series') {
                    $saleNoteMatch = stripos($saleNoteItem->series, $value) !== false;
                }
            }

            return $documentMatch || $saleNoteMatch;
        });

        return new WarrantyCollection($filteredRecords);
    } */



    /* public function getRecords(Request $request)
    {
        // Inicia la consulta principal
        $records = ItemWarranty::query()
            ->with([
                'documentItem' => function ($query) {
                    $query->select('id', 'document_id', 'item')
                        ->with(['document:id,customer']);
                },
                'saleNoteItem' => function ($query) {
                    $query->select('id', 'sale_note_id', 'item')
                        ->with(['sale_note:id,customer']);
                },
            ]);

        $column = $request->input('column');
        $value = $request->input('value');

        if ($column && $value) {
            if ($column == 'name') {
                $records->where(function ($query) use ($value) {
                    $query->whereHas('documentItem.document', function ($query) use ($value) {
                        $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(document_customer, "$.name")) LIKE ?', ["%{$value}%"]);
                    })
                        ->orWhereHas('saleNoteItem.sale_note', function ($query) use ($value) {
                            $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(sale_note_customer, "$.name")) LIKE ?', ["%{$value}%"]);
                        });
                });
            }
            // Filtrar por la descripción del ítem en 'item' dentro del JSON
            elseif ($column == 'description') {
                $records->where(function ($query) use ($value) {
                    $query->whereHas('documentItem', function ($query) use ($value) {
                        $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(item, "$.description")) LIKE ?', ["%{$value}%"]);
                    })
                        ->orWhereHas('saleNoteItem', function ($query) use ($value) {
                            $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(item, "$.description")) LIKE ?', ["%{$value}%"]);
                        });
                });
            }
            // Filtrar por la serie en la columna 'series'
            elseif ($column == 'series') {
                $records->where(function ($query) use ($value) {
                    $query->whereHas('documentItem', function ($query) use ($value) {
                        $query->where('series', 'like', "%{$value}%");
                    })
                        ->orWhereHas('saleNoteItem', function ($query) use ($value) {
                            $query->where('series', 'like', "%{$value}%");
                        });
                });
            }
            // Filtro genérico por cualquier columna
            else {
                $records->where($column, 'like', "%{$value}%");
            }
        }

        return $records;
    } */


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
            'series' => 'Serie Producto',
            'name' => 'Cliente',
            'customer' => 'Cliente nuevo',
        ];
    }
}
