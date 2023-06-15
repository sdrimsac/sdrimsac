<?php

namespace App\Console\Commands;

use App\Models\Tenant\Item;
use App\Models\Tenant\User;
use App\Models\System\Client;
use App\Models\Tenant\SaleNote;
use Illuminate\Console\Command;
use App\Models\Tenant\Inventory;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\PurchaseItem;
use Illuminate\Support\Facades\Log;
use App\Models\Tenant\ItemWarehouse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Exception\RuntimeException;


class UpdateStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:update {--website_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar el stok de Prodoctos';
     /**
     * @var Connection
     */
    private $connection;

    /**
     * @var WebsiteRepository
     */
    private $websites;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        //$this->websites = app(WebsiteRepository::class);
        //$this->connection = app(Connection::class);
    }
    public function handle()
    {
        // $records = Client::latest()->get();
        // foreach ($records as &$row) {
        // $tenancy = app(Environment::class);
        // $tenancy->tenant($row->hostname->website);
             $saldo_stock=0.00;
             $records=Item::all();
             foreach ($records as  $row_item) {
                 //Saldo Inicial
                 $saldo_inicial=floatval(Inventory::where('item_id',$row_item->id)->sum('quantity'));

                 //Compras
                 $compras=floatval(PurchaseItem::where('item_id',$row_item->id)->sum('quantity'));
                 //Nota de Venta
                  $array_sales_id=[];
                $sale_note = DB::connection('tenant')->table('sale_note_items')
                ->join('sale_notes', 'sale_notes.id', '=', 'sale_note_items.sale_note_id')
                ->select('sale_note_items.quantity','sale_note_items.sale_note_id')
                ->where('item_id',$row_item->id)
                ->whereRaw("JSON_EXTRACT(sale_note_items.item, '$.is_stock') = 'Si'")
                ->where('sale_notes.state_type_id',"!=","11")
                ->get();
                 $sale_note=$sale_note->sum('quantity');

                 $document = DB::connection('tenant')->table('document_items')
                 //->select(DB::raw("sum(document_items.quantity) as quantity"))
                 ->select('document_items.quantity','document_items.document_id')
                 ->join('documents', 'documents.id', '=', 'document_items.document_id')
                 ->where('documents.state_type_id',"!=","11")
                 ->whereRaw("JSON_EXTRACT(document_items.item, '$.is_stock') = 'Si'")
                 ->where('item_id',$row_item->id)
                 ->get();
                 $document=$document->sum('quantity');



                  if($document!=null){
                      if($document!=null){
                       $document=$document;
                      }else{
                        $document=0;
                      }
                  } else{
                      $document=0;
                  }
                  if($sale_note!=null){
                    if($sale_note!=null){
                    $sale_note=$sale_note;
                   }else{
                     $sale_note=0;
                   }
                    } else{
                        $sale_note=0;
                    }
                  $saldo_stock=($saldo_inicial+$compras)-($sale_note+$document);
                    DB::connection('tenant')->table('items')->where('id',$row_item->id)->update(['stock' => $saldo_stock]);
                    DB::connection('tenant')->table('item_warehouse')->where('item_id',$row_item->id)->update(['stock' => $saldo_stock]);

             }
             Log::debug('Se actualizo el Stock');
         //   }
    }
}
