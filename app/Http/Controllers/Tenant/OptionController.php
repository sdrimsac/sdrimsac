<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Quotation;
use Modules\Finance\Models\GlobalPayment;
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
use App\Models\Tenant\SaleNotePromotion;
use Illuminate\Support\Facades\DB;
use Modules\Expense\Models\Expense;
use Modules\Purchase\Models\PurchaseOrder;
use Modules\Finance\Models\Income;
use Modules\Purchase\Models\PurchaseQuotation;
use Modules\Order\Models\OrderNote;
use Modules\Inventory\Models\{
    ItemWarehouse,
    TransferPlace,
    TransferPlaceDetail,
};
use Modules\Sale\Models\Contract;
use Modules\Purchase\Models\FixedAssetPurchase;
use Modules\Item\Models\ItemLotsGroup;
use App\Models\Tenant\CreditList;
use App\Models\Tenant\CashTransfer;
use App\Models\Tenant\Invoice;
use App\Models\Tenant\HotelRentDocument;
use App\Models\Tenant\HotelRentItemService;
use App\Models\Tenant\Table;
use App\Models\Tenant\SaleNoteCredit;
use Modules\Internet\Models\InternetItem;
use Modules\Internet\Models\InternetPaymentMonth;
use Modules\Internet\Models\InternetPayment;
use Modules\Internet\Models\InternetPlanOperation;
use Modules\Internet\Models\InternetConceptOperation;
use Modules\Internet\Models\InternetOperation;
use Modules\Internet\Models\InternetRegister;
use Modules\Internet\Models\InternetPlanVariation;
use Modules\Restaurant\Models\BoxesDetail;
use Modules\Restaurant\Models\Food;
use  Modules\Restaurant\Models\OrdenItem;
use  Modules\Restaurant\Models\Orden;
use App\Models\Tenant\SaleNoteItem;
use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\VoidedDocument;
use App\Models\Tenant\Note;
use App\Models\Tenant\PurchaseItem;
use App\Models\Tenant\PurchasePayment;
use App\Models\Tenant\CashIncomePrincipal;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Category;
use App\Models\Tenant\DispatchItem;
use App\Models\Tenant\ItemSet;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\ItemWarehousePrice;
use App\Models\Tenant\PromotionDocumentCustomerDetail;
use App\Models\Tenant\QuotationItem;
use App\Models\Tenant\SummaryDocument;
use App\Models\Tenant\Toll;
use Illuminate\Support\Facades\Log;
use Modules\Item\Models\Brand;
use Modules\Item\Models\CategoryItem;
use Modules\Item\Models\ItemLot;
use Modules\Restaurant\Models\HotelRentItemServices;
use Modules\Restaurant\Models\ItemRoomService;
use Modules\Restaurant\Models\Table as ModelsTable;
use Modules\Vip\Models\Vip;
use Modules\Workshop\Models\Historial;
use Modules\Workshop\Models\HistorialItem;

class OptionController extends Controller
{

    protected $delete_quantity;

    public function create()
    {
        return view('tenant.options.form');
    }
    function delete_items()
    {
        Document::where('id', '<>', null)->update(['orden_id' => null]);
        SaleNote::where('id', '<>', null)->update(['orden_id' => null]);
        DB::connection('tenant')->table('hotel_rent_documents')->delete();
        DB::connection('tenant')->table('toll')->delete();
        DB::connection('tenant')->table('configurations')->update(['item_variation_id' => null]);
        //item_room_services
        DB::connection('tenant')->table('item_room_services')->delete();
        DB::connection('tenant')->table('hotel_rent_item_services')->delete();
        DB::connection('tenant')->table('sale_notes_promotions')->delete();
        DB::connection('tenant')->table('invoices')->delete();
        DB::connection('tenant')->table('kardex')->delete();
        DB::connection('tenant')->table('item_lots')->delete();
        DB::connection('tenant')->table('item_warehouse')->delete();
        DB::connection('tenant')->table('item_unit_types')->delete();
        DB::connection('tenant')->table('item_lots_group')->delete();
        DB::connection('tenant')->table('boxes_detail')->delete();
        DB::connection('tenant')->table('boxes')->delete();
        DB::connection('tenant')->table('orden_item')->delete();
        DB::connection('tenant')->table('item_sets')->delete();
        //internet
        DB::connection('tenant')->table('internet_plan_variation')->delete();
        DB::connection('tenant')->table('internet_operations')->delete();
        DB::connection('tenant')->table('internet_plan')->delete();
        DB::connection('tenant')->table('ordens')->delete();
        DB::connection('tenant')->table('item_warranty')->delete();
        DB::connection('tenant')->table('sale_note_items')->delete();
        DB::connection('tenant')->table('inventory_kardex')->delete();
        DB::connection('tenant')->table('inventories')->delete();
        DB::connection('tenant')->table('sale_note_payments')->delete();
        DB::connection('tenant')->table('document_items')->delete();
        DB::connection('tenant')->table('dispatch_items')->delete();
        DB::connection('tenant')->table('document_payments')->delete();
        DB::connection('tenant')->table('documents')->delete();
        DB::connection('tenant')->table('dispatches')->delete();
        DB::connection('tenant')->table('sale_notes')->delete();
        DB::connection('tenant')->table('purchase_items')->delete();
        DB::connection('tenant')->table('purchase_payments')->delete();
        DB::connection('tenant')->table('purchases')->delete();
        DB::connection('tenant')->table('quotation_items')->delete();
        DB::connection('tenant')->table('quotations')->delete();

        // Delete transfers first to avoid foreign key constraints
        DB::connection('tenant')->table('transfers_place_detail')->delete();
        DB::connection('tenant')->table('transfers_place')->delete();

        DB::connection('tenant')->table('cash')->delete();
        DB::connection('tenant')->table('foods')->delete();
        DB::connection('tenant')->table('items')->delete();
        DB::connection('tenant')->table('item_price_ranges')->delete();
        DB::connection('tenant')->table('item_unit_type_price_ranges')->delete();
        DB::connection('tenant')->table('promotion_document_customer_detail')->delete();
        DB::connection('tenant')->table('item_colors_sizes')->delete();
        DB::connection('tenant')->table('historial_item')->delete();
        DB::connection('tenant')->table('historial')->delete();
        DB::connection('tenant')->table('brands')->delete();
        DB::connection('tenant')->table('categories')->delete();
        // DB::connection('tenant')->table('tables')->delete();
        DB::connection('tenant')->table('global_payments')->delete();
        DB::connection('tenant')->table('social_media_clients')->delete();
        DB::connection('tenant')->table('vip_clients')->delete();
        DB::connection('tenant')->table('item_categoria_madera')->delete();
        DB::connection('tenant')->table('vips')->delete();
        // DB::connection('tenant')->table('persons')->delete();
        // Delete receipts from sale notes
        $sale_notes = SaleNote::where('soap_type_id', ['01', '02', '03'])->get();
        foreach ($sale_notes as $row) {
            Receipt::where('sale_note_id', $row->id)->delete();
        }
        // Ensure complete deletion of items, categories and brands
        DB::connection('tenant')->table('item_lots')->delete();
        DB::connection('tenant')->table('item_lots_group')->delete();
        DB::connection('tenant')->table('item_unit_types')->delete();
        DB::connection('tenant')->table('item_sets')->delete();
        DB::connection('tenant')->table('item_warehouse')->delete();
        DB::connection('tenant')->table('item_price_ranges')->delete();
        DB::connection('tenant')->table('item_unit_type_price_ranges')->delete();
        DB::connection('tenant')->table('item_warranty')->delete();

        // Delete all items first to avoid foreign key constraints
        DB::connection('tenant')->table('items')->delete();

        // Then delete categories and brands
        DB::connection('tenant')->table('categories')->delete();
        DB::connection('tenant')->table('brands')->delete();
    }
    public function delete_items_warehouse($warehouse)
    {
        try {
            DB::connection('tenant')->beginTransaction();

            // 1. First reset all references
            Document::where('id', '<>', null)->update(['orden_id' => null, 'sale_note_id' => null]);
            SaleNote::where('id', '<>', null)->update(['orden_id' => null]);
            Configuration::whereHas('item_variation', function ($q) use ($warehouse) {
                $q->where('warehouse_id', $warehouse);
            })->update(['item_variation_id' => null]);

            // 2. Get items to delete
            $items_query = DB::connection('tenant')->table('items')
                ->whereExists(function ($q) use ($warehouse) {
                    $q->select(DB::raw(1))
                        ->from('item_warehouse')
                        ->whereRaw('item_warehouse.item_id = items.id')
                        ->where('warehouse_id', $warehouse);
                });

            $item_ids = $items_query->pluck('id')->toArray();

            // 3. Delete transfers first to avoid foreign key constraints
            DB::connection('tenant')->table('transfers_place_detail')
                ->whereIn('item_id', $item_ids)
                ->delete();

            DB::connection('tenant')->table('transfers_place')
                ->where('warehouse_id', $warehouse)
                ->delete();

            // 4. Delete most dependent records first
            DB::connection('tenant')->table('item_room_services')
                ->whereIn('food_id', function ($q) use ($item_ids) {
                    $q->select('id')
                        ->from('foods')
                        ->whereIn('item_id', $item_ids);
                })
                ->delete();

            // 5. Delete all item-related dependencies
            DB::connection('tenant')->table('item_warranty')
                ->delete();

            DB::connection('tenant')->table('item_unit_type_price_ranges')
                ->delete();

            DB::connection('tenant')->table('item_price_ranges')
                ->whereIn('item_id', $item_ids)
                ->delete();

            ItemWarehousePrice::whereIn('item_id', $item_ids)->delete();
            Kardex::whereIn('item_id', $item_ids)->delete();
            ItemLot::whereIn('item_id', $item_ids)->delete();
            ItemUnitType::whereIn('item_id', $item_ids)->delete();
            ItemLotsGroup::whereIn('item_id', $item_ids)->delete();
            ItemSet::whereIn('individual_item_id', $item_ids)
                ->delete();

            OrdenItem::whereIn('food_id', function ($q) use ($item_ids) {
                $q->select('id')
                    ->from('foods')
                    ->whereIn('item_id', $item_ids);
            })->delete();

            Food::whereIn('item_id', $item_ids)->delete();

            // 6. Delete item warehouse records
            ItemWarehouse::where('warehouse_id', $warehouse)->delete();

            // 7. Delete items from brands and categories
            DB::connection('tenant')->table('items')
                ->whereIn('id', $item_ids)
                ->update(['brand_id' => null, 'category_id' => null]);

            // 8. Delete the items
            DB::connection('tenant')->table('items')
                ->whereIn('id', $item_ids)
                ->delete();

            // 9. Delete orphaned brands and categories
            DB::connection('tenant')->table('brands')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('items')
                        ->whereRaw('items.brand_id = brands.id');
                })
                ->delete();

            DB::connection('tenant')->table('categories')
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('items')
                        ->whereRaw('items.category_id = categories.id');
                })
                ->delete();

            DB::connection('tenant')->commit();
        } catch (\Exception $e) {
            DB::connection('tenant')->rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
    public function deleteItems(Request $request)
    {
        $warehouse = $request->input('warehouse');

        if ($warehouse) {
            $this->delete_items_warehouse($warehouse);
        } else {
            $this->delete_items();
        }


        return [
            'success' => true,
            'message' => 'Productos  eliminados',
        ];
    }
    public function delete_documents_warehouse($warehouse)
    {
        try {
            DB::connection('tenant')->beginTransaction();

            // 1. First nullify ALL foreign key references
            Box::query()->update([
                'sale_note_payment_id' => null,
                'cash_id' => null,
            ]);

            /* Document::where('id', '<>', null)
                ->where('establishment_id', $warehouse)->update(['orden_id' => null, 'sale_note_id' => null]);

            SaleNote::where('id', '<>', null)
                ->where('establishment_id', $warehouse)
                ->update(['orden_id' => null]); */

            // 1. First clear ALL orden references to ensure clean deletion
            Document::where('establishment_id', $warehouse)
                ->update(['orden_id' => null, 'sale_note_id' => null]);
            
            SaleNote::where('establishment_id', $warehouse)
                ->update(['orden_id' => null]);

            // 2. Clear references in ordens table
            DB::connection('tenant')->table('ordens')
                ->update([
                    'sale_note_id' => null,
                    'document_id' => null
                ]);

            // 3. Delete orden_items first (they reference ordens)
            DB::connection('tenant')->table('orden_item')
                ->whereIn('orden_id', function($query) use ($warehouse) {
                    $query->select('id')
                        ->from('ordens');
                        
                })
                ->delete();
                
            // 4. Now we can safely delete ordens
            DB::connection('tenant')->table('ordens')->delete();

            // 2. Delete tables that reference boxes
            BoxesDetail::query()->delete();
            GlobalPayment::query()->delete();

            // 3. Now safe to delete boxes
            //Box::query()->delete();

            Box::where('establishment_id', $warehouse)->delete();

            // 4. Delete Orden related records first
            /* OrdenItem::whereHas('orden.table', function ($q) use ($warehouse) {
                $q->where('establishment_id', $warehouse);
            })->delete();

            Orden::whereHas('table', function ($q) use ($warehouse) {
                $q->where('establishment_id', $warehouse);
            })->delete(); */

            // 5. Now safe to delete sale_notes
            SaleNotePayment::whereHas('sale_note', function ($q) use ($warehouse) {
                $q->where('establishment_id', $warehouse);
            })->delete();

            SaleNoteItem::whereHas('sale_note', function ($q) use ($warehouse) {
                $q->where('establishment_id', $warehouse);
            })->delete();

            SaleNote::where('establishment_id', $warehouse)->delete();

            // 4. Finally delete payments and sale notes
            SaleNotePayment::whereHas('sale_note', function ($q) use ($warehouse) {
                $q->where('establishment_id', $warehouse);
            })->delete();

            SaleNoteItem::whereHas('sale_note', function ($q) use ($warehouse) {
                $q->where('establishment_id', $warehouse);
            })->delete();

            Receipt::whereHas('sale_note', function ($q) use ($warehouse) {
                $q->where('establishment_id', $warehouse);
            })->delete();

            SaleNotePromotion::whereHas('sale_note', function ($q) use ($warehouse) {
                $q->where('establishment_id', $warehouse);
            })->delete();

            SaleNoteCredit::whereHas('sale_note', function ($q) use ($warehouse) {
                $q->where('establishment_id', $warehouse);
            })->delete();

            // 5. Delete related documents
            DocumentItem::whereHas('document', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            DocumentPayment::whereHas('document', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            VoidedDocument::whereHas('document', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            Note::whereHas('document', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();

            // 6. Delete other related records
            CreditList::where('establishment_id', $warehouse)->delete();
            CashTransfer::whereHas('cash_principal', function ($e) use ($warehouse) {
                $e->whereHas('user', function ($e) use ($warehouse) {
                    $e->where('establishment_id', $warehouse);
                });
            })->delete();
            Invoice::whereHas('document', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            HotelRentDocument::whereHas('document', function ($d) use ($warehouse) {
                $d->where('establishment_id', $warehouse);
            })->orWhereHas('sale_note', function ($d) use ($warehouse) {
                $d->where('establishment_id', $warehouse);
            })->delete();
            HotelRentItemServices::whereHas('hotel_rent_item', function ($e) use ($warehouse) {
                $e->whereHas('hotel_rent', function ($e) use ($warehouse) {
                    $e->where('establishment_id', $warehouse);
                });
            })->delete();
            ModelsTable::where('establishment_id', $warehouse)->update(['status_table_id' => 1]);
            Kardex::whereHas('item', function ($e) use ($warehouse) {
                $e->whereHas('itemwarehouses', function ($e) use ($warehouse) {
                    $e->where('warehouse_id', $warehouse);
                });
            })->delete();
            SaleNotePromotion::whereHas('sale_note', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            SaleNoteCredit::whereHas('sale_note', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            Receipt::whereHas('sale_note', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            SummaryDocument::whereHas('document', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            Summary::whereIn('soap_type_id', ['01', '02', '03'])->delete();
            InternetItem::query()->delete();
            InternetPaymentMonth::query()->delete();
            InternetPayment::query()->delete();
            InternetPlanOperation::query()->delete();
            InternetConceptOperation::query()->delete();
            InternetOperation::query()->delete();
            InternetRegister::query()->delete();
            BoxesDetail::whereHas('box', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            Box::where('establishment_id', $warehouse)->delete();
            // Orden and OrdenItem already deleted above

            SaleNoteItem::whereHas('inventory_kardex.item.itemwarehouses', function ($q) use ($warehouse) {
                $q->where('warehouse_id', $warehouse);
            })->delete();

            InventoryKardex::whereHas('item.itemwarehouses', function ($q) use ($warehouse) {
                $q->where('warehouse_id', $warehouse);
            })->delete();


            /* SaleNoteItem::whereHas('sale_note', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            InventoryKardex::whereHas('item', function ($e) use ($warehouse) {
                $e->whereHas('itemwarehouses', function ($e) use ($warehouse) {
                    $e->where('warehouse_id', $warehouse);
                });
            })->delete(); */
            SaleNotePayment::whereHas('sale_note', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            DocumentItem::whereHas('document', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            DocumentPayment::whereHas('document', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            VoidedDocument::whereHas('document', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            Note::whereHas('document', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();

            SaleNote::where('establishment_id', $warehouse)->delete();
            Document::where('establishment_id', $warehouse)->delete();
            PurchaseItem::whereHas('purchase', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            PurchasePayment::whereHas('purchase', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            Purchase::where('establishment_id', $warehouse)->delete();
            CashIncomePrincipal::whereHas('cash', function ($e) use ($warehouse) {
                $e->whereHas('user', function ($e) use ($warehouse) {
                    $e->where('establishment_id', $warehouse);
                });
            })->delete();
            Cash::whereHas('user', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            GlobalPayment::whereIn('soap_type_id', ['01', '02', '03'])->delete();
            DB::connection('tenant')->table('social_media_clients')->delete();
            DB::connection('tenant')->table('vip_clients')->delete();
            Vip::query()->delete();
            QuotationItem::whereHas('quotation', function ($e) use ($warehouse) {
                $e->where('establishment_id', $warehouse);
            })->delete();
            Quotation::where('establishment_id', $warehouse)->delete();

            Voided::where('soap_type_id', ['01', '02', '03'])->delete();
            Purchase::where('soap_type_id', ['01', '02', '03'])->where('establishment_id', $warehouse)->delete();

            Document::where('soap_type_id', ['01', '02', '03'])
                ->whereIn('document_type_id', ['07', '08'])->where('establishment_id', $warehouse)->delete();
            Document::where('soap_type_id', ['01', '02', '03'])->where('establishment_id', $warehouse)->delete();
            $sale_notes = SaleNote::where('soap_type_id', ['01', '02', '03'])->where('establishment_id', $warehouse)->get();
            foreach ($sale_notes as $key => $row) {
                Receipt::where('sale_note_id', $row->id)->delete();
            }

            SaleNote::where('soap_type_id', ['01', '02', '03'])->where('establishment_id', $warehouse)->delete();
            Box::where('soap_type_id', ['01', '02', '03'])->where('establishment_id', $warehouse)->delete();
            DB::connection('tenant')->commit();
        } catch (\Exception $e) {
            DB::connection('tenant')->rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
    public function delete_documents()
    {
        try {
            DB::connection('tenant')->beginTransaction();

            // 1. First nullify ALL foreign key references
            Box::query()->update([
                'sale_note_payment_id' => null,
                'cash_id' => null,
            ]);

            //Orden::query()->update(['sale_note_id' => null]);
            //Document::query()->update(['orden_id' => null]);
            /* Document::where('id', '<>', null)->update(['orden_id' => null, 'sale_note_id' => null]);
            SaleNote::query()->update(['orden_id' => null]); */

            Document::where('id', '<>', null)->update(['orden_id' => null, 'sale_note_id' => null]);
            SaleNote::where('id', '<>', null)->update(['orden_id' => null]);

            // 2. Delete tables that reference boxes
            DB::connection('tenant')->table('boxes_detail')->delete();
            GlobalPayment::query()->delete();

            // 3. Now safe to delete boxes
            Box::query()->delete();

            // Update deletion order - move Orden deletion before SaleNote
            DB::connection('tenant')->table('orden_item')->delete();
            DB::connection('tenant')->table('ordens')->delete();

            // Now safe to delete sale_notes
            DB::connection('tenant')->table('sale_note_payments')->delete();
            DB::connection('tenant')->table('sale_note_items')->delete();
            DB::connection('tenant')->table('sale_notes')->delete();

            DB::connection('tenant')->table('credit_lists')->delete();
            DB::connection('tenant')->table('cash_transfers')->delete();
            DB::connection('tenant')->table('invoices')->delete();
            DB::connection('tenant')->table('hotel_rent_documents')->delete();
            DB::connection('tenant')->table('hotel_rent_item_services')->delete();
            DB::connection('tenant')->table('tables')->update(['status_table_id' => 1]);
            DB::connection('tenant')->table('kardex')->delete();
            DB::connection('tenant')->table('sale_notes_promotions')->delete();
            DB::connection('tenant')->table('sale_note_credits')->delete();
            DB::connection('tenant')->table('receipts')->delete();
            DB::connection('tenant')->table('summary_documents')->delete();
            DB::connection('tenant')->table('internet_item')->delete();
            DB::connection('tenant')->table('internet_payment_month')->delete();
            DB::connection('tenant')->table('internet_payments')->delete();
            DB::connection('tenant')->table('internet_plan_operation')->delete();
            DB::connection('tenant')->table('internet_concept_operation')->delete();
            DB::connection('tenant')->table('internet_operations')->delete();
            DB::connection('tenant')->table('internet_register')->delete();
            DB::connection('tenant')->table('boxes_detail')->delete();
            DB::connection('tenant')->table('boxes')->delete();
            DB::connection('tenant')->table('orden_item')->delete();
            DB::connection('tenant')->table('ordens')->delete();
            //DB::connection('tenant')->table('sale_note_items')->delete();
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
            DB::connection('tenant')->table('cash_income_principal')->delete();
            DB::connection('tenant')->table('cash')->delete();
            DB::connection('tenant')->table('global_payments')->delete();
            DB::connection('tenant')->table('social_media_clients')->delete();
            DB::connection('tenant')->table('vip_clients')->delete();
            DB::connection('tenant')->table('vips')->delete();
            DB::connection('tenant')->table('quotation_items')->delete();
            DB::connection('tenant')->table('quotations')->delete();
            Summary::where('soap_type_id', ['01', '02', '03'])->delete();
            Voided::where('soap_type_id', ['01', '02', '03'])->delete();
            $this->deleteInventoryKardex(Purchase::class);
            Purchase::where('soap_type_id', ['01', '02', '03'])->delete();
            $this->deleteInventoryKardex(Document::class);
            Document::where('soap_type_id', ['01', '02', '03'])
                ->whereIn('document_type_id', ['07', '08'])->delete();
            Document::where('soap_type_id', ['01', '02', '03'])->delete();
            $sale_notes = SaleNote::where('soap_type_id', ['01', '02', '03'])->get();
            foreach ($sale_notes as $key => $row) {
                Receipt::where('sale_note_id', $row->id)->delete();
            }
            SaleNote::where('soap_type_id', ['01', '02', '03'])->delete();
            GlobalPayment::whereIn('soap_type_id', ['01', '02', '03'])->delete();
            Box::where('soap_type_id', ['01', '02', '03'])->delete();
            DB::connection('tenant')->commit();
        } catch (\Exception $e) {
            DB::connection('tenant')->rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
    public function deleteDocuments(Request $request)
    {

        $warehouse = $request->input('warehouse');
        if ($warehouse) {
            $this->delete_documents_warehouse($warehouse);
        } else {
            $this->delete_documents();
        }


        return [
            'success' => true,
            'message' => 'Documentos de prueba eliminados',
        ];
    }

    private function deleteInventoryKardex($model, $records = null)
    {

        if (!$records) {
            $records = $model::where('soap_type_id', ['01', '02', '03'])->get();
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
