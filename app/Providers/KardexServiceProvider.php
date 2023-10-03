<?php

namespace App\Providers;

use App\Models\Tenant\Item;
use App\Models\Tenant\Kardex;
use App\Models\Tenant\ItemSet;
use App\Models\Tenant\Document;
use App\Traits\KardexTrait;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\PurchaseItem;
use App\Models\Tenant\SaleNoteItem;
use Illuminate\Support\ServiceProvider;

class KardexServiceProvider extends ServiceProvider
{
    use KardexTrait;

    public function boot()
    {

        $this->save_item();
        $this->sale();
        $this->purchase();
        $this->sale_note();
    }

    public function register()
    {
    }

    private function sale()
    {
        //   if($document_item->item->is_stock=='Si'){
        DocumentItem::created(function ($document_item) {
            $document = Document::whereIn('document_type_id', ['01', '03'])->find($document_item->document_id);
            if(isset($document->has_related_sale_note) && $document->has_related_sale_note == 1) return;
   
            $quantity = $document_item->quantity;

            if (isset($document_item->item->has_unit_type)) {
                $unit_type = ItemUnitType::where('item_id', $document_item->item_id)
                    ->where('description', $document_item->item->has_unit_type)->first();
                if ($unit_type) {

                    $quantity = $quantity * $unit_type->quantity_unit;
                }
            }
            $document = Document::whereIn('document_type_id', ['01', '03'])->find($document_item->document_id);
            if ($document) {
                if ($document_item->item->is_stock == 'Si') {
                    $kardex = $this->saveKardex('sale', $document_item->item_id, $document_item->document_id, $quantity, 'document');

                    if ($document->state_type_id != 11) {
                        if(!$document_item->document->from_consignment)
                        $this->updateStock($document_item->item_id, $quantity, "Si");
                    }
                    $itemSet = ItemSet::where("item_id", $document_item->item_id)->get();
                    foreach ($itemSet as  $value) {
                        $this->updateStock($value->individual_item_id, $value->quantity, "Si");
                    }
                }
            }
        });
        //}
    }

    private function purchase()
    {

        PurchaseItem::created(function ($purchase_item) {
            $kardex = $this->saveKardex('purchase', $purchase_item->item_id, $purchase_item->purchase_id, $purchase_item->quantity, 'purchase');

            $this->updateStock($purchase_item->item_id, $kardex->quantity, "Si");
        });
    }

    private function sale_note()
    {
        SaleNoteItem::created(function ($sale_note_item) {
            $quantity = $sale_note_item->quantity;
            if (isset($sale_note_item->item->from_unit_type_id)) {
                $unit_type = ItemUnitType::where('id', $sale_note_item->item->from_unit_type_id)
                    ->first();
                if ($unit_type) {

                    $quantity = $quantity * $unit_type->quantity_unit;
                }
            }
            $kardex = $this->saveKardex('sale', $sale_note_item->item_id, $sale_note_item->sale_note_id, $quantity, 'sale_note');
           
           if(!$sale_note_item->sale_note->from_consignment)
            $this->updateStock($sale_note_item->item_id, $quantity, "Si");
        });
    }

    private function save_item()
    {

        Item::created(function ($item) {
            $stock = ($item->stock) ? $item->stock : 0;
            $kardex = $this->saveKardex(null, $item->id, null, $stock, null);
        });
    }
}
