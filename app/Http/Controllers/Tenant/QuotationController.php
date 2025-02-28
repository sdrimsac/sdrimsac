<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Person;
use App\Models\Tenant\Catalogs\CurrencyType;
use App\Models\Tenant\Catalogs\ChargeDiscountType;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Quotation;
use App\CoreFacturalo\Requests\Inputs\Common\LegendInput;
use App\Models\Tenant\Item;
use App\Models\Tenant\Series;
use App\Http\Resources\Tenant\QuotationCollection;
use App\Http\Resources\Tenant\QuotationResource;
use App\Http\Resources\Tenant\QuotationResource2;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Catalogs\DocumentType;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\Catalogs\PriceType;
use App\Models\Tenant\Catalogs\SystemIscType;
use App\Models\Tenant\Catalogs\AttributeType;
use App\Models\Tenant\Company;
use App\Http\Requests\Tenant\QuotationRequest;
use App\Models\Tenant\Warehouse;
use Illuminate\Support\Str;
use App\CoreFacturalo\Requests\Inputs\Common\PersonInput;
use App\CoreFacturalo\Requests\Inputs\Common\EstablishmentInput;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\CoreFacturalo\Requests\Inputs\Functions;
use App\CoreFacturalo\Template;
use App\Exports\ConsolidatedExport;
use App\Exports\ConsolidatedExportDocument;
use App\Http\Resources\Tenant\ConsolidateQuotationCollection;
use Mpdf\Mpdf;
use Mpdf\HTMLParserMode;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuotationEmail;
use App\Models\Tenant\Box;
use App\Models\Tenant\Cash;
use App\Models\Tenant\ClientZone;
use App\Models\Tenant\PaymentMethodType;
use Modules\Finance\Traits\FinanceTrait;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Consolidated;
use App\Models\Tenant\Document;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Seller;
use App\Models\Tenant\StateType;
use App\Models\Tenant\UnitTypePerson;
use App\Models\Tenant\User;
use Carbon\Carbon;
use LDAP\Result;
use Modules\Dispatch\Models\Driver;
use Modules\Dispatch\Models\Transport;
use Modules\Restaurant\Events\OrdenEvent;
use Modules\Restaurant\Events\PrintEvent;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\Table;

class QuotationController extends Controller
{

    use StorageDocument, FinanceTrait;

    protected $quotation;
    protected $company;

    public function itemsToCash2($id)
    {
        $quotation = Quotation::find($id);
        $cash = Cash::where('user_id', auth()->user()->id)->where('state', 1)->first();
        if (!$cash) {
            return [
                'success' => false,
                'message' => 'No se encontró caja activa'
            ];
        }
        try {
            DB::beginTransaction();
            $configuration = Configuration::firstOrFail();
            $customer_id = $quotation->customer_id;
            $customer = Person::find($customer_id);
            $customer_name = $customer->name;
            $items = $quotation->items;
            $user_id = auth()->id();
            $items_restore = [];
            foreach ($items as $it) {

                $item_restore = [];
                $item = Item::find($it->item_id)
                    ->load('food');
                $item = $item->toArray();
                $item_restore['id'] = $item["food"]["id"];
                $item_restore['food'] = $item["food"];
                $item_restore['observation'] = null;
                $item_restore['price'] = $it->unit_price;
                $item_restore['quantity'] = $it->quantity;
                if (isset($it->item->from_unit_type_id)) {

                    $unit_type_id = $it->item->from_unit_type_id;
                    $unit_type = ItemUnitType::find($unit_type_id);
                    $item_restore['type_quotation'] = $unit_type;
                }
                if (isset($it->item->categoriaMadera)) {
                    $item_restore['categoriaMadera'] = $it->item->categoriaMadera;
                    $key = Str::random(20);
                    $item_restore['categoriaMadera']->key = $key;
                }
                $items_restore[] = $item_restore;
            }
            DB::commit();
            return [
                'identifier' => $quotation->number_full,
                'quotation_id' => $quotation->id,
                'success' => true,
                'message' => 'Items enviados a caja',
                'items' => $items_restore,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    public function itemsToCash($id)
    {
        $quotation = Quotation::find($id);
        $cash = Cash::where('user_id', auth()->user()->id)->where('state', 1)->first();
        if (!$cash) {
            return [
                'success' => false,
                'message' => 'No se encontró caja activa'
            ];
        }
        // $cash_id = $cash->id;
        try {
            DB::beginTransaction();
            $configuration = Configuration::firstOrFail();
            $customer_id = $quotation->customer_id;
            $customer = Person::find($customer_id);
            $customer_name = $customer->name;
            $items = $quotation->items;
            $user_id = auth()->id();
            $table_caja_id = Table::get_caja();
            $table_caja = Table::find($table_caja_id);
            $table_caja->status_table_id = 2;
            $table_caja->save();
            $status_orden_id = 1;
            $orden = Orden::create([
                'table_id' => $table_caja_id,
                'status_orden_id' => $status_orden_id,
                'date' => date('Y-m-d'),
                'ref' => $customer_name
            ]);
            $orden_items_ids = [];
            $orden_items_ids_for_kitchen = [];
            foreach ($items as $it) {
                $item = Item::find($it->item_id)
                    ->load('food');
                $item = $item->toArray();
                $orden_item = new OrdenItem;
                $orden_item->food_id = $item["food"]["id"];
                $orden_item->observations = $item['observation'] ?? '-';
                $orden_item->quantity = $it->quantity;
                $orden_item->unit_type_id = Functions::valueKeyInArray($item, 'type_id', null);
                $orden_item->price = $it->unit_price;
                $orden_item->user_id = $user_id;
                $orden_item->orden_id = $orden->id;
                $orden_item->to_carry = Functions::valueKeyInArray($item, 'to_carry', 0);
                $orden_item->status_orden_id = 1;
                $orden_item->date = Carbon::today();
                $orden_item->time = date('H:i:s');
                $orden_item->area_id = $item['food']['area_id'];
                $orden_item->name_product_pdf = $it->name_product_pdf;
                $orden_item->save();
                $orden_items_ids[] = $orden_item->id;
                $orden_items_ids_for_kitchen[] = [
                    "orden_id" => $orden_item->id,
                    "area_id" => $orden_item->area_id
                ];
                event(new OrdenEvent($orden_item->id));
                $print_box = $configuration->print_commands;
                $print_kitchen = $configuration->print_kitchen;
                if ($print_kitchen) {
                    $ids_areas = array_unique(array_column($orden_items_ids_for_kitchen, "area_id"));
                    foreach ($ids_areas as $area_id) {
                        $filtered = array_column(array_filter($orden_items_ids_for_kitchen, function ($a) use ($area_id) {
                            return $area_id == $a['area_id'];
                        }), "orden_id");
                        // event(new PrintEvent($orden->id, "0", true, $area_id, $filtered));
                    }
                }
                // $isFromBox = $this->isArea("CAJ", $user->area_id);

                // if ($print_box) {
                //     event(new PrintEvent($orden->id, "0", true, $this->getBoxArea(), $orden_items_ids));
                // }

            }
            DB::commit();
            return [
                'cot' => $quotation->number_full,
                'success' => true,
                'orden' => Orden::find($orden->id),
                'message' => 'Items enviados a caja'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    public function index()
    {
        $company = Company::select('soap_type_id')->first();
        $soap_company  = $company->soap_type_id;

        return view('tenant.quotations.index', compact('soap_company'));
    }


    public function create($saleOpportunityId = null)
    {
        $configuration = Configuration::first();
        return view('tenant.quotations.form', compact('saleOpportunityId', 'configuration'));
    }

    public function edit($id)
    {
        $resourceId = $id;
        return view('tenant.quotations.form_edit', compact('resourceId'));
    }
    function getSeriesId($document_type_id)
    {
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $series = Series::where('establishment_id', $establishment->id)
            ->where('document_type_id', $document_type_id)
            ->first();
        return $series->id;
    }
    function itemsWithStock($items, $establishment_id)
    {
        $items_with_stock = [];
        foreach ($items as $item) {
            $quantity = $item->quantity;
            $from_unit_type_id_desc = $item->item->from_unit_type_id_desc;
            $from_unit_type_id = $item->item->from_unit_type_id;
            $item_unit_types = $item->item->item_unit_types;
            if (($from_unit_type_id_desc || $from_unit_type_id) && $item_unit_types) {
                if ($from_unit_type_id_desc) {
                    $quantity = $quantity * collect($item_unit_types)->where('description', $from_unit_type_id_desc)->first()->quantity_unit;
                }
                if ($from_unit_type_id) {
                    $quantity = $quantity * collect($item_unit_types)->where('id', $from_unit_type_id)->first()->quantity_unit;
                }
            }
            $item_id = $item->item_id;
            $item_warehouse = ItemWarehouse::select('stock')->where('item_id', $item_id)->where('warehouse_id', $establishment_id)->first();
            if ($item_warehouse && $item_warehouse->stock >= $quantity) {
                $items_with_stock[] = $item;
            }
        }
        return $items_with_stock;
    }

    function getDocumentArray($quotation_id)
    {
        $q = Quotation::find($quotation_id);
        $document = [];
        $person = Person::find($q->customer_id);
        $document_type_id = $person->document_type_id;
        if ($document_type_id == null) {
            $identity_document_type_id = $person->identity_document_type_id;
            $document_type_id = ($identity_document_type_id == '6') ? '01' : '03';
        }
        $person = Person::where('id', $q->customer_id)->first();
        $customer_id = $person->id;
        if ($person->varios) {
            $customer_id = Person::getIdClientesVariosOrCreate();
        }
        $document['document_type_id'] = $document_type_id;
        $document['series_id'] = $this->getSeriesId($document_type_id);
        $document['number'] = '#';
        $document['establishment_id'] = $q->establishment_id;
        $document['date_of_issue'] = Carbon::now()->format('Y-m-d');
        $document['time_of_issue'] = date("H:i:s");
        $document['customer_id'] = $customer_id;
        $document['currency_type_id'] = $q->currency_type_id;
        $document['purchase_order'] = null;
        $document['exchange_rate_sale'] = $q->exchange_rate_sale;
        $document['total_prepayment'] = $q->total_prepayment;
        $document['total_charge'] = $q->total_charge;
        $document['total_discount'] = $q->total_discount;
        $document['total_exportation'] = $q->total_exportation;
        $document['total_free'] = $q->total_free;
        $document['total_taxed'] = $q->total_taxed;
        $document['total_unaffected'] = $q->total_unaffected;
        $document['total_exonerated'] = $q->total_exonerated;
        $document['total_igv'] = $q->total_igv;
        $document['total_base_isc'] = $q->total_base_isc;
        $document['total_isc'] = $q->total_isc;
        $document['total_base_other_taxes'] = $q->total_base_other_taxes;
        $document['total_other_taxes'] = $q->total_other_taxes;
        $document['total_taxes'] = $q->total_taxes;
        $document['total_value'] = $q->total_value;
        $document['payments'] = [];
        $document['total'] = $q->total;
        $document['prefix'] = "NV";
        $document['seller_id'] = $q->seller_id;
        $document['operation_type_id'] = "0101";
        $document['date_of_due'] = Carbon::now()->format('Y-m-d');
        $document['items'] = $this->itemsWithStock($q->items, $q->establishment_id);
        $document['charges'] = $q->charges;
        $document['discounts'] = $q->discounts;
        $document['attributes'] = [];
        $document['guides'] = $q->guides;
        $document['additional_information'] = null;
        $document['actions'] = [
            'format_pdf' => "a4"
        ];
        $document['quotation_id'] = $q->id;

        return $this->reCalculateTotal($document);
    }
    function reCalculateTotal($document){
        $total_discount = 0;
        $total_charge = 0;
        $total_exportation = 0;
        $total_taxed = 0;
        $total_exonerated = 0;
        $total_unaffected = 0;
        $total_free = 0;
        $total_igv = 0;
        $total_value = 0;
        $total = 0;
        $total_plastic_bag_taxes = 0;

        foreach ($document['items'] as $row) {
            $total_discount += floatval($row->total_discount);
            $total_charge += floatval($row->total_charge);

            if ($row->affectation_igv_type_id === "10") {
                $total_taxed += floatval($row->total_value);
            }
            if ($row->affectation_igv_type_id === "20") {
                $total_exonerated += floatval($row->total_value);
            }
            if ($row->affectation_igv_type_id === "30") {
                $total_unaffected += floatval($row->total_value);
            }
            if ($row->affectation_igv_type_id === "40") {
                $total_exportation += floatval($row->total_value);
            }
            if (in_array($row->affectation_igv_type_id, ["11", "12", "13", "14", "15", "16"])) {
                $unit_value = floatval($row->total_value) / floatval($row->quantity);
                $total_value_partial = $unit_value * floatval($row->quantity);
                $row->total_taxes = floatval($row->total_value) - $total_value_partial + floatval($row->total_plastic_bag_taxes ?? 0);
                $row->total_igv = $total_value_partial * (floatval($row->percentage_igv) / 100);
                $row->total_base_igv = $total_value_partial;
                $total_value -= floatval($row->total_value);
                $total += floatval($row->total);
            }
            if (in_array($row->affectation_igv_type_id, ["10", "20", "30", "40"])) {
                $total_igv += floatval($row->total_igv);
                $total += floatval($row->total);
            }
            if (!in_array($row->affectation_igv_type_id, ["21", "37"])) {
                $total_value += floatval($row->total_value);
            }
            $total_plastic_bag_taxes += floatval($row->total_plastic_bag_taxes ?? 0);
        }

        $document['total_exportation'] = round($total_exportation, 2);
        $document['total_taxed'] = round($total_taxed, 2);
        $document['total_exonerated'] = round($total_exonerated, 2);
        $document['total_unaffected'] = round($total_unaffected, 2);
        $document['total_free'] = round($total_free, 2);
        $document['total_igv'] = round($total_igv, 2);
        $document['total_value'] = round($total_value, 2);
        $document['total_value_without_rounding'] = $total_value;
        $document['total_taxes'] = round($total_igv, 2);
        $document['total_plastic_bag_taxes'] = round($total_plastic_bag_taxes, 2);
        $document['total'] = round($total_charge + $total + $document['total_plastic_bag_taxes'], 2);

        return $document;
    }
    function hasDocumentOrSaleNote($id)
    {
        $document = DB::connection('tenant')->table('documents')->where('quotation_id', $id)->exists();
        $sale_note = DB::connection('tenant')->table('sale_notes')->where('quotation_id', $id)->exists();

        return $document || $sale_note;
    }

    public function consolidatedsEditDocument(Request $request)
    {
        if (!$request->has('quotation_id')) {
            return [
                'success' => false,
                'message' => 'Se requiere la cotización'
            ];
        }



        try {
            DB::beginTransaction();

            $quotation = Quotation::find($request->quotation_id);
            $sale_note_id = null;
            $document_id = null;
            $document = Document::where('quotation_id', $quotation->id)->first();
            if (!$document) {
                $document = SaleNote::where('quotation_id', $quotation->id)->first();
                $sale_note_id = $document->id;
            } else {
                $document_id = $document->id;
            }

            if (!$quotation) {
                return [
                    'success' => false,
                    'message' => 'Documento no encontrado'
                ];
            }

            $items = $quotation->items;
            $items_restore = [];

            foreach ($items as $it) {
                $item_restore = [];
                $item = Item::find($it->item_id)
                    ->load('food');
                $item = $item->toArray();

                $item_restore['id'] = $item["food"]["id"];
                $item_restore['food'] = $item["food"];
                $item_restore['observation'] = null;
                $item_restore['price'] = $it->unit_price;
                $item_restore['quantity'] = $it->quantity;

                if (isset($it->item->from_unit_type_id)) {
                    $unit_type_id = $it->item->from_unit_type_id;
                    $unit_type = ItemUnitType::find($unit_type_id);
                    $item_restore['type_quotation'] = $unit_type;
                }



                $items_restore[] = $item_restore;
            }

            DB::commit();

            return [
                'success' => true,
                'items' => $items_restore,
                'identifier' => $quotation->number_full,
                'quotation_id' => $quotation->id,
                'customer_number' => $quotation->customer->number,
                'sale_note_id' => $sale_note_id,
                'document_id' => $document_id,

            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    public function consolidatedsPayDocument(Request $request)
    {

        try {
            DB::connection('tenant')->beginTransaction();
            $company = Company::first();
            $document_id = $request->document_id;
            $sale_note_id = $request->sale_note_id;
            $document = null;
            if ($document_id) {
                $document = Document::find($document_id);
            } else {
                $document = SaleNote::find($sale_note_id);
            }
            $user_id = auth()->user()->id;
            $cash = Cash::where('user_id', $user_id)->where('state', '1')->first();
            if (!$cash) {
                return [
                    'success' => false,
                    'message' => 'No se encontró caja abierta'
                ];
            }

            $method = $request->payment_method;
            $amount = $request->total;
            $cajas    = new Box();
            $cajas->cash_id = $cash->id;
            $cajas->group_id = 1;
            $cajas->category_id = 1;
            $cajas->subcategory_id = 1;
            $cajas->amount = $amount;
            $cajas->date = Carbon::parse($request->input('date_of_issue'))->format('Y-m-d');
            $cajas->type = '1';
            $cajas->state = '1';
            $cajas->method = $method;
            $type_document = $document->document_type_id == '01' ? "FACTURA" : ($document->document_type_id == '03' ? "BOLETA" : "NOTA DE VENTA");
            $description = $type_document . " N° " . $document->series . " - " . $document->number;
            $cajas->sale_note_id = $sale_note_id;
            $cajas->document_id = $document_id;
            $cajas->description = "VENTAS " . $description;
            $cajas->user_id = auth()->user()->id;
            $cajas->soap_type_id = $company->soap_type_id;
            $cajas->establishment_id = auth()->user()->establishment_id;
            $cajas->save();
            DB::connection('tenant')->commit();

            return [
                'success' => true,
                'message' => 'Documento pagado correctamente'
            ];
        } catch (Exception $e) {
            DB::connection('tenant')->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function consolidatedsLiquidate($id)
    {
        $consolidated = Consolidated::find($id);
        $quotations = $consolidated->quotations;
        $documents = [];
        foreach ($quotations as $quotation) {
            $document_id = null;
            $sale_note_id = null;

            $document = Document::where('quotation_id', $quotation->id)
                ->latest('created_at')
                ->first();

            $saleNote = SaleNote::where('quotation_id', $quotation->id)
                ->latest('created_at')
                ->first();

            if ($document && $saleNote) {
                if ($document->created_at > $saleNote->created_at) {
                    $document_id = $document->id;
                } else {
                    $sale_note_id = $saleNote->id;
                    $document = $saleNote;
                }
            } elseif ($document) {
                $document_id = $document->id;
            } elseif ($saleNote) {
                $sale_note_id = $saleNote->id;
                $document = $saleNote;
            }
            if (!$document) {
                continue;
            }
            $total = $document->total;
            $total_paid = $document->boxes()->sum('amount');
            $paid = $total_paid >= $total ? true : false;
            $balance = $total - $total_paid;
            $pdf = $document_id ? '/print/document/' . $document->external_id . '/ticket' : '/sale-note/print/' . $document->external_id . '/ticket';
            $total = number_format($total - $total_paid, 2, '.', '');
            $documents[] = [
                'quotation_full_number' => $quotation->number_full,
                'quotation_id' => $quotation->id,
                'document_id' => $document_id,
                'sale_note_id' => $sale_note_id,
                'full_number' => $document->number_full,
                'total' => $total,
                'date_of_issue' => $document->date_of_issue,
                'time_of_issue' => $document->time_of_issue,
                'customer_id' => $document->customer_id,
                'customer_name' => $document->customer->name,
                'paid' => $paid,
                'balance' => $balance,
                'pdf' => $pdf,
                'state_type_id' => $document->state_type_id
            ];
        }
        return [
            'success' => true,
            'documents' => $documents
        ];
    }
    public function consolidatedsPrint($id)
    {
        $consolidated = Consolidated::find($id);
        $quotation_ids = $consolidated->quotations->pluck('id');
        if (count($quotation_ids) === 0) {
            return [
                'success' => false,
                'message' => 'No se encontraron cotizaciones'
            ];
        }


        $documents = [];
        $to_print = [];
        $has_print = $this->hasDocumentOrSaleNote($quotation_ids->first());

        foreach ($quotation_ids as $quotation_id) {
            if ($has_print) {
                $document = Document::where('quotation_id', $quotation_id)->first();
                if ($document == null) {
                    $document = SaleNote::where('quotation_id', $quotation_id)->first();
                }
                if ($document) {
                    $documen_type_id = isset($document->document_type_id) ? $document->document_type_id : "80";
                    event(new PrintEvent($document->id, $documen_type_id, true, 0, [], true));
                }
            } else {
                $document = $this->getDocumentArray($quotation_id);
                $documents[] = $document;
            }
        }
        return [
            'success' => true,
            'message' => $has_print ? 'Documentos impresos' : 'Documentos listos para imprimir',
            'documents' => $documents,
            'to_print' => $to_print,
            'has_print' => $has_print
        ];
    }
    public function consolidatedsExportDocumentsDetail($id)
    {
        $consolidated = Consolidated::find($id);
        $quotations = $consolidated->quotations;
        $consolidated_info = [
            'vehicle_brand' => optional($consolidated->transport)->brand ?? '',
            'plate_number' => optional($consolidated->transport)->plate_number ?? '',
            'driver_name' => optional($consolidated->driver)->name ?? '',
            'count_01' => 0,
            'count_03' => 0,
            'count_80' => 0,
            'count_document' => 0,
            'total' => 0,
            'count_diff_customer' => 0,
        ];
        $temp_customer_id = [];
        $groupedQuotations = $quotations->groupBy(function ($quotation) {
            return $quotation->user_id;
        })->map(function ($group) {
            return $group->groupBy(function ($quotation) {
                $customer = Person::find($quotation->customer_id);
                return $customer ? $customer->client_zone_id : null;
            });
        });
        $registers = [];

        foreach ($groupedQuotations as $userId => $groupedQuotation) {
            $user = User::find($userId);
            $user_name = $user->name;
            $registers[$user_name] = [];

            foreach ($groupedQuotation as $zoneId => $quotations) {
                $zone_name = "-";
                if ($zoneId) {
                    $zone = ClientZone::find($zoneId);
                    $zone_name = $zone ? $zone->description : "-";
                }
                $registers[$user_name][$zone_name] = [];
                //ordenar $quotations por num_orden
                $quotations = $quotations->sortBy('num_orden');
                foreach ($quotations as $quotation) {
                    $document = Document::where('quotation_id', $quotation->id)
                        ->latest()
                        ->first();
                    $saleNote = SaleNote::where('quotation_id', $quotation->id)
                        ->latest()
                        ->first();

                    if ($document && $saleNote) {
                        if ($document->created_at > $saleNote->created_at) {
                            $selectedDocument = $document;
                        } else {
                            $selectedDocument = $saleNote;
                        }
                    } elseif ($document) {
                        $selectedDocument = $document;
                    } elseif ($saleNote) {
                        $selectedDocument = $saleNote;
                    } else {
                        $selectedDocument = null;
                    }
                    $total_weight = 0;

                    if ($selectedDocument) {
                        foreach ($selectedDocument->quotation->items as $item) {
                            if (isset($item->item->weight)) {
                                $total_weight += $item->item->weight * $item->quantity;
                            }
                        }

                        if (!in_array($selectedDocument->customer_id, $temp_customer_id)) {
                            $consolidated_info['count_diff_customer']++;
                            $temp_customer_id[] = $selectedDocument->customer_id;
                        }
                        $payed = $selectedDocument->boxes()->sum('amount');
                        $paid = $payed >= $selectedDocument->total ? true : false;
                        $consolidated_info['count_document']++;
                        $consolidated_info['total'] += $selectedDocument->total;
                        if ($selectedDocument->document_type_id == '01') {
                            $consolidated_info['count_01']++;
                        } elseif ($selectedDocument->document_type_id == '03') {
                            $consolidated_info['count_03']++;
                        } elseif ($selectedDocument->document_type_id == '80') {
                            $consolidated_info['count_80']++;
                        }
                        $register = [
                            'customer_address' => $selectedDocument->customer->address,
                            'customer_name' => $selectedDocument->customer->name,
                            'document_id' => $selectedDocument->id,
                            'number_full' => $selectedDocument->number_full,
                            'total' => $selectedDocument->total,
                            'zone' => $zone_name,
                            'num_orden' => $quotation->num_orden,
                            'state_type_id' => $selectedDocument->state_type_id,
                            'total_weight' => $total_weight,
                            'paid' => $paid,
                        ];
                        $registers[$user_name][$zone_name][] = $register;
                    }
                }
            }
        }

        return (new ConsolidatedExportDocument())
            ->records($registers)
            ->detail(true)
            ->consolidatedInfo($consolidated_info)
            ->company(Company::active())
            ->download("Reparto_documentos_{$consolidated->id}_{$consolidated->date_of_issue}.xlsx");
    }
    public function consolidatedsExportDocuments($id)
    {
        $consolidated = Consolidated::find($id);
        $quotations = $consolidated->quotations;
        $groupedQuotations = $quotations->groupBy(function ($quotation) {
            return $quotation->user_id;
        })->map(function ($group) {
            return $group->groupBy(function ($quotation) {
                $customer = Person::find($quotation->customer_id);
                return $customer ? $customer->client_zone_id : null;
            });
        });
        $registers = [];

        foreach ($groupedQuotations as $userId => $groupedQuotation) {
            $user = User::find($userId);
            $user_name = $user->name;
            $registers[$user_name] = [];

            foreach ($groupedQuotation as $zoneId => $quotations) {
                $zone_name = "-";
                if ($zoneId) {
                    $zone = ClientZone::find($zoneId);
                    $zone_name = $zone ? $zone->description : "-";
                }
                $registers[$user_name][$zone_name] = [];
                //ordenar $quotations por num_orden
                $quotations = $quotations->sortBy('num_orden');
                foreach ($quotations as $quotation) {
                    $document = Document::where('quotation_id', $quotation->id)
                        ->latest()
                        ->first();
                    $saleNote = SaleNote::where('quotation_id', $quotation->id)
                        ->latest()
                        ->first();

                    if ($document && $saleNote) {
                        if ($document->created_at > $saleNote->created_at) {
                            $selectedDocument = $document;
                        } else {
                            $selectedDocument = $saleNote;
                        }
                    } elseif ($document) {
                        $selectedDocument = $document;
                    } elseif ($saleNote) {
                        $selectedDocument = $saleNote;
                    } else {
                        $selectedDocument = null;
                    }

                    if ($selectedDocument) {
                        $unit_type = UnitTypePerson::where('customer_id', $selectedDocument->quotation->customer_id)->first();
                        $register = [
                            'customer_name' => $selectedDocument->customer->name,
                            'unit_type' => $unit_type ? $unit_type->description : '',
                            'document_id' => $selectedDocument->id,
                            'number_full' => $selectedDocument->number_full,
                            'total' => $selectedDocument->total,
                            'zone' => $zone_name,
                            'num_orden' => $quotation->num_orden,
                            'state_type_id' => $selectedDocument->state_type_id,
                        ];
                        $registers[$user_name][$zone_name][] = $register;
                    }
                }
            }
        }

        return (new ConsolidatedExportDocument())
            ->records($registers)
            ->company(Company::active())
            ->download("Reparto_documentos_{$consolidated->id}_{$consolidated->date_of_issue}.xlsx");
    }
    public function consolidatedsExportDelivery($id)
    {
        $consolidated = Consolidated::with('quotations.items')->find($id);
        $quotations = $consolidated->quotations()->with(['person.zone'])->get();
        $count = $quotations->count();
        // Agrupar las cotizaciones por zonas
        $groupedQuotations = $quotations->groupBy(function ($quotation) {
            return optional($quotation->person->zone)->description ?? '-'; // O el atributo que desees usar para agrupar
        });

        // Ejemplo de cómo podrías iterar sobre las cotizaciones agrupadas

        $quotationItems = $consolidated->quotations->flatMap(function ($quotation) {
            return $quotation->items;
        });

        $groupedItems = $quotationItems->groupBy(function ($item) {
            return $item->item_id;
        });
        $bonus_items = [];
        $transformedItems = $groupedItems->map(function ($items, $key) use (&$bonus_items) {
            $firstItem = $items->first();
            $itemData = $firstItem->item;
            $total = $items->sum('total');
            $totalQuantity = $items->sum('quantity');
            $totalWeight = $totalQuantity * isset($itemData->weight) ? $itemData->weight : 0;

            $itemDescription = $itemData->description;
            $itemInternalId = $itemData->internal_id;
            $unitTypeDescription = null;

            foreach ($items as $item) {
                if (isset($item->item->from_unit_type_id)) {
                    $unitType = ItemUnitType::find($item->item->from_unit_type_id);
                    if ($unitType) {
                        if ($unitType->qty_min > 0 && $unitType->qty_free > 0) {
                            $quantity = $item->quantity;
                            $bonus_quantity = $unitType->qty_free * floor($quantity / $unitType->qty_min);
                            if ($bonus_quantity > 0) {
                                $bonus_item = collect($bonus_items)->where('item_id', $item->item_id)->where('unit_type_description', $unitType->description)->first();
                                if ($bonus_item) {
                                    $bonus_item->quantity += $bonus_quantity;
                                } else {
                                    $bonus_items[] = (object) [
                                        'item_id' => $item->item_id,
                                        'quantity' => $bonus_quantity,
                                        'description' => $itemDescription,
                                        'unit_type_description' => $unitType->description,
                                        'internal_id' => $itemInternalId,
                                        'total' => 0,
                                    ];
                                }
                            }
                        }
                    }
                }
            }
            // if (isset($itemData->from_unit_type_id)) {
            //     $unitType = ItemUnitType::find($itemData->from_unit_type_id);
            //     // $unitTypeDescription = $unitType ? $unitType->description : '-';
            //     if($unitType->qty_min > 0 && $unitType->qty_free > 0){

            //     }
            // }

            return (object) [
                'item_id' => $firstItem->item_id,
                'total_quantity' => $totalQuantity,
                'item_description' => $itemDescription,
                'unit_type_description' => $unitTypeDescription,
                'item_internal_id' => $itemInternalId,
                'total' => $total,
                'total_weight' => $totalWeight,

            ];
        });
        return (new ConsolidatedExport())
            ->bonusItems($bonus_items)
            ->count($count)
            ->delivery(true)
            ->records($transformedItems)
            ->groupedQuotations($groupedQuotations)
            ->consolidated($consolidated)
            ->company(Company::active())
            ->download("Reparto_{$consolidated->id}_{$consolidated->date_of_issue}.xlsx");
    }
    public function consolidatedsExport($id)
    {
        $consolidated = Consolidated::with('quotations.items')->find($id);
        $quotations = $consolidated->quotations()->with(['person.zone'])->get();

        // Agrupar las cotizaciones por zonas
        $groupedQuotations = $quotations->groupBy(function ($quotation) {
            return optional($quotation->person->zone)->description ?? '-'; // O el atributo que desees usar para agrupar
        });

        // Ejemplo de cómo podrías iterar sobre las cotizaciones agrupadas

        $quotationItems = $consolidated->quotations->flatMap(function ($quotation) {
            return $quotation->items;
        });

        $groupedItems = $quotationItems->groupBy(function ($item) {
            $itemData = $item->item;
            return $item->item_id . '-' . ($itemData->from_unit_type_id ?? 'null');
        });

        $transformedItems = $groupedItems->map(function ($items, $key) {


            $firstItem = $items->first();
            $total = $items->sum('total');
            $unitPrice = $firstItem->unit_price;
            $itemData = $firstItem->item;
            $totalQuantity = $items->sum('quantity');
            $itemDescription = $itemData->description;
            $itemInternalId = $itemData->internal_id;
            $unitTypeDescription = null;

            if (isset($itemData->from_unit_type_id)) {
                $unitType = ItemUnitType::find($itemData->from_unit_type_id);
                $unitTypeDescription = $unitType ? $unitType->description : 'Unknown';
            }

            return (object) [
                'item_id' => $firstItem->item_id,
                'total_quantity' => $totalQuantity,
                'item_description' => $itemDescription,
                'unit_type_description' => $unitTypeDescription,
                'item_internal_id' => $itemInternalId,
                'total' => $total,
                'unit_price' => $unitPrice
            ];
        });
        return (new ConsolidatedExport())
            ->records($transformedItems)
            ->groupedQuotations($groupedQuotations)
            ->consolidated($consolidated)
            ->company(Company::active())
            ->download("Consolidado_{$consolidated->id}_{$consolidated->date_of_issue}.xlsx");
    }
    public function consolidateds(Request $request)
    {
        $records = Consolidated::whereHas('quotations');
        $date = $request->date;
        $number = $request->number;
        if ($date) {
            $records->where('date_of_issue', $date);
        }
        if ($number) {
            $remove_zero_from_start = ltrim($number, '0');
            $records->where('id', $remove_zero_from_start);
        }
        $records = $records->orderBy('id', 'desc');
        return new ConsolidateQuotationCollection($records->paginate(config('tenant.items_per_page')));
        // return new QuotationCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function consolidatedTables(Request $request)
    {
        $sellers = User::where('type', 'seller')
            ->whereHas('worker_type', function ($query) {
                $query->where('description', 'like', '%Vendedor%');
            })
            ->get()->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'name' => $row->name,
                ];
            });
        $zones = ClientZone::all();
        $transports = Transport::where('is_active', true)->get();
        $drivers = Driver::where('is_active', true)->get();
        return [
            'sellers' => $sellers,
            'zones' => $zones,
            'transports' => $transports,
            'drivers' => $drivers
        ];
    }
    public function consolidated(Request $request)
    {

        $weight = $request->weight;
        $excludes = $request->excludes;
        $consolidated = new Consolidated();
        $consolidated->user_id = auth()->id();
        $consolidated->establishment_id = auth()->user()->establishment_id;
        $consolidated->date_of_issue = date('Y-m-d');
        $consolidated->weight = $weight;
        $consolidated->transport_id = $request->transport_id;
        $consolidated->driver_id = $request->driver_id;
        $consolidated->save();
        Quotation::where('consolidated', false)
            ->whereNotIn('id', $excludes)
            ->update([
                'consolidated' => true,
                'consolidated_id' => $consolidated->id
            ]);

        return [
            'success' => true,
            'message' => 'Cotizaciones consolidadas'
        ];
    }
    public function getLastNumOrden()
    {
        $data = Quotation::getOrdenNumber();

        return [
            'success' => true,
            'data' => $data
        ];
    }
    public function toConsolidated()
    {
        $records = Quotation::where('consolidated', false)
            ->orderBy('id', 'asc')
            ->get();


        return new QuotationCollection($records);
    }
    public function columns()
    {
        return [
            'customer' => 'Cliente',
            'date_of_issue' => 'Fecha de emisión',
            'delivery_date' => 'Fecha de entrega',
            'seller_id' => 'Vendedor'
        ];
    }

    public function filter()
    {
        $sellers = Seller::where('establishment_id', auth()->user()->establishment_id)->get();
        $state_types = StateType::whereIn('id', ['01', '05', '09'])->get();

        return compact('state_types', 'sellers');
    }

    public function recordsCurrentUser(Request $request)
    {
        $customer_id = $request->customer_id;
        $date_of_issue = $request->date_of_issue;
        $records = Quotation::where('user_id', auth()->id());
        if ($customer_id) {
            $records->where('customer_id', $customer_id);
        }
        if ($date_of_issue) {
            $records->where('date_of_issue', $date_of_issue);
        }
        $records = $records->latest()
            ->orderBy('date_of_issue', 'desc');
        // $records = Quotation::where('user_id', auth()->id())->latest()
        // ->orderBy('date_of_issue', 'desc');

        return new QuotationCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function records(Request $request)
    {
        $records = $this->getRecords($request);

        return new QuotationCollection($records->paginate(config('tenant.items_per_page')));
    }

    private function getRecords($request)
    {

        if ($request->column == 'user_name') {

            $records = Quotation::whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->value}%");
            })
                ->whereTypeUser()
                ->latest();
        } else {

            $records = Quotation::where($request->column, 'like', "%{$request->value}%")
                ->whereTypeUser()
                ->latest();
        }

        return $records;
    }

    public function searchCustomers(Request $request)
    {

        $customers = Person::where('number', 'like', "%{$request->input}%")
            ->orWhere('name', 'like', "%{$request->input}%")
            ->orWhere('alias', 'like', "%{$request->input}%")
            ->whereType('customers')->orderBy('name')
            ->whereIsEnabled()
            ->get()->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => ($row->alias ? $row->alias . " - " : '') . $row->number . ' - ' . $row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'identity_document_type_id' => $row->identity_document_type_id,
                    'identity_document_type_code' => $row->identity_document_type->code
                ];
            });

        return compact('customers');
    }

    public function tables()
    {
        $customers = $this->table('customers');
        $sellers = Seller::where('establishment_id', auth()->user()->establishment_id)->get();
        $establishments = Establishment::where('id', auth()->user()->establishment_id)->get();
        $currency_types = CurrencyType::whereActive()->get();
        // $document_types_invoice = DocumentType::whereIn('id', ['01', '03'])->get();
        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->get();
        $charge_types = ChargeDiscountType::whereType('charge')->whereLevel('item')->get();
        $company = Company::active();
        $document_type_03_filter = config('tenant.document_type_03_filter');
        $payment_method_types = PaymentMethodType::orderBy('id', 'desc')->get();
        $payment_destinations = $this->getPaymentDestinations();

        return compact(
            'sellers',
            'customers',
            'establishments',
            'currency_types',
            'discount_types',
            'charge_types',
            'company',
            'document_type_03_filter',
            'payment_method_types',
            'payment_destinations'
        );
    }

    public function option_tables()
    {
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $series = Series::where('establishment_id', $establishment->id)->get();
        $document_types_invoice = DocumentType::whereIn('id', ['01', '03'])->get();
        $payment_method_types = PaymentMethodType::all();
        $payment_destinations = $this->getPaymentDestinations();

        return compact('series', 'document_types_invoice', 'payment_method_types', 'payment_destinations');
    }

    public function item_tables()
    {
        $items = $this->table('items');
        $categories = [];
        $affectation_igv_types = AffectationIgvType::whereActive()->get();
        $system_isc_types = SystemIscType::whereActive()->get();
        $price_types = PriceType::whereActive()->get();
        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->get();
        $charge_types = ChargeDiscountType::whereType('charge')->whereLevel('item')->get();
        $attribute_types = AttributeType::whereActive()->orderByDescription()->get();

        return compact('items', 'categories', 'affectation_igv_types', 'system_isc_types', 'price_types', 'discount_types', 'charge_types', 'attribute_types');
    }

    public function record($id)
    {
        $record = new QuotationResource(Quotation::findOrFail($id));

        return $record;
    }

    public function record2($id)
    {
        $record = new QuotationResource(Quotation::findOrFail($id));

        return $record;
    }


    public function getFullDescription($row)
    {

        $desc = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;
        $category = ($row->category) ? " - {$row->category->name}" : "";
        $brand = ($row->brand) ? " - {$row->brand->name}" : "";

        $desc = "{$desc} {$category} {$brand}";

        return $desc;
    }

    public function store(QuotationRequest $request)
    {

        DB::connection('tenant')->transaction(function () use ($request) {

            $data = $this->mergeData($request);
            $data['terms_condition'] = $this->getTermsCondition();
            $establishment_id = auth()->user()->establishment_id;
            $data['establishment_id'] = $establishment_id;
            $configuration = Configuration::firstOrFail();
            if ($configuration->consolidated_quotations) {
                $data['num_orden'] = Quotation::getOrdenNumber();
            }
            $this->quotation =  Quotation::create($data);

            foreach ($data['items'] as $row) {
                $row["percentage_igv"] = 18;
                $this->quotation->items()->create($row);
            }

            $this->savePayments($this->quotation, $data['payments']);

            $this->setFilename();
            $this->createPdf($this->quotation, "a4", $this->quotation->filename);
        });

        return [
            'success' => true,
            'data' => [
                'id' => $this->quotation->id,
                'number_full' => $this->quotation->number_full,
                'external_id' => $this->quotation->external_id,
            ],
        ];
    }

    public function update(QuotationRequest $request)
    {

        DB::connection('tenant')->transaction(function () use ($request) {
            // $data = $this->mergeData($request);
            // return $request['id'];
            $configuration = Configuration::select('terms_condition')->first();
            $request['terms_condition'] = $this->getTermsCondition();

            $this->quotation = Quotation::firstOrNew(['id' => $request['id']]);
            $this->quotation->fill($request->all());
            $this->quotation->items()->delete();

            $this->deleteAllPayments($this->quotation->payments);

            foreach ($request['items'] as $row) {

                $this->quotation->items()->create($row);
            }

            $this->savePayments($this->quotation, $request['payments']);

            $this->setFilename();
        });

        return [
            'success' => true,
            'data' => [
                'id' => $this->quotation->id,
            ],
        ];
    }

    private function getTermsCondition()
    {

        $configuration = Configuration::select('terms_condition')->first();

        if ($configuration) {
            return $configuration->terms_condition;
        }

        return null;
    }


    public function duplicate(Request $request)
    {
        // return $request->id;
        $obj = Quotation::find($request->id);
        $this->quotation = $obj->replicate();
        $this->quotation->external_id = Str::uuid()->toString();
        $this->quotation->state_type_id = '01';
        $this->quotation->save();

        foreach ($obj->items as $row) {
            $new = $row->replicate();
            $new->quotation_id = $this->quotation->id;
            $new->save();
        }

        $this->setFilename();

        return [
            'success' => true,
            'data' => [
                'id' => $this->quotation->id,
            ],
        ];
    }

    public function anular($id)
    {
        $obj =  Quotation::find($id);
        $obj->state_type_id = 11;
        $obj->save();
        return [
            'success' => true,
            'message' => 'Producto anulado con éxito'
        ];
    }

    public function mergeData($inputs)
    {

        $this->company = Company::active();
        $establishment_id = auth()->user()->establishment_id ?? $inputs['establishment_id'];
        $values = [
            'user_id' => auth()->id(),
            'external_id' => Str::uuid()->toString(),
            'customer' => PersonInput::set($inputs['customer_id']),
            'establishment' =>  EstablishmentInput::set($establishment_id),
            'soap_type_id' => $this->company->soap_type_id,
            'state_type_id' => '01'
        ];
        $inputs->merge($values);

        return $inputs->all();
    }



    private function setFilename()
    {

        $name = [$this->quotation->prefix, $this->quotation->id, date('Ymd')];
        $this->quotation->filename = join('-', $name);
        $this->quotation->save();
    }


    public function table($table)
    {
        switch ($table) {
            case 'customers':

                $customers = Person::whereType('customers')->whereIsEnabled()->orderBy('name')->take(20)->get()->transform(function ($row) {
                    return [
                        'id' => $row->id,
                        'description' => $row->number . ' - ' . $row->name,
                        'name' => $row->name,
                        'number' => $row->number,
                        'identity_document_type_id' => $row->identity_document_type_id,
                        'identity_document_type_code' => $row->identity_document_type->code
                    ];
                });
                return $customers;

                break;

            case 'items':

                $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();

                $items = Item::orderBy('description')->whereIsActive()
                    // ->with(['warehouses' => function($query) use($warehouse){
                    //     return $query->where('warehouse_id', $warehouse->id);
                    // }])
                    ->get()->transform(function ($row) {
                        $full_description = $this->getFullDescription($row);
                        // $full_description = ($row->internal_id)?$row->internal_id.' - '.$row->description:$row->description;
                        return [
                            'id' => $row->id,
                            'full_description' => $full_description,
                            'description' => $row->description,
                            'currency_type_id' => $row->currency_type_id,
                            'currency_type_symbol' => $row->currency_type->symbol,
                            'sale_unit_price' => $row->sale_unit_price,
                            'purchase_unit_price' => $row->purchase_unit_price,
                            'unit_type_id' => $row->unit_type_id,
                            'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                            'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                            'is_set' => (bool) $row->is_set,
                            'has_igv' => (bool) $row->has_igv,
                            'calculate_quantity' => (bool) $row->calculate_quantity,
                            'item_unit_types' => collect($row->item_unit_types)->transform(function ($row) {
                                return [
                                    'id' => $row->id,
                                    'description' => "{$row->description}",
                                    'item_id' => $row->item_id,
                                    'unit_type_id' => $row->unit_type_id,
                                    'quantity_unit' => $row->quantity_unit,
                                    'price1' => $row->price1,
                                    'price2' => $row->price2,
                                    'price3' => $row->price3,
                                    'price_default' => $row->price_default,
                                ];
                            }),
                            'warehouses' => collect($row->warehouses)->transform(function ($row) {
                                return [
                                    'warehouse_id' => $row->warehouse->id,
                                    'warehouse_description' => $row->warehouse->description,
                                    'stock' => $row->stock,
                                ];
                            })
                        ];
                    });
                return $items;

                break;
            default:
                return [];

                break;
        }
    }

    public function searchCustomerById($id)
    {

        $customers = Person::whereType('customers')
            ->where('id', $id)
            ->get()->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->number . ' - ' . $row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'identity_document_type_id' => $row->identity_document_type_id,
                    'identity_document_type_code' => $row->identity_document_type->code
                ];
            });

        return compact('customers');
    }

    public function download($external_id, $format)
    {
        $quotation = Quotation::where('external_id', $external_id)->first();

        if (!$quotation) throw new Exception("El código {$external_id} es inválido, no se encontro la cotización relacionada");

        $this->reloadPDF($quotation, $format, $quotation->filename);

        return $this->downloadStorage($quotation->filename, 'quotation');
    }

    public function toPrint($external_id, $format)
    {
        $quotation = Quotation::where('external_id', $external_id)->first();

        if (!$quotation) throw new Exception("El código {$external_id} es inválido, no se encontro la cotización relacionada");

        $this->reloadPDF($quotation, $format, $quotation->filename);
        $temp = tempnam(sys_get_temp_dir(), 'quotation');

        file_put_contents($temp, $this->getStorage($quotation->filename, 'quotation'));

        return response()->file($temp);
    }

    private function reloadPDF($quotation, $format, $filename)
    {
        $this->createPdf($quotation, $format, $filename);
    }

    public function createPdf($quotation = null, $format_pdf = null, $filename = null)
    {
        ini_set("pcre.backtrack_limit", "5000000");
        $template = new Template();
        $pdf = new Mpdf();

        $document = ($quotation != null) ? $quotation : $this->quotation;
        $company = ($this->company != null) ? $this->company : Company::active();
        $filename = ($filename != null) ? $filename : $this->quotation->filename;

        $configuration = Configuration::first();

        $base_template = $configuration->formats; //config('tenant.pdf_template');

        $html = $template->pdf($base_template, "quotation", $company, $document, $format_pdf);

        if ($format_pdf === 'ticket' or $format_pdf === 'ticket_80') {

            $width = 78;
            if (config('tenant.enabled_template_ticket_80')) $width = 76;

            $company_name      = (strlen($company->name) / 20) * 10;
            $company_address   = (strlen($document->establishment->address) / 30) * 10;
            $company_number    = $document->establishment->telephone != '' ? '10' : '0';
            $customer_name     = strlen($document->customer->name) > '25' ? '10' : '0';
            $customer_address  = (strlen($document->customer->address) / 200) * 10;
            $p_order           = $document->purchase_order != '' ? '10' : '0';

            $total_exportation = $document->total_exportation != '' ? '10' : '0';
            $total_free        = $document->total_free != '' ? '10' : '0';
            $total_unaffected  = $document->total_unaffected != '' ? '10' : '0';
            $total_exonerated  = $document->total_exonerated != '' ? '10' : '0';
            $total_taxed       = $document->total_taxed != '' ? '10' : '0';
            $quantity_rows     = count($document->items);
            $payments     = $document->payments()->count() * 5;
            $discount_global = 0;
            $terms_condition = $document->terms_condition ? 15 : 0;

            foreach ($document->items as $it) {
                if ($it->discounts) {
                    $discount_global = $discount_global + 1;
                }
            }
            $legends           = $document->legends != '' ? '10' : '0';

            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    $width,
                    120 +
                        ($quantity_rows * 8) +
                        ($discount_global * 3) +
                        $company_name +
                        $company_address +
                        $company_number +
                        $customer_name +
                        $customer_address +
                        $p_order +
                        $legends +
                        $total_exportation +
                        $total_free +
                        $total_unaffected +
                        $payments +
                        $total_exonerated +
                        $terms_condition +
                        $total_taxed
                ],
                'margin_top' => 2,
                'margin_right' => 6,
                'margin_bottom' => 0,
                'margin_left' => 2
            ]);
        } else if ($format_pdf === 'a5') {

            $company_name      = (strlen($company->name) / 20) * 10;
            $company_address   = (strlen($document->establishment->address) / 30) * 10;
            $company_number    = $document->establishment->telephone != '' ? '10' : '0';
            $customer_name     = strlen($document->customer->name) > '25' ? '10' : '0';
            $customer_address  = (strlen($document->customer->address) / 200) * 10;
            $p_order           = $document->purchase_order != '' ? '10' : '0';

            $total_exportation = $document->total_exportation != '' ? '10' : '0';
            $total_free        = $document->total_free != '' ? '10' : '0';
            $total_unaffected  = $document->total_unaffected != '' ? '10' : '0';
            $total_exonerated  = $document->total_exonerated != '' ? '10' : '0';
            $total_taxed       = $document->total_taxed != '' ? '10' : '0';
            $quantity_rows     = count($document->items);
            $discount_global = 0;
            foreach ($document->items as $it) {
                if ($it->discounts) {
                    $discount_global = $discount_global + 1;
                }
            }
            $legends           = $document->legends != '' ? '10' : '0';


            $alto = ($quantity_rows * 8) +
                ($discount_global * 3) +
                $company_name +
                $company_address +
                $company_number +
                $customer_name +
                $customer_address +
                $p_order +
                $legends +
                $total_exportation +
                $total_free +
                $total_unaffected +
                $total_exonerated +
                $total_taxed;
            $diferencia = 148 - (float)$alto;

            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    210,
                    $diferencia + $alto
                ],
                'margin_top' => 2,
                'margin_right' => 5,
                'margin_bottom' => 0,
                'margin_left' => 5
            ]);
        } else {



            $pdf_font_regular = config('tenant.pdf_name_regular');
            $pdf_font_bold = config('tenant.pdf_name_bold');

            if ($pdf_font_regular != false) {
                $defaultConfig = (new ConfigVariables())->getDefaults();
                $fontDirs = $defaultConfig['fontDir'];

                $defaultFontConfig = (new FontVariables())->getDefaults();
                $fontData = $defaultFontConfig['fontdata'];

                $default = [
                    'fontDir' => array_merge($fontDirs, [
                        app_path('CoreFacturalo' . DIRECTORY_SEPARATOR . 'Templates' .
                            DIRECTORY_SEPARATOR . 'pdf' .
                            DIRECTORY_SEPARATOR . $base_template .
                            DIRECTORY_SEPARATOR . 'font')
                    ]),
                    'fontdata' => $fontData + [
                        'custom_bold' => [
                            'R' => $pdf_font_bold . '.ttf',
                        ],
                        'custom_regular' => [
                            'R' => $pdf_font_regular . '.ttf',
                        ],
                    ]
                ];

                if ($base_template == 'citec') {
                    $default = [
                        'mode' => 'utf-8',
                        'margin_top' => 2,
                        'margin_right' => 0,
                        'margin_bottom' => 0,
                        'margin_left' => 0,
                        'fontDir' => array_merge($fontDirs, [
                            app_path('CoreFacturalo' . DIRECTORY_SEPARATOR . 'Templates' .
                                DIRECTORY_SEPARATOR . 'pdf' .
                                DIRECTORY_SEPARATOR . $base_template .
                                DIRECTORY_SEPARATOR . 'font')
                        ]),
                        'fontdata' => $fontData + [
                            'custom_bold' => [
                                'R' => $pdf_font_bold . '.ttf',
                            ],
                            'custom_regular' => [
                                'R' => $pdf_font_regular . '.ttf',
                            ],
                        ]
                    ];
                }

                $pdf = new Mpdf($default);
            }
        }

        $path_css = app_path('CoreFacturalo' . DIRECTORY_SEPARATOR . 'Templates' .
            DIRECTORY_SEPARATOR . 'pdf' .
            DIRECTORY_SEPARATOR . $base_template .
            DIRECTORY_SEPARATOR . 'style.css');

        $stylesheet = file_get_contents($path_css);

        $pdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
        $pdf->WriteHTML($html, HTMLParserMode::HTML_BODY);

        if ($format_pdf != 'ticket') {
            if (config('tenant.pdf_template_footer')) {

                $html_footer = $template->pdfFooter($base_template);
                $html_footer_term_condition = ($document->terms_condition) ? $template->pdfFooterTermCondition($base_template, $document) : "";

                $pdf->SetHTMLFooter($html_footer_term_condition . $html_footer);
            }
            //$html_footer = $template->pdfFooter();
            //$pdf->SetHTMLFooter($html_footer);
        }

        $this->uploadFile($filename, $pdf->output('', 'S'), 'quotation');
    }

    public function uploadFile($filename, $file_content, $file_type)
    {
        $this->uploadStorage($filename, $file_content, $file_type);
    }

    public function email(Request $request)
    {

        $client = Person::find($request->customer_id);
        $quotation = Quotation::find($request->id);
        $customer_email = $request->input('customer_email');

        // $this->reloadPDF($quotation, "a4", $quotation->filename);

        Mail::to($customer_email)->send(new QuotationEmail($client, $quotation));
        return [
            'success' => true
        ];
    }


    private function savePayments($quotation, $payments)
    {

        foreach ($payments as $payment) {

            $record_payment = $quotation->payments()->create($payment);

            if (isset($payment['payment_destination_id'])) {
                $this->createGlobalPayment($record_payment, $payment);
            }
        }
    }

    public function changed($id)
    {
        $record = Quotation::find($id);
        $record->changed = true;
        $record->save();

        return [
            'success' => true
        ];
    }

    public function updateStateType($state_type_id, $id)
    {
        $record = Quotation::find($id);
        $record->state_type_id = $state_type_id;
        $record->save();

        return [
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ];
    }

    public function anularDocument(Request $request)
    {
        try {
            $consolidated_quotations = Configuration::first()->consolidated_quotations;
            $quotation_id = isset($request->quotation_id) ? $request->quotation_id : null;
            if ($consolidated_quotations && $quotation_id) {
                $document = Document::where('quotation_id', $quotation_id)
                    ->where('state_type_id', '!=', '11')
                    ->first();
                if ($document) {
                    $state_type_id = $document->state_type_id;
                    if ($state_type_id == '05') {
                        $new_request = new Request();
                        $new_request->merge([
                            'summary_status_type_id' => 3,
                            'date_of_reference' => $document->date_of_issue,
                            'documents' => [
                                [
                                    'document_id' => $document->id,
                                    'description' => 'Anulación de la operación',
                                ]
                            ]
                        ]);
                        (new VoidedController)->store($new_request);
                    } else if ($state_type_id == '01') {
                        $response = (new DocumentController)->destroyDocument($document->id);
                    }
                }
                if (!$document) {
                    $document = SaleNote::where('quotation_id', $quotation_id)->first();
                    if ($document) {
                        $new_request = new Request();
                        (new SaleNoteController)->anulate($new_request, $document->id);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Documento anulado correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
