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
use App\Http\Resources\Tenant\ConsolidateQuotationCollection;
use Mpdf\Mpdf;
use Mpdf\HTMLParserMode;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuotationEmail;
use App\Models\Tenant\Cash;
use App\Models\Tenant\PaymentMethodType;
use Modules\Finance\Traits\FinanceTrait;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Consolidated;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\Seller;
use App\Models\Tenant\StateType;
use Carbon\Carbon;
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

    public function consolidatedsPrint($id)
    {
        $consolidated = Consolidated::find($id);
        $quotation_ids = $consolidated->quotations->pluck('id');
        foreach ($quotation_ids as $quotation_id) {
            event(new PrintEvent($quotation_id, "COT", true));
            sleep(2);
        }
        return [
            'success' => true,
            'message' => 'Impresión enviada a la cola de impresión'
        ];
    }
    public function consolidatedsExportDelivery($id)
    {
        $consolidated = Consolidated::with('quotations.items')->find($id);
        $quotations = $consolidated->quotations()->with(['person.zone'])->get();
        $count = $quotations->count();
        // Agrupar las cotizaciones por zonas
        $groupedQuotations = $quotations->groupBy(function ($quotation) {
            return $quotation->person->zone->description; // O el atributo que desees usar para agrupar
        });
        
        // Ejemplo de cómo podrías iterar sobre las cotizaciones agrupadas
        
        $quotationItems = $consolidated->quotations->flatMap(function ($quotation) {
            return $quotation->items;
        });

        $groupedItems = $quotationItems->groupBy(function ($item) {
            return $item->item_id ;
        });

        $transformedItems = $groupedItems->map(function ($items, $key) {
            $firstItem = $items->first();
            $itemData = $firstItem->item;
            $total = $items->sum('total');
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
            ];
        });
        return (new ConsolidatedExport())
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
            return $quotation->person->zone->description; // O el atributo que desees usar para agrupar
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
        $records = Consolidated::query();
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
    public function consolidated(Request $request)
    {


        $excludes = $request->excludes;
        $consolidated = new Consolidated();
        $consolidated->user_id = auth()->id();
        $consolidated->establishment_id = auth()->user()->establishment_id;
        $consolidated->date_of_issue = date('Y-m-d');
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
    public function toConsolidated()
    {
        $records = Quotation::where('consolidated', false)
        ->orderBy('id', 'desc');


        return new QuotationCollection($records->paginate(config('tenant.items_per_page')));
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
        $records = Quotation::where('user_id', auth()->id())->latest()
            ->orderBy('date_of_issue', 'desc');

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
}
