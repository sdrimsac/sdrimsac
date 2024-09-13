<?php

namespace App\Traits;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\PromotionDocument;
use App\Models\Tenant\PromotionDocumentCustomer;
use App\Models\Tenant\PromotionDocumentCustomerDetail;

/**
 * 
 */
trait PromotionDocumentTrait
{

    public function savePromotion($document, $promotion_id)
    {
        if (!$promotion_id) return;
        $configuration = Configuration::first();
        if (!$configuration->is_promotion_document) return;
        $document_type_id = $document->document_type_id;
        $customer_id = $document->customer_id;
        $promotion_document = PromotionDocument::find($promotion_id);
        $limit = $promotion_document->total;
        $promotion = PromotionDocumentCustomer::where('promotion_document_id', $promotion_id)
            ->where('customer_id', $customer_id)
            ->first();
        if (!$promotion) {
            $promotion = new PromotionDocumentCustomer();
            $promotion->promotion_document_id = $promotion_id;
            $promotion->customer_id = $customer_id;
            $promotion->acc_total = $document->total;
        } else {
            $newTotal = $promotion->acc_total + $document->total;
            if ($newTotal > $limit) {
                $remainingTotal = $newTotal - $limit;
                $promotion->acc_total = $limit;
                $newPromotion = new PromotionDocumentCustomer();
                $newPromotion->promotion_document_id = $promotion_id;
                $newPromotion->customer_id = $customer_id;
                $newPromotion->acc_total = $remainingTotal;
                $newPromotion->save();
                $newPromotionItem = new PromotionDocumentCustomerDetail;
                $newPromotionItem->promotion_customer_id = $newPromotion->id;
                if ($document_type_id == '80') {
                    $newPromotionItem->sale_note_id = $document->id;
                } else {
                    $newPromotionItem->document_id = $document->document_id;
                }
                $newPromotionItem->total = $remainingTotal;
                $newPromotionItem->save();
            } else {
                $promotion->acc_total = $newTotal;
            }
        }
        $promotion->save();

        $promotion_item = new PromotionDocumentCustomerDetail;
        $promotion_item->promotion_customer_id = $promotion->id;
        if ($document_type_id == '80') {
            $promotion_item->sale_note_id = $document->id;
        } else {
            $promotion_item->document_id = $document->document_id;
        }
        $promotion_item->total = min($document->total, $limit - $promotion->acc_total);
        if ($promotion_item->total <= 0) {
            return;
        }
        $promotion_item->save();
    }
}
