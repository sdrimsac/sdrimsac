<?php

namespace App\Http\Controllers\Tenant;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Tenant\PromotionDocumentCollection;
use App\Http\Resources\Tenant\PromotionDocumentResource;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Customer;
use App\Models\Tenant\Establishment;
use Exception;
use Illuminate\Http\Request;
use App\Models\Tenant\Item;
use App\Models\Tenant\Person;
use App\Models\Tenant\Promotion;
use App\Models\Tenant\PromotionDocument;
use App\Models\Tenant\PromotionDocumentCustomer;
use App\Models\Tenant\PromotionDocumentItem;
use App\Models\Tenant\PromotionReceived;
use App\Models\Tenant\User;
use App\Traits\PromotionDocumentTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Modules\Restaurant\Events\PrintEvent;
use Modules\Restaurant\Models\Area;

class PromotionDocumentController extends Controller
{

    use PromotionDocumentTrait;

    public function index()
    {
        $configuration = Configuration::select('is_promotion_document', 'promotions_by_points')->first();
        return view('tenant.promotion_document.index', compact('configuration'));
    }

    /* public function index_points()
    {
        $configuration = Configuration::select('is_promotion_document', 'promotions_by_points')->first();
        return view('tenant.promotion_document_points.index', compact('configuration'));
    } */


    public function columns()
    {
        return [
            'description' => 'Nombre'
            // 'description' => 'Descripción'
        ];
    }

    public function tables()
    {

        $items = Item::where('apply_store', 1)->get();
        return compact('items');
    }


    public function records(Request $request)
    {

        $configuration = Configuration::select('promotions_by_points')->first();
        $records = PromotionDocument::query();

        $column = $request->input('column');
        $value = $request->input('value');

        if ($column) {
            $records = $records->where($column, 'like', "%{$value}%");
        }

        if ($configuration->promotions_by_points) {
            $records = $records->where('is_points', 1);
        } else {
            $records = $records->where('is_points', 0);
        }
        return new PromotionDocumentCollection($records->paginate(config('tenant.items_per_page')));
    }

    // public function create()
    // {
    //     return view('tenant.promotion.form');
    // }


    public function record($id)
    {
        $record = new PromotionDocumentResource(PromotionDocument::findOrFail($id));
        return $record;
    }

    public function store(Request $request)
    {


        try {
            DB::connection('tenant')->beginTransaction();
            $id = $request->input('id');
            $configuration = Configuration::select('is_promotion_document', 'promotions_by_points')->first();
            $promotion_document = PromotionDocument::firstOrNew(['id' => $id]);
            $promotion_document->fill($request->all());
            $promotion_document->items()->delete();
            $items = $request->input('items');
            if ($configuration->promotions_by_points) {
                $promotion_document->is_points = 1;
            }
            $promotion_document->save();
            foreach ($items as $row) {
                $promotion_document_item = new PromotionDocumentItem();
                $promotion_document_item->item_id = $row['id'];
                $promotion_document_item->promotion_document_id = $promotion_document->id;
                $promotion_document_item->quantity = $row['quantity'];
                $promotion_document_item->points_value = $row['points_value'];
                $promotion_document_item->save();
            }

            DB::connection('tenant')->commit();

            return [
                'success' => true,
                'message' => ($id) ? 'Promocion editada con éxito' : 'Promocion registrada con éxito',
                'id' => $promotion_document->id
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::connection('tenant')->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    // public function checkLimit($promotion_document_id,$customer_id){
    //     $promotion_document = PromotionDocument::find($promotion_document_id);
    //     $limit_changes = $promotion_document->limit_changes;
    //     if(!$limit_changes) return true;
    //     $changes = PromotionReceived::where('customer_id', $customer_id)->where('promotion_document_id', $promotion_document_id)->count();
    //     return $changes < $limit_changes;
    // }

    public function pointsByCustomer($id, $promotion_document_id)
    {
        if (!$this->checkLimit($promotion_document_id, $id)) {
            return [
                'success' => false,
                'message' => 'No tienes mas cambios disponibles'
            ];
        }

        // Join promotion_documents table to get points_value
        $record = PromotionDocumentCustomer::where('promotion_document_customers.customer_id', $id)
            ->where('promotion_document_customers.promotion_document_id', $promotion_document_id)
            ->where('promotion_document_customers.active', 1)
            ->join('promotion_documents', 'promotion_documents.id', '=', 'promotion_document_customers.promotion_document_id')
            ->select('promotion_document_customers.*', 'promotion_documents.points_value', 'promotion_documents.total')
            ->first();

        if (!$record) return [
            'success' => false,
        ];

        $points = $record->points;
        $points_value = $record->points_value; // New field from promotion_documents
        $promotion_document_id = $record->promotion_document_id;
        $total = $record->total;

        $items = PromotionDocumentItem::where('promotion_document_id', $promotion_document_id)
            ->where('points_value', '<=', $points)
            ->with('item.itemwarehouses')
            ->get()->transform(function ($item) {
                $item_data = $item->item;
                $item_warehouse = $item_data->itemWarehouses ? $item_data->itemWarehouses->first() : null;
                $stock = $item_warehouse ? $item_warehouse->stock : null;

                $item_data->quantity = $item->quantity;
                $item_data->is_promotion = true;
                return [
                    'id' => $item->id,
                    'full_description' => "(" . $item->points_value . " pts) " . $item_data->description,
                    'points_value' => $item->points_value,
                    'stock' => $stock,
                    'item'   => $item_data,
                ];
            });

        return [
            'success' => true,
            'message' => $points,
            'points_value' => $points_value,
            'total' => $total,
            'items' => $items
        ];
    }
    public function byCustomer($id, $promotion_document_id)
    {
        if (!$this->checkLimit($promotion_document_id, $id)) {
            return [
                'success' => false,
                'message' => 'No tienes mas cambios disponibles'
            ];
        }
        $records = PromotionDocumentCustomer::where('customer_id', $id)
            ->where('promotion_document_id', $promotion_document_id)
            ->whereHas('promotion_document', function ($query) {
                $query->where('is_points', 0);
            })
            ->pluck('promotion_document_id')->values()->unique('promotion_document_id');
        $promotions = [];

        foreach ($records as $row) {
            $promotion = PromotionDocument::findOrFail($row);
            $limit_changes = $promotion->limit_changes;
            $description = $promotion->description;
            $counts = PromotionDocumentCustomer::where('promotion_document_id', $row)->where('customer_id', $id)
                ->where('acc_total', $promotion->total)
                ->where('active', 1)
                ->count();
            $count_desactive = PromotionDocumentCustomer::where('promotion_document_id', $row)->where('customer_id', $id)
                ->where('acc_total', $promotion->total)
                ->where('active', 0)
                ->count();

            if ($counts > $limit_changes) {
                $counts = $limit_changes;
            }
            $counts = $counts - $count_desactive;

            $message =  "Tiene " . $counts . " de la promoción " . $description . " por canjear";
            if ($counts > 0)
                $promotions[] = [
                    'id' => $row,
                    'description' => $description,
                    'message' => $message
                ];
        }

        return [
            'success' => true,
            'promotions' => $promotions
        ];
    }

    public function getItemsByPerson($id)
    {
        $promotionDocumentCustomers = PromotionDocumentCustomer::where('customer_id', $id)
            ->join('promotion_documents', 'promotion_documents.id', '=', 'promotion_document_customers.promotion_document_id')
            ->where('acc_total', '=', DB::raw('promotion_documents.total'))
            ->first();
        $items = [];

        if ($promotionDocumentCustomers) {
            $promotion_document = PromotionDocument::find($promotionDocumentCustomers->promotion_document_id);
            $items = $promotion_document->getFormattedItems();
        }


        return $items;
    }

    public function destroy($id)
    {
        //return 'sd';
        $item = PromotionDocument::findOrFail($id);
        $item->status = 0;
        $item->save();

        return [
            'success' => true,
            'message' => 'Promocion eliminada con éxito'
        ];
    }


    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $new_request = [
                'file' => $request->file('file'),
                'type' => $request->input('type'),
            ];

            return $this->upload_image($new_request);
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }

    function upload_image($request)
    {
        $file = $request['file'];
        $type = $request['type'];

        $temp = tempnam(sys_get_temp_dir(), $type);
        file_put_contents($temp, file_get_contents($file));

        $mime = mime_content_type($temp);
        $data = file_get_contents($temp);

        return [
            'success' => true,
            'data' => [
                'filename' => $file->getClientOriginalName(),
                'temp_path' => $temp,
                'temp_image' => 'data:' . $mime . ';base64,' . base64_encode($data)
            ]
        ];
    }

    public function resetPoints($id)
    {
        try {
            // $promotion = PromotionDocument::findOrFail($id);

            PromotionDocumentCustomer::where('promotion_document_id', $id)
                ->update([
                    'active' => false
                ]);
            return response()->json([
                'success' => true,
                'message' => 'Puntos reseteados correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deactivatePromotion($id)
    {
        try {
            $promotion = PromotionDocument::findOrFail($id);
            $promotion->update([
                'active' => false
            ]);
            PromotionDocumentCustomer::where('promotion_document_id', $id)
                ->update([
                    'active' => false
                ]);
            return response()->json([
                'success' => true,
                'message' => 'Promoción desactivada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function promotionPointsPdf($customer_id)
    {
        $customer = Person::find($customer_id);
        $promotion_items = $this->getAvailablePromotions($customer_id);

        if ($promotion_items->isEmpty()) {
            return null;
        }

        $base_height = 500;
        $item_height = 30;
        $total_items = count($promotion_items);
        $height = $base_height + ($total_items * $item_height);

        try {
            // Usa la vista de la ruta proporcionada
            $pdf = PDF::loadView('tenant.promotion.promotion_points_80', compact(
                'customer',
                'promotion_items'
            ))->setPaper(array(0, 0, 249.45, $height));
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el PDF',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
        $timestamp = Carbon::now()->format('YmdHis');

        return $pdf->stream($timestamp . '_promociones_.pdf');
    }

    public function PromotionPointsNew($customer_id)
    {

        $establishment = Establishment::find(auth()->user()->establishment_id);

        $area_id = $this->getBoxArea();
        $area = Area::find($area_id);
        $printer = $area->printer ?? $establishment->printer;

        event(new PrintEvent($customer_id, "PR", true, $area_id, [], true));

        return [
            'success' => true,
            'printer' => $printer,
            'direct_printing' => (bool) $establishment->direct_printing,
            'printer_serve' => $establishment->printer_serve,
            'print'   => url('') . "/caja/promotions-document/promotionPointsPdf/{$customer_id}",
        ];
    }

    function getBoxArea()
    {
        $establishment_id = auth()->user()->establishment_id;
        $user_box = User::whereHas('area', function ($query) {
            $query->where('description', 'like', '%CAJ%');
        })->where('establishment_id', $establishment_id)->first();
        if ($user_box) {
            $area_box = $user_box->area;
            return $area_box->id;
        }
        $area_box = Area::where('description', 'like', '%CAJ%')->first();

        if ($area_box != null) {
            return $area_box->id;
        }
        return null;
    }

    private function getAvailablePromotions($customer_id)
    {
        $customer = Person::find($customer_id);
        if (!$customer) {
            return collect();
        }

        $customer_name = $customer->name;
        $now = now();

        $promotions = PromotionDocument::where('active', true)
            ->where('date_start', '<=', $now)
            ->where('date_end', '>=', $now)
            ->get();

        $result = [];

        foreach ($promotions as $promo) {
            $promoCustomer = PromotionDocumentCustomer::where('customer_id', $customer_id)
                ->where('promotion_document_id', $promo->id)
                ->first();

            if (!$promoCustomer || $promoCustomer->points <= 0) {
                continue;
            }

            $items = PromotionDocumentItem::where('promotion_document_id', $promo->id)
                ->with('item')
                ->where('points_value', '<=', $promoCustomer->points)
                ->get();

            foreach ($items as $item) {
                $itemData = $item->item ?? null;

                $result[] = [
                    'customer_id' => $customer_id,
                    'customer_name' => $customer_name,
                    'customer_points' => $promoCustomer->points,
                    'promotion_id' => $promo->id,
                    'promotion_description' => $promo->description,
                    'promotion_end_date' => $promo->date_end,
                    'item_id' => $item->item_id,
                    'item_name' => $itemData->name ?? '',
                    'item_description' => $itemData->description ?? '',
                    'item_image' => $itemData->image ?? '',
                    'item_points_value' => $item->points_value,
                    'item_quantity' => $item->quantity,
                ];
            }
        }

        return collect($result);
    }

    /**
     * Helper to compute promotion records by customer id
     */
    protected function getPromotionRecordsById($customer_id)
    {
        $customer = Person::find($customer_id);
        if (!$customer) {
            return collect();
        }

        $customer_name = $customer->name;
        $now = now();

        $promotions = PromotionDocument::where('active', true)
            ->where('date_start', '<=', $now)
            ->where('date_end', '>=', $now)
            ->get();

        $result = [];

        foreach ($promotions as $promo) {
            $promoCustomer = PromotionDocumentCustomer::where('customer_id', $customer_id)
                ->where('promotion_document_id', $promo->id)
                ->first();

            if (!$promoCustomer || $promoCustomer->points <= 0) {
                continue;
            }

            $items = PromotionDocumentItem::where('promotion_document_id', $promo->id)
                ->with('item')
                ->where('points_value', '<=', $promoCustomer->points)
                ->get();

            foreach ($items as $item) {
                $itemData = $item->item ?? null;

                $result[] = [
                    'customer_id' => $customer_id,
                    'customer_name' => $customer_name,
                    'customer_points' => $promoCustomer->points,
                    'promotion_id' => $promo->id,
                    'promotion_description' => $promo->description,
                    'promotion_end_date' => $promo->date_end,
                    'item_id' => $item->item_id,
                    'item_name' => $itemData->name ?? '',
                    'item_description' => $itemData->description ?? '',
                    'item_image' => $itemData->image ?? '',
                    'item_points_value' => $item->points_value,
                    'item_quantity' => $item->quantity,
                ];
            }
        }

        return collect($result);
    }

    public function getPromotionRecords(Request $request)
    {
        $customer_id = $request->input('customer_id');
        return $this->getPromotionRecordsById($customer_id);
    }

    /* public function getPromoItemsPdf($customer_id)
    {

        $customer = Person::find($customer_id);
        if (!$customer) {
            return collect();
        }

        $points = PromotionDocumentCustomer::where('customer_id', $customer_id)
            ->where('active', 1)
            ->sum('points');

        $points_available = PromotionDocumentCustomer::where('customer_id', $customer_id)
            ->where('active', 1)
            ->sum('acc_total');

        $customer_name = $customer->name;

        $records = $this->getPromotionRecordsById($customer_id);

        try {
            // Usa la vista de la ruta proporcionada
            $pdf = PDF::loadView('tenant.promotion.report_points', compact(
                'customer',
                'records',
                'points',
                'points_available'
            ))->setPaper('a4');
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el PDF',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
        return $pdf->stream('promociones_por_puntos.pdf');
    } */

    /* public function getPromoItemsPdf($customer_id)
    {
        $customer = Person::find($customer_id);
        if (!$customer) {
            return collect();
        }

        $company_number = Str::padLeft(auth()->user()->establishment->number, 3, '0');

        $points = PromotionDocumentCustomer::where('customer_id', $customer_id)
            ->where('active', 1)
            ->sum('points');

        $points_available = PromotionDocumentCustomer::where('customer_id', $customer_id)
            ->where('active', 1)
            ->sum('acc_total');

        $customer_name = $customer->name;
        $records = $this->getPromotionRecordsById($customer_id);

        try {
            // Asegurar opciones de renderizado para evitar caracteres ilegibles
            PDF::setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

            $pdf = PDF::loadView('tenant.promotion.report_points', compact(
                'customer',
                'records',
                'points',
                'points_available'
            ))->setPaper('a4');

            // Ruta donde se guardará el PDF dentro de la carpeta 'promocion'
            $directory = 'promocion'; // storage/app/public/promocion
            $fileName = "promociones_por_puntos_{$customer_id}.pdf";
            $relativePath = $directory . '/' . $fileName;

            // Crear la carpeta 'promocion' si no existe en el disco público
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            // Eliminar el archivo anterior si existe
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }

            // Guardar el nuevo PDF en storage/app/public/promocion
            $absolutePath = storage_path('app/public/' . $relativePath);
            $pdf->save(storage_path('app/public/promociones_por_puntos_' . $customer_id . '_' . $company_number . '_' . '.pdf'));
            $pdf->save($absolutePath);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el PDF',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }

        // Opcional: retorna el PDF en el navegador
        return $pdf->stream($fileName);
    } */
    public function getPromoItemsPdf($customer_id)
    {
        $customer = Person::find($customer_id);
        if (!$customer) {
            return collect();
        }

        $company_number = Company::first()->number;

        $points = PromotionDocumentCustomer::where('customer_id', $customer_id)
            ->where('active', 1)
            ->sum('points');

        $points_available = PromotionDocumentCustomer::where('customer_id', $customer_id)
            ->where('active', 1)
            ->sum('acc_total');

        $records = $this->getPromotionRecordsById($customer_id);

        try {
            PDF::setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

            $pdf = PDF::loadView('tenant.promotion.report_points', compact(
                'customer',
                'records',
                'points',
                'points_available'
            ))->setPaper('a4');


                $fileName = "promociones_por_puntos_{$customer_id}_{$company_number}_.pdf";
                $absolutePath = storage_path('app/public/' . $fileName);

                $pdf->save($absolutePath);
            /* } */
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el PDF',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
        return $pdf->stream('pdf_file.pdf');
    }

    public function pdfStorageFile($id)
    {
        $number = Company::first()->number;
        $directory = 'promocion';
        $fileName = "promociones_por_puntos_{$id}_{$number}.pdf";
        $relativePath = $directory . '/' . $fileName;

        // Verificar si el archivo existe en el disco público
        if (!Storage::disk('public')->exists($relativePath)) {
            return response()->json([
                'success' => false,
                'message' => 'El archivo PDF no existe para este cliente.'
            ], 404);
        }

        // Retornar el archivo como descarga
        return response()->file(storage_path('app/public/' . $relativePath));
    }
}
