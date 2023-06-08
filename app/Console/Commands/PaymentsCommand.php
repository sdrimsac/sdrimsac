<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
//
use App\Models\System\{
    Client
};

use App\Models\Tenant\{
    Configuration,
    Summary,
    Company,
    User,
    PaymentMethodType,
    Document,
    SaleNote,
    Box,
    DocumentPayment,
    SaleNotePayment,
    Receipt
};
use Auth;
class PaymentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:update {--website_id=}';
     /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar los pagos realizados de Nota de Venta y Documentos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('The command was started');
        $records = Client::latest()->get();
    foreach ($records as &$row) {
        $tenancy = app(Environment::class);
        $tenancy->tenant($row->hostname->website);

        Box::query()->where('type',1) ->whereNotNull('document_id')->delete();
        Box::query()->where('type',1) ->whereNotNull('sale_note_id')->delete();
        $saleNotePayment=SaleNotePayment::query()->get();
        foreach ($saleNotePayment as $key => $row_sales) {
                $payment= PaymentMethodType::where('id',$row_sales->payment_method_type_id)->first();
                $method=$payment->description;
                $saleNote_list=SaleNote::where("id",$row_sales->sale_note_id)->first();
                if($saleNote_list!=null){
                $company=Company::first();
                $type_document="NOTA DE VENTA N° ". $saleNote_list->series." ".$saleNote_list->number ;
                if($saleNote_list->state_type_id!=11){
                Box::create([
                        'sale_note_id' => $row_sales->sale_note_id,
                        'group_id'=>1,
                        'category_id'=>1,
                        'subcategory_id'=>1,
                        'amount'=> $row_sales->payment,
                        'date'=>$row_sales->date_of_payment,
                        'sale_note_payment_id'=>$row_sales->id,
                        'type'=>'1',
                        'method'=>$method,
                        'user_id'=>'1',
                        'state'=>'1',
                        'description'=>"PAGO DE ". $type_document,
                        'soap_type_id'=>$company->soap_type_id
                        ]);
                }
            }
        }
            $documentPayment=  DocumentPayment::query()->get();
            foreach ($documentPayment as $key => $rows) {
                $document_payment_id=$rows->id;
                $box=Box::where('document_payment_id', $rows->id)->first();
                if($box==null){
                    $payment= PaymentMethodType::where('id',$rows->payment_method_type_id)->first();
                    $document_save=Document::where('id',$rows->document_id)->first();
                    if($document_save!=null && $document_save->afectar_caja){
                        if($document_save->document_type_id=="01"){
                            $type_document="FACTURA N° ";
                        }else{
                            if($document_save->document_type_id=="03"){
                            $type_document="BOLETA DE VENTA N° ";
                        }
                    }
                        $company=Company::first();
                        $documentss= Document::where('id',$rows->document_id)->first();
                        if($documentss->total_canceled==1){
                            $method="Efectivo";
                        }else{
                            $method=$payment->description;
                        }
                        $company=Company::first();
                    if($documentss->state_type_id!=11){
                        Box::create([
                            'document_id' => $rows->document_id,
                            'group_id'=>1,
                            'category_id'=>1,
                            'subcategory_id'=>1,
                            'amount'=> $rows->payment,
                            'date'=>$rows->date_of_payment,
                            'document_payment_id'=>$document_payment_id,
                            'type'=>'1',
                            'state'=>'1',
                            'method'=>$method,
                            'user_id'=>'1',
                            'state'=>'01',
                            'description'=>"PAGO DE ". $type_document. $document_save->series." ".$document_save->number,
                            'soap_type_id'=>$company->soap_type_id
                            ]);
                    }
                    }
                 }
             }
             $this->info('The command is finished');
            }
    //------------------------------------------------------------------------------------------------------------

        //$records = Client::latest()->get();
        // foreach ($records as &$row) {
        //     $tenancy = app(Environment::class);
        //     $tenancy->tenant($row->hostname->website);
        //      Box::where('type',1) ->whereNotNull('document_id')->delete();
        //             Box::where('type',1) ->whereNotNull('sale_note_id')->delete();
        //             //->whereYear('date_of_issue', $date->format('Y'))
        //             $saleNotePayment=SaleNotePayment::whereBetween('date_of_payment', [$d_start, $d_end])->get();
        //             foreach ($saleNotePayment as $key => $row_sales) {
        //                     $box=Box::where('sale_note_payment_id', $row_sales->id)->first();
        //                     $saleNote= SaleNote::where('id',$row_sales->sale_note_id)->first();
        //                     if($saleNote->paid==="1"){
        //                         $method="Efectivo";
        //                     }else{
        //                         $payment= PaymentMethodType::where('id',$row_sales->payment_method_type_id)->first();
        //                         $method=$payment->description;
        //                     }

        //             if($box==null){
        //                     $saleNote_list=SaleNote::where("id",$row_sales->sale_note_id)->first();
        //                     if($saleNote_list!=null){

        //                         $company=Company::first();
        //                         $type_document="NOTA DE VENTA N° ". $saleNote_list->series." ".$saleNote_list->number ;
        //                     if($saleNote_list->state_type_id!=11){
        //                     Box::create([
        //                             'sale_note_id' => $row_sales->sale_note_id,
        //                             'group_id'=>1,
        //                             'category_id'=>1,
        //                             'subcategory_id'=>1,
        //                             'amount'=> $row_sales->payment,
        //                             'date'=>$row_sales->date_of_payment,
        //                             'sale_note_payment_id'=>$row_sales->id,
        //                             'type'=>'1',
        //                             'method'=>$method,
        //                             'user_id'=>'1',
        //                             'state'=>'1',
        //                             'description'=>"PAGO DE ". $type_document,
        //                             'soap_type_id'=>$company->soap_type_id
        //                             ]);
        //                     }

        //                 }
        //             }
        //              $documentPayment=  DocumentPayment::whereBetween('date_of_payment', [$d_start, $d_end])->get();
        //             $document_active=Document::where("state_type_id","=","11")->get();
        //             foreach ($document_active as $key => $valuess) {
        //                 DocumentPayment::where('document_id', $valuess->id)->delete();
        //                 Box::where('document_id', $valuess->id)->delete();
        //             }
        //             foreach ($documentPayment as $key => $rows) {
        //                     $document_payment_id=$rows->id;
        //                     $box=Box::where('document_payment_id', $rows->id)->first();
        //                     if($box==null){
        //                         $payment= PaymentMethodType::where('id',$rows->payment_method_type_id)->first();
        //                         $document_save=Document::where('id',$rows->document_id)->first();
        //                         if($document_save!=null){
        //                             if($document_save->document_type_id=="01"){
        //                                 $type_document="FACTURA N° ";
        //                             }else{
        //                                 if($document_save->document_type_id=="03"){
        //                                 $type_document="BOLETA DE VENTA N° ";
        //                             }
        //                         }
        //                             $company=Company::first();
        //                             $documentss= Document::where('id',$rows->document_id)->first();
        //                             if($documentss->total_canceled==1){
        //                                 $method="Efectivo";
        //                             }else{
        //                                 $method=$payment->description;
        //                             }
        //                             $company=Company::first();
        //                         if($documentss->state_type_id!=11){
        //                             Box::create([
        //                                 'document_id' => $rows->document_id,
        //                                 'group_id'=>1,
        //                                 'category_id'=>1,
        //                                 'subcategory_id'=>1,
        //                                 'amount'=> $rows->payment,
        //                                 'date'=>$rows->date_of_payment,
        //                                 'document_payment_id'=>$document_payment_id,
        //                                 'type'=>'1',
        //                                 'state'=>'1',
        //                                 'method'=>$method,
        //                                 'user_id'=>'1',
        //                                 'state'=>'01',
        //                                 'description'=>"PAGO DE ". $type_document. $document_save->series." ".$document_save->number,
        //                                 'soap_type_id'=>$company->soap_type_id
        //                                 ]);
        //                         }
        //                         }
        //                     }
        //                  }

        //             }
        //  }
}
}
