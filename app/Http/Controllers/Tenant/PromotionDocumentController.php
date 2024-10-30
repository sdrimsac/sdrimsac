<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Tenant\PromotionDocumentCollection;
use App\Http\Resources\Tenant\PromotionDocumentResource;
use Exception;
use Illuminate\Http\Request;
use App\Models\Tenant\Item;
use App\Models\Tenant\PromotionDocument;
use App\Models\Tenant\PromotionDocumentCustomer;
use App\Models\Tenant\PromotionDocumentItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PromotionDocumentController extends Controller
{
    public function index()
    {
        return view('tenant.promotion_document.index');
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
        $records = PromotionDocument::orderBy('description');

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

            $promotion_document = PromotionDocument::firstOrNew(['id' => $id]);
            $promotion_document->fill($request->all());
            $promotion_document->items()->delete();
            $items = $request->input('items');
            $promotion_document->save();
            foreach ($items as $row) {
                $promotion_document_item = new PromotionDocumentItem();
                $promotion_document_item->item_id = $row['id'];
                $promotion_document_item->promotion_document_id = $promotion_document->id;
                $promotion_document_item->quantity = $row['quantity'];
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

    public function byCustomer($id)
    {
        $records = PromotionDocumentCustomer::where('customer_id', $id)->pluck('promotion_document_id')->values()->unique('promotion_document_id');
        $promotions = [];

        foreach ($records as $row) {
            $promotion = PromotionDocument::findOrFail($row);
            $description = $promotion->description;
            $counts = PromotionDocumentCustomer::where('promotion_document_id', $row)->where('customer_id', $id)
                ->where('acc_total', $promotion->total)
                ->where('active', 1)
                ->count();
            $message =  "Tiene " . $counts . " de la promoción " . $description . " por canjear";
            if ($counts > 0)
                $promotions[] = [
                    'id' => $row,
                    'description' => $description,
                    'message' => $message
                ];
        }

        return $promotions;
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
}
