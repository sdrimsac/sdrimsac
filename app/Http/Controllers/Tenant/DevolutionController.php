<?php

namespace App\Http\Controllers\Tenant;

use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\ProductosExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ProductosCollection;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Inventory;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Warehouse;
use Modules\Restaurant\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Models\Category;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PgSql\Lob;

class DevolutionController extends Controller
{
    public function searchDevolutions(Request $request)
    {
        $series = $request->input('series');
        $number = $request->input('number');

        if (!$series || !$number) {
            return response()->json([
                'success' => false,
                'message' => 'Serie y número del documento son requeridos'
            ], 400);
        }

        try {
            // Buscar primero en Documents
            $document = Document::where('series', $series)
                ->where('number', $number)
                ->with(['person', 'document_type', 'currency_type'])
                ->first();

            if ($document) {
                $documentItems = DocumentItem::where('document_id', $document->id)
                    ->with(['m_item:id,description,internal_id,unit_type_id'])
                    ->get()
                    ->map(function ($documentItem) {
                        return [
                            'id' => $documentItem->m_item->id ?? null,
                            'description' => $documentItem->m_item->description ?? 'N/A',
                            'internal_id' => $documentItem->m_item->internal_id ?? 'N/A',
                            'quantity' => $documentItem->quantity,
                            'unit_price' => $documentItem->unit_price,
                            'total' => $documentItem->total,
                            'unit_value' => $documentItem->unit_value ?? 0,
                            'affectation_igv_type_id' => $documentItem->affectation_igv_type_id,
                            'system_isc_type_id' => $documentItem->system_isc_type_id,
                            'price_type_id' => $documentItem->price_type_id,
                            'item' => $documentItem->item,
                        ];
                    });

                return response()->json([
                    'success' => true,
                    'document_type' => 'document',
                    'document' => [
                        'id' => $document->id,
                        'series' => $document->series,
                        'number' => $document->number,
                        'date_of_issue' => $document->date_of_issue,
                        'customer_name' => $document->person->name ?? $document->customer->name ?? $document->customer_name ?? 'N/A',
                        'customer_number' => $document->person->number ?? $document->customer->number ?? $document->customer_number ?? 'N/A',
                        'total' => $document->total,
                        'document_type' => $document->document_type->description ?? 'N/A'
                    ],
                    'items' => $documentItems
                ]);
            }

            // Si no se encuentra en Documents, buscar en SaleNotes
            $saleNote = SaleNote::where('series', $series)
                ->where('number', $number)
                ->with(['person', 'document_type', 'currency_type'])
                ->first();

            if ($saleNote) {
                $saleNoteItems = SaleNoteItem::where('sale_note_id', $saleNote->id)
                    ->with(['item:id,description,internal_id,unit_type_id'])
                    ->get()
                    ->map(function ($saleNoteItem) {
                        return [
                            'id' => $saleNoteItem->item->id ?? null,
                            'description' => $saleNoteItem->item->description ?? 'N/A',
                            'internal_id' => $saleNoteItem->item->internal_id ?? 'N/A',
                            'quantity' => $saleNoteItem->quantity,
                            'unit_price' => $saleNoteItem->unit_price,
                            'total' => $saleNoteItem->total,
                            'unit_value' => $saleNoteItem->unit_value ?? 0,
                            'affectation_igv_type_id' => $saleNoteItem->affectation_igv_type_id,
                            'system_isc_type_id' => $saleNoteItem->system_isc_type_id,
                            'price_type_id' => $saleNoteItem->price_type_id,
                            'item' => $saleNoteItem->item,
                        ];
                    });

                return response()->json([
                    'success' => true,
                    'document_type' => 'sale_note',
                    'document' => [
                        'id' => $saleNote->id,
                        'series' => $saleNote->series,
                        'number' => $saleNote->number,
                        'date_of_issue' => $saleNote->date_of_issue,
                        'customer_name' => $saleNote->person->name ?? $saleNote->customer->name ?? 'N/A',
                        'customer_number' => $saleNote->person->number ?? $saleNote->customer->number ?? 'N/A',
                        'total' => $saleNote->total,
                        'document_type' => $saleNote->document_type->description ?? 'Nota de Venta'
                    ],
                    'items' => $saleNoteItems
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No se encontró el documento con la serie y número especificados en Documents ni en Notas de Venta'
            ], 404);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar el documento: ' . $e->getMessage()
            ], 500);
        }
    }
}
