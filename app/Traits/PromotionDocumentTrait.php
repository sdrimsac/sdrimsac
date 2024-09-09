<?php

namespace App\Traits;

use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\PromotionDocumentCustomer;

/**
 * 
 */
trait PromotionDocumentTrait
{

    public function savePromotion($document, $promotion_id)
    {
        if (!$promotion_id) return;
        $document_type_id = $document->document_type_id;
        $customer_id = $document->customer_id;
        $promotion = PromotionDocumentCustomer::where('promotion_document_id', $promotion_id)
            ->where('customer_id', $customer_id)
            ->first();
        if (!$promotion) {
            $promotion = new PromotionDocumentCustomer();
            $promotion->promotion_document_id = $promotion_id;
            $promotion->customer_id = $customer_id;
            $promotion->acc_total = $document->total;
        }else{
            $promotion->acc_total += $document->total;
        }
        $promotion->save();


        
    }
}
