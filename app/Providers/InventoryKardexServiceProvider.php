<?php

namespace App\Providers;

use App\Models\Tenant\Document;
use App\Models\Tenant\Purchase;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Warehouse;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\PurchaseItem;
use App\Models\Tenant\SaleNoteItem;
use App\Traits\InventoryKardexTrait;
use Illuminate\Support\ServiceProvider;

class InventoryKardexServiceProvider extends ServiceProvider
{

    use InventoryKardexTrait;


    public function register()
    {
        //
    }


    public function boot()
    {
        // $this->sale();
        // $this->purchase();
        // $this->sale_note();

    }

    private function sale()
    {
        DocumentItem::created(function ($document_item) {
            $document = Document::whereIn('document_type_id', ['01', '03'])->find($document_item->document_id);

            if ($document) {

                $inventory_kardex = $this->saveInventoryKardex($document, $document_item->item_id, $document->establishment_id, $document_item->quantity, $document->date_of_issue);

                if ($document->state_type_id != 11) {

                    $this->updateStock($document_item->item_id, $document->establishment_id, $inventory_kardex->quantity, true);
                }
            }
        });
    }

    private function purchase()
    {
        PurchaseItem::created(function ($purchase_item) {
            $purchase = Purchase::findOrFail($purchase_item->purchase_id);
            $inventory_kardex = $this->saveInventoryKardex($purchase_item->purchase, $purchase_item->item_id, $purchase_item->purchase->establishment_id, $purchase_item->quantity, $purchase->date_of_issue);
            if ($this->getItemWarehouse($purchase_item->item_id, $purchase_item->purchase->establishment_id)) {
                $this->updateStock($purchase_item->item_id, $purchase_item->purchase->establishment_id, $inventory_kardex->quantity, false);
            } else {
                $this->saveItemWarehouse($purchase_item->item_id, $purchase_item->purchase->establishment_id, $inventory_kardex->quantity);
            }
        });
    }

    private function sale_note()
    {
        SaleNoteItem::created(function ($sale_note_item) {

            $saleNote = SaleNote::findOrFail($sale_note_item->sale_note_id);
            $inventory_kardex = $this->saveInventoryKardex($sale_note_item->sale_note, $sale_note_item->item_id, $sale_note_item->sale_note->establishment_id, $sale_note_item->quantity, $saleNote->date_of_issue);
            $this->updateStock($sale_note_item->item_id, $sale_note_item->sale_note->establishment_id, $inventory_kardex->quantity, true);
        });
    }
}
