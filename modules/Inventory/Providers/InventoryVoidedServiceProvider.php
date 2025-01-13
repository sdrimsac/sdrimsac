<?php

namespace Modules\Inventory\Providers;

use Modules\Order\Models\OrderNote;
use App\Models\Tenant\Document;
use App\Models\Tenant\ItemUnitType;
use Illuminate\Support\ServiceProvider;
use Modules\Inventory\Traits\InventoryTrait;
use Modules\Item\Models\ItemLot;

class InventoryVoidedServiceProvider extends ServiceProvider
{
    use InventoryTrait;

    public function register()
    {
    }

    public function boot()
    {
        $this->voided();
       // $this->voided_order_note();
    }

    private function voided()
    {
        //Revisar los tipos de documentos, ello varia el control de stock en las anulaciones.
        Document::updated(function ($document) {
            if($document['document_type_id'] == '01' || $document['document_type_id'] == '03'){
                if(in_array($document['state_type_id'], [ '09', '11' ], true)){
                    $warehouse = $this->findWarehouse($document['establishment_id']);

                    foreach ($document['items'] as $detail) {
                        $lots = isset($detail['item']->lots) ? $detail['item']->lots : [];

                        foreach ($lots as $lot) {
                            ItemLot::find($lot->id)->update(["has_sale" => 0]);
                        }
                        $quantity = $detail['quantity'];
                        if (isset($detail['item']->has_unit_type)) {
                            $unit_type = ItemUnitType::where('item_id', $detail['item_id'])
                                ->where('description', $detail['item']->has_unit_type)->first();
                            if ($unit_type) {

                                $quantity = $quantity * $unit_type->quantity_unit;
                            }
                        }
                        $warehouse_id = isset($detail['warehouse_id']) ? $detail['warehouse_id'] : null;
                        // dd($detail['item']->presentation);
                        $presentationQuantity = (!empty($detail['item']->presentation)) ? $detail['item']->presentation->quantity_unit : 1;

                        $this->createInventoryKardex($document, $detail['item_id'], $detail['quantity'] * $presentationQuantity,  $warehouse_id ?? $warehouse->id);
                        $this->updateStock($detail['item_id'], $detail['quantity'] * $presentationQuantity, $warehouse_id ?? $warehouse->id);
                        $this->updateDataLots($detail);
                    }

                    $this->voidedWasDeductedPrepayment($document);

                }
            }
        });
    }


    private function voidedWasDeductedPrepayment($document)
    {

        if($document->prepayments){

            foreach ($document->prepayments as $row) {
                $fullnumber = explode('-', $row->number);
                $series = $fullnumber[0];
                $number = $fullnumber[1];

                $doc = Document::where([['series',$series],['number',$number]])->first();
                if($doc){
                    $doc->was_deducted_prepayment = false;
                    $doc->save();
                }
            }
        }

    }

    private function voided_order_note(){

        OrderNote::updated(function ($order_note) {

            if(in_array($order_note->state_type_id, [ '09', '11' ], true)){

                $warehouse = $this->findWarehouse($order_note->establishment_id);

                foreach ($order_note->items as $order_note_item) {

                    $presentationQuantity = (!empty($order_note_item->item->presentation)) ? $order_note_item->item->presentation->quantity_unit : 1;

                    $this->createInventoryKardex($order_note, $order_note_item->item_id, $order_note_item->quantity * $presentationQuantity, $warehouse->id);
                    $this->updateStock($order_note_item->item_id, $order_note_item->quantity * $presentationQuantity, $warehouse->id);

                }

            }

        });

    }

}
