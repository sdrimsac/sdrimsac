<?php

namespace Modules\Report\Http\Resources;

use App\Models\Tenant\Payment;
use App\Models\Tenant\PromotionReceived;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use App\Models\Tenant\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReportPromotionDocumentCollection extends ResourceCollection
{


    public function toArray($request)
    {

        return $this->collection->transform(function ($row, $key) {
            // Obtener productos recibidos para este cliente y promoción
            $receiveds = PromotionReceived::where('promotion_document_customer_id', $row->id)
                ->with('item')
                ->get()
                ->transform(function ($received) {
                    if ($received->relationLoaded('item') && $received->item) {
                        return [
                            'product' => $received->item->description,
                            'image' => $received->item->image ,
                            'image_url' => ($received->item->image !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $received->item->image) : asset("/logo/{$received->item->image}"),
                            'quantity' => $received->quantity,
                        ];
                    } else {
                        return [
                            'product' => null,
                            'image' => null,
                            'quantity' => $received->quantity,
                        ];
                    }
                });
            return [
                'id' => $row->id,
                'customer_id' => $row->customer_id,
                'customer_name' => $row->customer->name,
                'promotion_id' => $row->promotion_id,
                'promotion_name' => $row->promotion_document->description,
                'image' => $row->promotion_document->image,
                'image_url' => ($row->promotion_document->image !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'promotions' . DIRECTORY_SEPARATOR . $row->promotion_document->image) : asset("/logo/{$row->promotion_document->image}"),
                'points' => $row->points,
                'acc_total' => $row->acc_total,
                'limit_changes' => $row->promotion_document->limit_changes,
                'received_products' => $receiveds,
                'active' => $row->active,
            ];
        });
    }
}
