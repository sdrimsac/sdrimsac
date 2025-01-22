<?php

namespace App\Providers;

use App\Http\Controllers\Tenant\WhatsappController;
use Illuminate\Support\ServiceProvider;
use App\Models\Tenant\Document;
use App\Models\Tenant\User;

use App\Models\Tenant\Configuration;
use Exception;

class LockedEmissionProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->locked_emission();
        $this->locked_users();
        $this->update_quantity_documents();
    }


    private function update_quantity_documents()
    {
        Document::created(function ($document) {
            
            $configuration = Configuration::first();
            $configuration->quantity_documents++; 
            $configuration->save();
        
        }); 
    }

    

    private function locked_emission()
    {

        Document::created(function ($document) {
            $configuration = Configuration::first();

            $total_igv = $document->total_igv;
            $total_taxed = $document->total_taxed;
            if($configuration->affectation_igv_type_id != '10' && ($total_igv > 0 || $total_taxed > 0)){
                (new WhatsappController)->sendMessageAll('El documento '.$document->series.' '.$document->number.' ha sido emitido con un total de IGV de '.$total_taxed.'. Por favor, verifique la información.',$document->establishment_id);
            }
            // $quantity_documents = Document::count();
            $quantity_documents = $configuration->quantity_documents;

            if($configuration->locked_emission && $configuration->limit_documents !== 0){
                if($quantity_documents >= $configuration->limit_documents)
                    throw new Exception("Ha superado el límite permitido para la emisión de comprobantes");

            }

        });
    }

    private function locked_users()
    {

        User::creating(function ($document) {
            
            
            $configuration = Configuration::first();

            $quantity_users = User::count();

            if($configuration->locked_users &&  $configuration->plan->limit_users !== 0){

                if($quantity_users >= $configuration->plan->limit_users )
                {
                    throw new Exception("Ha superado el límite permitido para la creación de usuarios");
                }
            }

        });
    }
}
