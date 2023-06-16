<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Quotation;
use App\Models\Tenant\Kardex;
use App\Models\Tenant\Purchase;
use App\Models\Tenant\Retention;
use App\Models\Tenant\Perception;
use App\Models\Tenant\Summary;
use App\Models\Tenant\Receipt;
use App\Models\Tenant\SaleNotePayment;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Voided;
use App\Models\Tenant\Box;
use Illuminate\Http\Request;
use App\Models\Tenant\Configuration;
use BoxesDetail;
use Illuminate\Support\Facades\DB;
use Modules\Expense\Models\Expense;
use Modules\Purchase\Models\PurchaseOrder;
use Modules\Finance\Models\GlobalPayment;
use Modules\Finance\Models\Income;
use Modules\Purchase\Models\PurchaseQuotation;
use Modules\Order\Models\OrderNote;
use Modules\Inventory\Models\{
    ItemWarehouse,
    InventoryKardex
};
use Modules\Sale\Models\Contract;
use Modules\Purchase\Models\FixedAssetPurchase;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;

class OptionController extends Controller
{

    protected $delete_quantity;

    public function create()
    {
        return view('tenant.options.form');
    }
    public function deleteItems(Request $request)
    {

        $this->delete_quantity = 0;
        Document::where('id', '<>', null)->update(['orden_id' => null]);
        SaleNote::where('id', '<>', null)->update(['orden_id' => null]);

        DB::connection('tenant')->table('invoices')->delete();
        DB::connection('tenant')->table('kardex')->delete();
        DB::connection('tenant')->table('item_lots')->delete();
        DB::connection('tenant')->table('item_warehouse')->delete();
        DB::connection('tenant')->table('item_unit_types')->delete();
        DB::connection('tenant')->table('item_lots_group')->delete();
        DB::connection('tenant')->table('boxes_detail')->delete();
        DB::connection('tenant')->table('boxes')->delete();
        DB::connection('tenant')->table('orden_item')->delete();

        DB::connection('tenant')->table('cash')->delete();
        DB::connection('tenant')->table('ordens')->delete();
        DB::connection('tenant')->table('sale_note_items')->delete();
        DB::connection('tenant')->table('inventory_kardex')->delete();
        DB::connection('tenant')->table('sale_note_payments')->delete();
        DB::connection('tenant')->table('document_items')->delete();
        DB::connection('tenant')->table('document_payments')->delete();
        DB::connection('tenant')->table('documents')->delete();
        DB::connection('tenant')->table('sale_notes')->delete();

        DB::connection('tenant')->table('purchase_items')->delete();
        DB::connection('tenant')->table('purchase_payments')->delete();
        DB::connection('tenant')->table('purchases')->delete();

        DB::connection('tenant')->table('quotation_items')->delete();
        DB::connection('tenant')->table('quotations')->delete();
        DB::connection('tenant')->table('transfers_place_detail')->delete();
        DB::connection('tenant')->table('transfers_place')->delete();

        DB::connection('tenant')->table('foods')->delete();
        DB::connection('tenant')->table('items')->delete();
        DB::connection('tenant')->table('brands')->delete();
        DB::connection('tenant')->table('categories')->delete();
        DB::connection('tenant')->table('tables')->delete();
        DB::connection('tenant')->table('global_payments')->delete();
        DB::connection('tenant')->table('social_media_clients')->delete();
        DB::connection('tenant')->table('vip_clients')->delete();
        DB::connection('tenant')->table('vips')->delete();
        Summary::where('soap_type_id', '01')->delete();
        Voided::where('soap_type_id', '01')->delete();
        // DB::connection('tenant')->table('persons')->delete();
        $this->deleteInventoryKardex(Purchase::class);
        Purchase::where('soap_type_id', '01')->delete();
        $this->deleteInventoryKardex(Document::class);
        Document::where('soap_type_id', '01')
            ->whereIn('document_type_id', ['07', '08'])->delete();
        Document::where('soap_type_id', '01')->delete();
        $sale_notes = SaleNote::where('soap_type_id', '01')->get();
        foreach ($sale_notes as $key => $row) {
            Receipt::where('sale_note_id', $row->id)->delete();
        }
        SaleNote::where('soap_type_id', '01')->delete();
        GlobalPayment::where('soap_type_id', '01')->delete();




        return [
            'success' => true,
            'message' => 'Productos  eliminados',
            'delete_quantity' => $this->delete_quantity,
        ];
    }
    public function deleteDocuments(Request $request)
    {
        
        $this->delete_quantity = 0;
        Document::where('id', '<>', null)->update(['orden_id' => null]);
        SaleNote::where('id', '<>', null)->update(['orden_id' => null]);

        DB::connection('tenant')->table('invoices')->delete();
        DB::connection('tenant')->table('tables')->update(['status_table_id' => 1]);
        DB::connection('tenant')->table('kardex')->delete();
        DB::connection('tenant')->table('receipts')->delete();
        DB::connection('tenant')->table('summary_documents')->delete();

        DB::connection('tenant')->table('internet_item')->delete();
        DB::connection('tenant')->table('internet_payment_month')->delete();
        DB::connection('tenant')->table('internet_payments')->delete();
        DB::connection('tenant')->table('internet_plan_operation')->delete();
        DB::connection('tenant')->table('internet_concept_operation')->delete();
        DB::connection('tenant')->table('internet_operations')->delete();
        DB::connection('tenant')->table('internet_register')->delete();
        // DB::connection('tenant')->table('item_lots')->delete();
        // DB::connection('tenant')->table('item_warehouse')->delete();
        // DB::connection('tenant')->table('item_unit_types')->delete();
        DB::connection('tenant')->table('boxes_detail')->delete();
        DB::connection('tenant')->table('boxes')->delete();
        DB::connection('tenant')->table('orden_item')->delete();

        DB::connection('tenant')->table('cash')->delete();
        DB::connection('tenant')->table('ordens')->delete();
        DB::connection('tenant')->table('sale_note_items')->delete();
        DB::connection('tenant')->table('inventory_kardex')->delete();
        DB::connection('tenant')->table('sale_note_payments')->delete();
        DB::connection('tenant')->table('document_items')->delete();
        DB::connection('tenant')->table('document_payments')->delete();
        DB::connection('tenant')->table('voided_documents')->delete();
        DB::connection('tenant')->table('notes')->delete();
        DB::connection('tenant')->table('sale_notes')->delete();
        DB::connection('tenant')->table('documents')->delete();

        DB::connection('tenant')->table('purchase_items')->delete();
        DB::connection('tenant')->table('purchase_payments')->delete();
        DB::connection('tenant')->table('purchases')->delete();

        // DB::connection('tenant')->table('foods')->delete();
        // DB::connection('tenant')->table('items')->delete();
        // DB::connection('tenant')->table('brands')->delete();
        // DB::connection('tenant')->table('categories')->delete();
        // DB::connection('tenant')->table('tables')->delete();
        DB::connection('tenant')->table('global_payments')->delete();
        DB::connection('tenant')->table('social_media_clients')->delete();
        DB::connection('tenant')->table('vip_clients')->delete();
        DB::connection('tenant')->table('vips')->delete();
        Summary::where('soap_type_id', '01')->delete();
        Voided::where('soap_type_id', '01')->delete();
        // DB::connection('tenant')->table('persons')->delete();
        $this->deleteInventoryKardex(Purchase::class);
        Purchase::where('soap_type_id', '01')->delete();
        $this->deleteInventoryKardex(Document::class);
        Document::where('soap_type_id', '01')
            ->whereIn('document_type_id', ['07', '08'])->delete();
        Document::where('soap_type_id', '01')->delete();
        $sale_notes = SaleNote::where('soap_type_id', '01')->get();
        foreach ($sale_notes as $key => $row) {
            Receipt::where('sale_note_id', $row->id)->delete();
        }
        SaleNote::where('soap_type_id', '01')->delete();
        GlobalPayment::where('soap_type_id', '01')->delete();
        Box::where('soap_type_id', '01')->delete();



        return [
            'success' => true,
            'message' => 'Documentos de prueba eliminados',
            'delete_quantity' => $this->delete_quantity,
        ];
    }

    private function deleteInventoryKardex($model, $records = null)
    {

        if (!$records) {
            $records = $model::where('soap_type_id', '01')->get();
        }

        $this->delete_quantity += $records->count();

        foreach ($records as $record) {

            $record->inventory_kardex()->delete();
        }
    }

    private function updateStockAfterDelete()
    {

        if ($this->delete_quantity > 0) {

            ItemWarehouse::latest()->update([
                'stock' => 0
            ]);
        }
    }

    private function update_quantity_documents($quantity)
    {
        $configuration = Configuration::first();
        $configuration->quantity_documents -= $quantity;
        $configuration->save();
    }
}
