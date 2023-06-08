<?php

namespace App\Console\Commands;

use App\Models\Tenant\Document;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNotePayment;
use Illuminate\Console\Command;

class NotPaymentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notpayments:update {--website_id=}';
    /**
    * The console command description.
    *
    * @var string
    */
   protected $description = 'Actualizar estado de Pagos Pendiente';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        ini_set('memory_limit', '-1');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $document=Document::where('state_type_id','!=','11')->get();
        foreach ($document as $row) {
           $documentPayment=DocumentPayment::where('document_id',$row->id)->first();
           if($documentPayment==null){
                $documentFind=Document::findOrFail($row->id);
                $documentFind->notpayment=true;
           }else{
                $documentFind=Document::findOrFail($row->id);
                $documentFind->notpayment=false;
           }
                $documentFind->save();
        }
        $saleNote=SaleNote::where('state_type_id','!=','11')->get();
        foreach ($saleNote as $rows) {
            $documentPayment=SaleNotePayment::where('sale_note_id',$rows->id)->first();

            if($documentPayment==null){
                //dd($rows->id);
                 $salenoteFind=SaleNote::findOrFail($rows->id);
                 $salenoteFind->notpayment=true;
            }else{
                 $salenoteFind=SaleNote::findOrFail($rows->id);
                 $salenoteFind->notpayment=false;
            }
                 $salenoteFind->save();
        }
    }
}
