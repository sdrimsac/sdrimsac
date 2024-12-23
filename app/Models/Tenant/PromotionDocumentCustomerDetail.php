<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;

class PromotionDocumentCustomerDetail extends ModelTenant
{
    protected $table = 'promotion_document_customer_detail';

    protected $fillable = [
        'document_id',
        'sale_note_id',
        'promotion_customer_id',
        'total',
    ];

    public function promotion_customer()
    {
        return $this->belongsTo(PromotionDocumentCustomer::class, 'promotion_customer_id');
    }

    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class, 'sale_note_id');
    }

    public function document()
    {
        return $this->belongsTo(PromotionDocument::class, 'document_id');
    }



    public function getPointBeforeDetail($detail_id)
    {
        $detail = PromotionDocumentCustomerDetail::find($detail_id);
        $promotion_document_customer_id = $detail->promotion_customer_id;
        $created_at = $detail->created_at;

        // Obtener el documento de promoción asociado para acceder a los valores de puntos
        $promotion_document = $detail->promotion_customer->promotion_document;
        $points_value = $promotion_document->points_value;
        $total_to_points = $promotion_document->total;

        // Obtener puntos acumulados antes de la creación del detalle
        $accumulatedPoints = PromotionDocumentCustomerDetail::where('promotion_customer_id', $promotion_document_customer_id)
            ->where('created_at', '<', $created_at)
            ->get()
            ->sum(function ($row) use ($total_to_points, $points_value) {
                return ($row->total / $total_to_points) * $points_value;
            });
        // Obtener puntos canjeados antes de la creación del detalle
        $redeemedPoints = PromotionReceived::where('promotion_document_customer_id', $promotion_document_customer_id)
            ->where('created_at', '<=', $created_at)
            ->get()
            ->sum(function ($row) use ($total_to_points, $points_value) {
                $promotion_document = $row->promotion_document_customer->promotion_document;
                $promotion_document_item = $promotion_document->items()->where('item_id', $row->item_id)->first();
                $points_value = $promotion_document_item->points_value;
                return $row->quantity * $points_value;
            });
        // Calcular los puntos antes del detalle
        $pointsBeforeDetail = $accumulatedPoints - $redeemedPoints;

        return $pointsBeforeDetail;
    }
}

