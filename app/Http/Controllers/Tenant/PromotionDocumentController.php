<?php

namespace App\Http\Controllers\Tenant;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Tenant\PromotionDocumentCollection;
use App\Http\Resources\Tenant\PromotionDocumentResource;
use App\Models\Tenant\Configuration;
use Exception;
use Illuminate\Http\Request;
use App\Models\Tenant\Item;
use App\Models\Tenant\PromotionDocument;
use App\Models\Tenant\PromotionDocumentCustomer;
use App\Models\Tenant\PromotionDocumentItem;
use App\Models\Tenant\PromotionReceived;
use App\Traits\PromotionDocumentTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PromotionDocumentController extends Controller
{

    use PromotionDocumentTrait;

    public function index()
    {
        $configuration = Configuration::select('is_promotion_document', 'promotions_by_points')->first();
        return view('tenant.promotion_document.index', compact('configuration'));
    }


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
        $record = PromotionDocumentCustomer::where('customer_id', $id)
            ->where('promotion_document_id', $promotion_document_id)
            ->where('active', 1)
            ->first();

        if (!$record) return [
            'success' => false,
        ];
        $points = $record->points;
        $promotion_document_id = $record->promotion_document_id;
        $items = PromotionDocumentItem::where('promotion_document_id', $promotion_document_id)
            ->where('points_value', '<=', $points)
            ->get()->transform(function ($item) {
                $item_data = $item->item;
                $item_data->quantity = $item->quantity;
                $item_data->is_promotion = true;
                return [
                    'id' => $item->id,
                    'full_description' => "(" . $item->points_value . " pts) " . $item_data->description,
                    'points_value' => $item->points_value,
                    'item'   => $item_data

                ];
            });
        return [
            'success' => true,
            'message' => $points,
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
            if ($counts > $limit_changes) {
                $counts = $limit_changes;
            }
                
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
        ->join('promotion_documents','promotion_documents.id','=','promotion_document_customers.promotion_document_id')
        ->where('acc_total','=',DB::raw('promotion_documents.total'))
        ->first();
        $items = [];

        if($promotionDocumentCustomers){
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
}
