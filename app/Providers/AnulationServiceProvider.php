<?php

namespace App\Providers;

use App\Models\Tenant\Item;
use App\Models\Tenant\Document;
use App\Models\Tenant\Purchase;

use App\Models\Tenant\Kardex;
use Illuminate\Support\ServiceProvider;
use App\Traits\KardexTrait;

class AnulationServiceProvider extends ServiceProvider
{
    use KardexTrait;

    public function register()
    {
    }

    public function boot()
    {
        $this->anulation();
        //$this->anulation_purchase();

    }


    private function anulation(){

        Document::updated(function ($document) {

            if($document['document_type_id'] == '01' || $document['document_type_id'] == '03'){

                if($document['state_type_id'] == 11){
                    
                    $has_sale_note = $document->sale_note_id != null;
                    
                    // If document was NOT created from a sale note, process normally
                    if (!$has_sale_note) {
                        foreach ($document['items'] as $detail) {
                            // Update stock in Item model
                            $item = Item::find($detail['item_id']);
                            $item->stock = $item->stock + $detail['quantity'];
                            $item->save();
                            
                            // Also update in Kardex 
                            $this->updateStock($detail['item_id'], $detail['quantity'], false);
                            $this->saveKardex('sale', $detail['item_id'], $document['id'], -$detail['quantity'],'document');
                        }
                    }
                    // If has_sale_note is true, we don't process anything as the stock
                    // will be managed when the sale note is processed
                }
            }

        });

    }
    private function anulation_purchase(){

        Purchase::updated(function ($document) {

                if($document['state_type_id'] == 11){

                    foreach ($document['items'] as $detail) {

                        $this->updateStock($detail['item_id'], $detail['quantity'], true); //pongo true porque la compra se anula, entonces el stock disminuye

                       // $this->saveKardex('sale', $detail['item_id'], $document['id'], -$detail['quantity'],'document');

                    }

                }



        });

    }
}
