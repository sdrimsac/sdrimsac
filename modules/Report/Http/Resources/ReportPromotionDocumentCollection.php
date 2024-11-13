<?php

namespace Modules\Report\Http\Resources;

use App\Models\Tenant\Payment;
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
            return [
                'id' => $row->id,
                'customer_id' => $row->customer_id,
                'customer_name' => $row->customer->name,
                'promotion_id' => $row->promotion_id,
                'promotion_name' => $row->promotion_document->description,
                'points' => $row->points,
                'acc_total' => $row->acc_total,
            ];
        });
    }
}
