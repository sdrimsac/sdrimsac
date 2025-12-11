<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use Carbon\Carbon;
use App\Models\Tenant\Item;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Tenant\Person;
use App\Models\Tenant\Company;
use App\Models\Tenant\Purchase;
use App\Models\Tenant\SaleNote;

use App\Models\Tenant\Inventory;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\PurchaseItem;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\InventoryKardex;
use Modules\Item\Models\ItemLotsGroup;
use Modules\Inventory\Models\Warehouse;
use App\Models\Tenant\PaymentMethodType;
use Modules\Finance\Traits\FinanceTrait;
use App\Models\Tenant\Catalogs\PriceType;
use Modules\Purchase\Models\PurchaseOrder;
use Modules\Item\Models\ItemLot;

use App\Models\Tenant\Catalogs\CurrencyType;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Http\Requests\Tenant\PurchaseRequest;
use App\Models\Tenant\Catalogs\AttributeType;
use App\Models\Tenant\Catalogs\SystemIscType;
use App\Http\Resources\Tenant\PurchaseResource;
use App\Http\Resources\Tenant\PurchaseCollection;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Catalogs\ChargeDiscountType;
use App\Http\Requests\Tenant\PurchaseImportRequest;
use App\Http\Requests\Tenant\PurchaseFacturarRequest;
use App\CoreFacturalo\Requests\Inputs\Common\LegendInput;
use App\CoreFacturalo\Requests\Inputs\Common\PersonInput;
use App\CoreFacturalo\Template;
use App\Exports\PurchaseExport;
use App\Exports\PurchaseShoppingExport;
use App\Http\Resources\Tenant\PurchaseShoppingCollection;
use App\Imports\ItemColorSizeImport;
use App\Jobs\WhatsappSendMessageProccess;
use App\Models\Tenant\Box;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\ItemColorSize;
use App\Models\Tenant\ItemWarehousePrice;
use App\Services\ItemCodeService;
use App\Services\RoleService;
use App\Traits\JobReportTrait;
use Exception;
use Hyn\Tenancy\Models\Hostname;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Restaurant\Http\Controllers\CashTransferController;
use Modules\Restaurant\Models\CashStockMovement;
use Modules\Restaurant\Models\Food;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;


class PurchaseController extends Controller
{

    use FinanceTrait;
    use StorageDocument;
    use JobReportTrait;

    /**
     * Purchase instance used by some helper methods (e.g., createPdf).
     * Declared to avoid undefined property notices from static analysis.
     * @var \App\Models\Tenant\Purchase|null
     */
    protected $purchase = null;


    public function ne76_correlative()
    {
        //NE01
        $record = Purchase::where('document_type_id', 'NE76')->where('series', 'NE01')->orderBy('id', 'desc')->first();
        if (!$record) {
            return [
                'series' => 'NE01',
                'number' => '00000001'
            ];
        }
        $number = (int)$record->number + 1;
        return [
            'series' => 'NE01',
            'number' => str_pad($number, 8, '0', STR_PAD_LEFT)
        ];
    }
    public function index()
    {
        return view('tenant.purchases.index');
    }

    public function index_shopping()
    {
        return view('tenant.purchases.shopping');
    }


    public function create($purchase_order_id = null)
    {
        $is_arca = auth()->user()->is_arca;
        if (!$is_arca) {
            $is_arca = RoleService::isArcaUserId(auth()->id());
        }


        return view('tenant.purchases.form', compact('purchase_order_id', 'is_arca'));
    }

    public function columns()
    {
        return [
            'number' => 'Número',
            'date_of_issue' => 'Fecha de emisión',
            'date_of_due' => 'Fecha de vencimiento',
            'date_of_payment' => 'Fecha de pago',
            'name' => 'Nombre proveedor',
        ];
    }

    public function columnsShopping()
    {
        return [
            'number' => 'Número',
            'date_of_issue' => 'Fecha de emisión',
            'date_of_due' => 'Fecha de vencimiento',
            'date_of_payment' => 'Fecha de pago',
            'name' => 'Nombre proveedor',
        ];
    }

    public function exports($type = 'excel', Request $request)
    {
        $records = $this->records_export($request);

        return $this->excel($records);
    }
    function excel($records)
    {

        $company = Company::first();
        $establishment = Establishment::first();



        return (new PurchaseExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('ReporteKar' . Carbon::now() . '.xlsx');
    }
    function excelShopping(Request $request)
    {
        ini_set('memory_limit', '2048M');
        $records = $this->getRecordsShopping($request, false, true)->get();
        $company = Company::first();
        $establishment = Establishment::first();


        return (new PurchaseShoppingExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Reporte_productos_comprados' . Carbon::now() . '.xlsx');
    }
    public function records(Request $request)
    {

        $records = $this->getRecords($request);

        return new PurchaseCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function recordsShopping(Request $request)
    {

        $records = $this->getRecordsShopping($request);

        return new PurchaseShoppingCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function getRecords($request)
    {

        switch ($request->column) {
            case 'name':

                $records = Purchase::whereHas('suppliers', function ($query) use ($request) {
                    return $query->where($request->column, 'like', "%{$request->value}%");
                })
                    ->whereTypeUser()

                    ->latest();

                break;

            case 'date_of_payment':
                $records = Purchase::whereHas('purchase_payments', function ($query) use ($request) {
                    if ($request->end_date) {
                        return $query->whereBetween($request->column, [$request->value, $request->end_date]);
                    } else {
                        return $query->where($request->column, 'like', "%{$request->value}%");
                    }
                })
                    ->whereTypeUser()
                    ->latest();
                break;

            default:
                $records = Purchase::query();
                if ($request->end_date) {
                    $records = $records->whereBetween($request->column, [$request->value, $request->end_date]);
                } else {
                    $records = $records->where($request->column, 'like', "%{$request->value}%");
                }
                $records =
                    $records->whereTypeUser()
                    ->orderBy('id', 'desc')
                    ->latest();

                break;
        }
        // dd($request->column,$records->get());
        return $records;
    }

    public function recordsMobile(Request $request)
    {

        $records = $this->getRecordsMobile($request);

        return new PurchaseCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function getRecordsMobile($request)
    {
        $records = Purchase::query();

        if ($request->date_of_issue) {
            $records->where('date_of_issue', $request->date_of_issue);
        }

        $records->whereTypeUser()
            ->orderBy('id', 'desc')
            ->latest();

        return $records;
    }




    public function getRecordsShopping(Request $request)
    {
        $records = Purchase::query();

        if ($request->supplier_id) {
            $records = $records->where('supplier_id', $request->supplier_id);
        }
        if ($request->state_type_id) {
            $records = $records->where('state_type_id', $request->state_type_id);
        }
        if ($request->number) {
            $records = $records->where('number', $request->number);
        }
        if ($request->date_end && preg_match('/^\d{4}-\d{2}$/', $request->date_end)) {
            $startOfMonth = \Carbon\Carbon::createFromFormat('Y-m', $request->date_end)->startOfMonth()->toDateString();
            $endOfMonth = \Carbon\Carbon::createFromFormat('Y-m', $request->date_end)->endOfMonth()->toDateString();

            $records->whereBetween('date_of_issue', [$startOfMonth, $endOfMonth]);
        } elseif ($request->date_start || $request->date_end) {
            if ($request->date_start && $request->date_end) {
                $records->whereBetween('date_of_issue', [$request->date_start, $request->date_end]);
            } else {
                $records->where('date_of_issue', $request->date_start ?? $request->date_end);
            }
        }
        if ($request->series) {
            $records = $records->where('series', 'like', '%' . $request->series . '%');
        }
        if ($request->description) {
            $records = $records->whereHas('items', function ($query) use ($request) {
                $query->whereHas('item', function ($subQuery) use ($request) {
                    $subQuery->where('description', 'like', '%' . $request->description . '%');
                });
            });
        }
        if ($request->category_id) {
            $records = $records->whereHas('items', function ($query) use ($request) {
                $query->whereHas('relation_item', function ($q) use ($request) {
                    $q->where('category_id', $request->category_id);
                });
            });
        }

        switch ($request->column) {
            case 'name':
                if ($request->supplier_id) {
                    $records = $records->where('supplier_id', $request->supplier_id);
                } else {
                    $records = $records->whereHas('suppliers', function ($query) use ($request) {
                        return $query->where($request->column, 'like', "%{$request->value}%");
                    });
                }
                $records = $records->whereTypeUser()->latest();
                break;

            case 'date_of_payment':
                $records = $records->whereHas('purchase_payments', function ($query) use ($request) {
                    if ($request->end_date) {
                        return $query->whereBetween($request->column, [$request->value, $request->end_date]);
                    } else {
                        return $query->where($request->column, 'like', "%{$request->value}%");
                    }
                });
                if ($request->supplier_id) {
                    $records = $records->where('supplier_id', $request->supplier_id);
                }
                $records = $records->whereTypeUser()->latest();
                break;

            default:
                if ($request->end_date) {
                    $records = $records->whereBetween($request->column, [$request->value, $request->end_date]);
                } else {
                    $records = $records->where($request->column, 'like', "%{$request->value}%");
                }
                if ($request->supplier_id) {
                    $records = $records->where('supplier_id', $request->supplier_id);
                }
                $records = $records->whereTypeUser()
                    ->orderBy('id', 'desc')
                    ->latest();
                break;
        }

        return $records;
    }

    public function searchSupliers(Request $request)
    {
        // Get document type IDs based on document type and operation type
        $identity_document_type_id = $this->getIdentityDocumentTypeId($request->document_type_id, $request->operation_type_id);

        $credit_list = $request->credit_list;

        // Start query with suppliers filter
        $suppliers = Person::where('type', 'suppliers')
            ->where(function ($query) use ($request) {
                $query->where('number', 'like', "%{$request->input}%")
                    ->orWhere('name', 'like', "%{$request->input}%")
                    ->orWhere('alias', 'like', "%{$request->input}%");
            })
            ->whereIn('identity_document_type_id', $identity_document_type_id)
            ->whereIsEnabled();

        // Add credit filter if needed
        if ($credit_list) {
            $suppliers = $suppliers->where('has_credit_line', 1);
        }

        // Get and transform results
        $suppliers = $suppliers->orderBy('name')
            ->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => ($row->alias ? $row->alias . ' - ' : '') . $row->number . ' - ' . $row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'has_credit_line' => (bool) $row->has_credit_line,
                    'credit_line' => $row->credit_line,
                    'identity_document_type_id' => $row->identity_document_type_id,
                    'identity_document_type_code' => $row->identity_document_type->code,
                    'addresses' => $row->addresses,
                    'address' => $row->address
                ];
            });

        return compact('suppliers');
    }

    public function getIdentityDocumentTypeId($document_type_id, $operation_type_id)
    {

        if ($operation_type_id === '0101' || $operation_type_id === '1001') {
            if ($document_type_id == '01') {
                $identity_document_type_id = [6];
            } else {
                if (config('tenant.document_type_03_filter')) {
                    $identity_document_type_id = [1];
                } else {
                    $identity_document_type_id = [1, 4, 6, 7, 0];
                }
            }
        } else {
            $identity_document_type_id = [1, 4, 6, 7, 0];
        }

        return $identity_document_type_id;
    }

    public function tables()
    {
        $suppliers = $this->table('suppliers');
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $currency_types = CurrencyType::whereActive()->get();
        $document_types_invoice = DocumentType::whereIn('id', ['01', '03', 'GU75', 'NE76', '90'])->get();
        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->get();
        $charge_types = ChargeDiscountType::whereType('charge')->whereLevel('item')->get();
        $company = Company::active();
        // Obtener métodos de pago
        $payment_method_types = PaymentMethodType::where('has_card', 0)->get();

        $payment_destinations = $this->getPaymentDestinations() ?? [];
        $customers = $this->getPersons('customers');
        $configurations = Configuration::first();

        return compact(
            'suppliers',
            'establishment',
            'currency_types',
            'discount_types',
            'charge_types',
            'document_types_invoice',
            'company',
            'payment_method_types',
            'payment_destinations',
            'customers',
            'configurations'
        );
    }
    public function item_id()
    {
        //$items = $this->table('items');
        $items_data = Item::orderBy('description', 'asc')->get(); //whereWarehouse()
        $items = collect($items_data)->transform(function ($row) {
            $full_description = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;
            return [
                'id' => $row->id,
                'item_code'  => $row->item_code,
                'full_description' => $full_description,
                'description' => $row->description,
                'currency_type_id' => $row->currency_type_id,
                'currency_type_symbol' => $row->currency_type['symbol'],
                'sale_unit_price' => $row->sale_unit_price,
                'purchase_unit_price' => $row->purchase_unit_price,
                'unit_type_id' => $row->unit_type_id,
                'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                'has_perception' => (bool) $row->has_perception,
                'lots_enabled' => (bool) $row->lots_enabled,
                'percentage_perception' => $row->percentage_perception,
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
                'series_enabled' => (bool) $row->series_enabled,

            ];
        });
        return compact('items');
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
        $warehouses = Warehouse::all();

        return compact(
            'items',
            'categories',
            'affectation_igv_types',
            'system_isc_types',
            'price_types',
            'discount_types',
            'charge_types',
            'attribute_types',
            'warehouses'
        );
    }

    public function record($id)
    {

        $record = new PurchaseResource(Purchase::findOrFail($id));

        return $record;
    }

    public function edit($id)
    {
        $resourceId = $id;
        return view('tenant.purchases.form_edit', compact('resourceId'));
    }

    function records_export(Request $request)
    {

        switch ($request->column) {
            case 'name':

                $records = Purchase::whereHas('suppliers', function ($query) use ($request) {
                    return $query->where($request->column, 'like', "%{$request->value}%");
                })
                    ->whereTypeUser()

                    ->latest();

                break;

            case 'date_of_payment':
                $records = Purchase::whereHas('purchase_payments', function ($query) use ($request) {
                    if ($request->end_date) {
                        return $query->whereBetween($request->column, [$request->value, $request->end_date]);
                    } else {
                        return $query->where($request->column, 'like', "%{$request->value}%");
                    }
                })
                    ->whereTypeUser()
                    ->latest();
                break;

            default:
                $records = Purchase::query();
                if ($request->end_date) {
                    $records = $records->whereBetween($request->column, [$request->value, $request->end_date]);
                } else {
                    $records = $records->where($request->column, 'like', "%{$request->value}%");
                }
                $records =
                    $records->whereTypeUser()
                    ->orderBy('id', 'desc')
                    ->latest();

                break;
        }
        return $records->get();
    }

    public function store(PurchaseRequest $request)
    {
        $has_error = false;
        $message = '';
        $data = self::convert($request);

        $purchase = DB::connection('tenant')->transaction(function () use ($data, &$has_error, &$message) {
            try {
                $series = $data['series'];
                $number = $data['number'];

                // Validar duplicidad del documento
                $purchase = Purchase::where('series', $series)
                    ->where('number', $number)
                    ->where('document_type_id', 'NE76')
                    ->first();

                if ($purchase) {
                    $has_error = true;
                    $message = "El documento {$series}-{$number} ya ha sido registrado.";
                    throw new Exception($message);
                }

                $doc = Purchase::create($data);

                // --- Crear items, color_size y lots ---
                foreach ($data['items'] as $row) {
                    $unit_price = floatval($row['unit_price']);
                    $p_item = new PurchaseItem;
                    $p_item->fill($row);
                    $p_item->purchase_id = $doc->id;
                    $p_item->save();

                    $item = Item::findOrFail($row['item_id']);

                    if (isset($row['sale_unit_price']) && $row['sale_unit_price'] != 0 && $row['sale_unit_price'] != null) {
                        $item->sale_unit_price = $row['sale_unit_price'];
                        Food::where('item_id', $row['item_id'])->update(['price' => $row['sale_unit_price']]);
                        ItemWarehousePrice::where('item_id', $row['item_id'])
                            ->where('warehouse_id', $doc->establishment_id)->update(['price' => $row['sale_unit_price']]);
                    }

                    /* aqui si la affectation_igv_type_id = 10 el unit_price lo debe multiplicar por 1.18 aho si es 20 ahi si no*/
                    if ($row['affectation_igv_type_id'] == 10) {
                        $unit_price *= 1.18;
                    }

                    if ($unit_price != floatval($item->purchase_unit_price)) {
                        $item->purchase_unit_price = $unit_price;
                    }

                    $item->purchase_affectation_igv_type_id = $row['affectation_igv_type_id'];
                    $item->save();

                    ItemCodeService::generateCodesForItemWarehouse($item->id, $row['warehouse_id']);

                    // Color/Size
                    if (array_key_exists('color_size', $row)) {
                        foreach ($row['color_size'] as $color_size) {
                            // Validar que el code sea único para el item y almacén
                            $code_exists = ItemColorSize::where('item_id', $row['item_id'])
                                ->where('warehouse_id', $row['warehouse_id'])
                                ->where('code', $color_size['code'])
                                ->first();
                            if ($code_exists) {
                                $message = "El código '{$color_size['code']}' ya existe para este item y almacén.";
                                throw new Exception($message);
                            }
                            $color_size_exists = ItemColorSize::where('item_id', $row['item_id'])
                                ->where('warehouse_id', $row['warehouse_id'])
                                ->where('color', $color_size['color'])
                                ->where('size', $color_size['size'])
                                ->first();
                            if ($color_size_exists) {
                                $color_size_exists->stock += $color_size['stock'];
                                if (!empty($color_size['code']) && strpos($color_size_exists->code, $color_size['code']) === false) {
                                    $color_size_exists->code .= '-' . $color_size['code'];
                                }
                                if (!empty($color_size['price']) && $color_size['price'] != 0) {
                                    $color_size_exists->price = $color_size['price'];
                                }
                                $color_size_exists->save();
                            } else {
                                $item->color_size()->create([
                                    'item_id' => $row['item_id'],
                                    'warehouse_id' => $row['warehouse_id'],
                                    'color' => $color_size['color'],
                                    'code' => $color_size['code'],
                                    'price' => $color_size['price'],
                                    'size' => $color_size['size'],
                                    'stock' => $color_size['stock'],
                                ]);
                            }
                        }
                    }

                    // Lots
                    if (array_key_exists('lots', $row)) {
                        foreach ($row['lots'] as $lot) {
                            $item_lot = ItemLot::where('series', $lot['series'])
                                ->where('item_id', $row['item_id'])
                                ->whereRaw('LENGTH(series) = ?', [strlen($lot['series'])])
                                ->first();
                            if ($item_lot) {
                                $message = "La serie {$lot['series']} ya existe en el sistema";
                                throw new Exception($message);
                            }
                            $p_item->lots()->create([
                                'date' => $lot['date'],
                                'series' => $lot['series'],
                                'item_id' => $row['item_id'],
                                'warehouse_id' => $row['warehouse_id'],
                                'has_sale' => false,
                                'state' => $lot['state']
                            ]);
                        }
                    }

                    // Lots group
                    if (array_key_exists('item', $row) && $row['item']['lots_enabled'] == true) {
                        if (isset($row['lot_code'])) {
                            ItemLotsGroup::create([
                                'code' => $row['lot_code'],
                                'quantity' => $row['quantity'],
                                'date_of_due' => $row['date_of_due'],
                                'item_id' => $row['item_id'],
                                'warehouse_id' => $row['warehouse_id'],
                            ]);
                        }
                        if (!empty($row['item']['lots_group'])) {
                            foreach ($row['item']['lots_group'] as $lot) {
                                ItemLotsGroup::create([
                                    'code' => $lot['code'],
                                    'quantity' => $lot['quantity'],
                                    'date_of_due' => $lot['date_of_due'],
                                    'item_id' => $row['item_id'],
                                    'warehouse_id' => $row['warehouse_id'],
                                ]);
                            }
                        }
                    }
                }

                $isArca = false;
                $configuration = Configuration::first();
                if ($configuration->methods_arca_cash) {
                    $isArca = auth()->user()->is_arca == 1;
                    $arcaCash = null;
                    if ($isArca) {
                        $arcaCash = Cash::where('user_id', auth()->id())
                            ->where('state', 1)
                            ->latest()
                            ->first();

                        if (!$arcaCash) {
                            throw new Exception("No tiene caja aperturada.");
                        }

                        $totalCompra = $doc->total;
                        $payments = $data['payments'] ?? [];
                        // Si purchase_credit está activado, permite la compra a crédito aunque no haya pagos
                        if ($configuration->purchase_credit) {
                            // Si hay pagos enviados, validar que el total coincida y validar saldo
                            if (!empty($payments)) {
                                $totalEnviado = collect($payments)->sum('payment');
                                if ($totalEnviado != $totalCompra) {
                                    throw new Exception("El total de los pagos enviados (S/{$totalEnviado}) no coincide con el total de la compra (S/{$totalCompra}).");
                                }
                                foreach ($payments as $index => $payment) {
                                    $payment_method = null;
                                    $boxData = $data['boxes'][$index] ?? null;
                                    if (!empty($payment['payment_method_type_id'])) {
                                        $payment_method = PaymentMethodType::find($payment['payment_method_type_id']);
                                    } else {
                                        Log::warning('payment_method_type_id ausente en payment, se intentará derivar desde boxData', [
                                            'index' => $index,
                                            'payment' => $payment,
                                            'boxData' => $boxData
                                        ]);
                                    }
                                    if (is_array($boxData) && !empty($boxData['method'])) {
                                        $methodName = $boxData['method'];
                                    } elseif (is_object($boxData) && property_exists($boxData, 'method') && !empty($boxData->method)) {
                                        $methodName = $boxData->method;
                                    } else {
                                        $methodName = $payment_method ? $payment_method->description : null;
                                    }
                                    if (!$payment_method && !empty($methodName)) {
                                        $payment_method = PaymentMethodType::where('description', $methodName)->first();
                                        if ($payment_method) {
                                            Log::info('Se resolvió payment_method_type por descripción', [
                                                'index' => $index,
                                                'methodName' => $methodName,
                                                'payment_method_id' => $payment_method->id
                                            ]);
                                        }
                                    }
                                    if (!$payment_method && !empty($methodName) && stripos($methodName, 'CUENTA') !== false) {
                                        $payment_method = PaymentMethodType::find('01'); // Efectivo
                                        Log::info('Se asignó payment_method_type_id=01 por defecto al tratarse de cuenta bancaria', [
                                            'index' => $index,
                                            'methodName' => $methodName
                                        ]);
                                    }
                                    $methodToQuery = $payment_method ? $payment_method->description : $methodName;
                                    if (empty($methodToQuery)) {
                                        Log::error('No se pudo determinar el método de pago para validar saldo disponible', [
                                            'index' => $index,
                                            'payment' => $payment,
                                            'boxData' => $boxData
                                        ]);
                                        throw new Exception("Método de pago no encontrado al validar saldo disponible.");
                                    }
                                    $saldoDisponible = Box::where('cash_id', $arcaCash->id)
                                        ->where('method', $methodToQuery)
                                        ->selectRaw("
                                SUM(
                                    CASE
                                        WHEN type = 1 THEN amount
                                        WHEN type = 2 THEN -amount
                                        ELSE 0
                                    END
                                ) as saldo
                            ")
                                        ->value('saldo') ?? 0;
                                    if ($saldoDisponible < $payment['payment']) {
                                        $faltante = number_format($payment['payment'] - $saldoDisponible, 2);
                                        throw new Exception("Saldo insuficiente en {$methodToQuery}. Faltan S/ {$faltante}. Puede usar otro método de pago con fondos para completar la compra.");
                                    }
                                }
                            }
                            // Si no hay pagos, permite la compra a crédito sin validar pagos ni saldo
                        } else {
                            // purchase_credit desactivado: lógica normal
                            $totalEnviado = collect($payments)->sum('payment');
                            if ($totalEnviado != $totalCompra) {
                                throw new Exception("El total de los pagos enviados (S/{$totalEnviado}) no coincide con el total de la compra (S/{$totalCompra}).");
                            }
                            foreach ($payments as $index => $payment) {
                                $payment_method = null;
                                $boxData = $data['boxes'][$index] ?? null;
                                if (!empty($payment['payment_method_type_id'])) {
                                    $payment_method = PaymentMethodType::find($payment['payment_method_type_id']);
                                } else {
                                    Log::warning('payment_method_type_id ausente en payment, se intentará derivar desde boxData', [
                                        'index' => $index,
                                        'payment' => $payment,
                                        'boxData' => $boxData
                                    ]);
                                }
                                if (is_array($boxData) && !empty($boxData['method'])) {
                                    $methodName = $boxData['method'];
                                } elseif (is_object($boxData) && property_exists($boxData, 'method') && !empty($boxData->method)) {
                                    $methodName = $boxData->method;
                                } else {
                                    $methodName = $payment_method ? $payment_method->description : null;
                                }
                                if (!$payment_method && !empty($methodName)) {
                                    $payment_method = PaymentMethodType::where('description', $methodName)->first();
                                    if ($payment_method) {
                                        Log::info('Se resolvió payment_method_type por descripción', [
                                            'index' => $index,
                                            'methodName' => $methodName,
                                            'payment_method_id' => $payment_method->id
                                        ]);
                                    }
                                }
                                if (!$payment_method && !empty($methodName) && stripos($methodName, 'CUENTA') !== false) {
                                    $payment_method = PaymentMethodType::find('01'); // Efectivo
                                    Log::info('Se asignó payment_method_type_id=01 por defecto al tratarse de cuenta bancaria', [
                                        'index' => $index,
                                        'methodName' => $methodName
                                    ]);
                                }
                                $methodToQuery = $payment_method ? $payment_method->description : $methodName;
                                if (empty($methodToQuery)) {
                                    Log::error('No se pudo determinar el método de pago para validar saldo disponible', [
                                        'index' => $index,
                                        'payment' => $payment,
                                        'boxData' => $boxData
                                    ]);
                                    throw new Exception("Método de pago no encontrado al validar saldo disponible.");
                                }
                                $saldoDisponible = Box::where('cash_id', $arcaCash->id)
                                    ->where('method', $methodToQuery)
                                    ->selectRaw("
                                SUM(
                                    CASE
                                        WHEN type = 1 THEN amount
                                        WHEN type = 2 THEN -amount
                                        ELSE 0
                                    END
                                ) as saldo
                            ")
                                    ->value('saldo') ?? 0;
                                if ($saldoDisponible < $payment['payment']) {
                                    $faltante = number_format($payment['payment'] - $saldoDisponible, 2);
                                    throw new Exception("Saldo insuficiente en {$methodToQuery}. Faltan S/ {$faltante}. Puede usar otro método de pago con fondos para completar la compra.");
                                }
                            }
                        }
                    }
                }

                /* para mostrar compra en reporte de caja de las recetas */

                /* if ($items = $data['items'] ?? false) { */
                    foreach ($data['items'] as $row) {

                        Log::info('Procesando item de compra para posible CashStockMovementdasdasfdsfsdfsdfsdf');
                        $init_report = null;
                        // Determinar flag init_report (puede venir en row['item'] o en row directamente)
                        if (isset($row['item']) && is_array($row['item']) && array_key_exists('init_report', $row['item'])) {
                            $init_report = $row['item']['init_report'];
                            Log::info('init_report encontrado en row[item] gffgadasdfd4fsdfsdsd', ['init_report' => $init_report]);
                        } elseif (array_key_exists('init_report', $row)) {
                            $init_report = $row['init_report'];
                            Log::info('init_report encontrado en row fcdgasdasdasd', ['init_report' => $init_report]);
                        }

                        if ($init_report == 1) {

                            Log::info('Procesando item para CashStockMovement vcdvcxvxcvxcxvx');
                           
                            $cashToUse = (isset($arcaCash) && $arcaCash) ? $arcaCash : Cash::where('user_id', auth()->id())->where('state', 1)->latest()->first();
                            if (!$cashToUse) {
                                $cashToUse = Cash::where('state', 1)->latest()->first();
                            }

                            // Resolución defensiva del item_id (puede venir en diferentes formas)
                            $item_id = null;
                            if (!empty($row['item_id'])) {
                                $item_id = $row['item_id'];
                            } elseif (!empty($row['item']['id'])) {
                                $item_id = $row['item']['id'];
                            } elseif (!empty($row['item']['item_id'])) {
                                $item_id = $row['item']['item_id'];
                            }

                            $quantity = $row['quantity'] ?? 0;
                            $warehouse_id = $row['warehouse_id'] ?? null;

                            if (!$cashToUse) {
                                Log::warning('No se encontró caja abierta para registrar CashStockMovement', ['item_id' => $item_id]);
                                continue; // saltar este item
                            }

                            if (empty($item_id) || $quantity <= 0) {
                                Log::warning('Datos inválidos para registrar CashStockMovement', ['item' => $row]);
                                continue;
                            }

                            $cash_id = $cashToUse->id;

                            // Buscar por caja, item y almacén (si existe). Usar firstOrNew para garantizar creación o actualización atómica.
                            $movement = CashStockMovement::firstOrNew([
                                'cash_id' => $cash_id,
                                'item_id' => $item_id,
                                'warehouse_id' => $warehouse_id,
                            ]);
                            Log::info('Registrando CashStockMovement', [
                                'cash_id' => $cash_id,
                                'item_id' => $item_id,
                                'warehouse_id' => $warehouse_id,
                                'quantity' => $quantity,
                                'existing_movement_id' => $movement->id ?? null
                            ]);

                            // Asegurar valores numéricos
                            $movement->purchases = ($movement->purchases ?? 0) + $quantity;
                            $movement->current_stock = ($movement->current_stock ?? 0) + $quantity;
                            $movement->movement_type = $movement->movement_type ?? 'purchase';
                            // Si es un nuevo registro, inicializar otros campos
                            if (!$movement->exists) {
                                $movement->initial_stock = $movement->initial_stock ?? 0;
                                $movement->sold_quantity = $movement->sold_quantity ?? 0;
                            }
                            $movement->save();
                        }
                    }
                /* } */


                // Si purchase_credit está activado (true), NO se registran pagos ni egresos
                // La compra queda como pendiente (a crédito)
                if (!$configuration->purchase_credit) {
                    // Lógica normal: registrar pagos y egresos en Box
                    foreach ($data['payments'] as $index => $payment) {
                        $payment['payment_method_type_id'] = $payment['payment_method_type_id'] ?? '01';
                        $record_payment = $doc->purchase_payments()->create($payment);

                        if ($configuration->methods_arca_cash && $isArca) {
                            // Tomar la caja abierta
                            $box = Box::where('cash_id', $arcaCash->id)
                                ->where('state', 1)
                                ->where('type', 1)
                                ->orderBy('id')
                                ->first();

                            if (!$box) {
                                throw new Exception("No hay saldo disponible en la caja para realizar la compra.");
                            }

                            // Obtenemos método de pago
                            $payment_method = PaymentMethodType::find($payment['payment_method_type_id']);

                            // Revisamos si vino el dato desde el frontend
                            $boxData = $data['boxes'][$index] ?? null;
                            Log::info('Box Data', ['index' => $index, 'boxData' => $boxData, 'payment' => $payment, 'payment_method' => $payment_method]);

                            // Determinar nombre del método de pago de forma defensiva
                            if (is_array($boxData) && !empty($boxData['method'])) {
                                $methodName = $boxData['method'];
                            } elseif (is_object($boxData) && property_exists($boxData, 'method') && !empty($boxData->method)) {
                                $methodName = $boxData->method;
                            } else {
                                $methodName = $payment_method ? $payment_method->description : 'Método no encontrado';
                            }

                            // Registrar movimiento en la caja (egreso)
                            Box::create([
                                'cash_id' => $arcaCash->id,
                                'date' => $record_payment->date_of_payment,
                                'amount' => $payment['payment'],
                                'expenses' => 1,
                                'group_id' => 2,
                                'category_id' => 2,
                                'subcategory_id' => 1,
                                'state' => 1,
                                'type' => 2, // Egreso
                                'soap_type_id' => Company::active()->soap_type_id,
                                'user_id' => auth()->id(),
                                'description' => "Compra realizada con el número de documento {$doc->series}-{$doc->number} descontada del arca para el método de pago ({$methodName})",
                                'purchase_id' => $doc->id,
                                'currency_type_id' => $doc->currency_type_id,
                                'method' => $methodName,
                            ]);
                        }

                        if (isset($payment['payment_destination_id'])) {
                            $this->createGlobalPayment($record_payment, $payment);
                        }
                    }
                }


                // --- Envío WhatsApp si aplica ---

                if ($configuration->sale_note_credit_penalty && $isArca) {
                    $total = (new CashTransferController)->available();
                    if ($total > 0) {
                        $date = date('Y-m-d');
                        $time_now = date('H:i:s');
                        $total_with_purchase = $total + $doc->total;
                        $message = "El usuario arca - administrador hasta la fecha {$doc->created_at->format('Y-m-d')} / {$doc->created_at->format('H:i:s')} contaba con monto de S/{$total_with_purchase} y ha realizado una compra por un monto de S/{$doc->total}, quedando un saldo a favor de S/{$total}";
                        $website = $this->getTenantWebsite();
                        WhatsappSendMessageProccess::dispatch($website->id, $message, null, null, $doc->establishment_id);
                    }
                }
                

                // Generar PDF
                if (!$doc->filename) {
                    $this->setFilename($doc);
                }
                $this->createPdf($doc, "a4", $doc->filename);

                return $doc;
            } catch (Exception $e) {
                DB::connection('tenant')->rollBack();
                $has_error = true;
                $message = $e->getMessage();
                return null;
            }
        });

        if ($has_error) {
            return [
                'success' => false,
                'message' => $message,
            ];
        }

        $number_full = $request->series_guia && $request->number_guia
            ? $request->series_guia . "-" . $request->number_guia
            : $purchase->series . "-" . $purchase->number;

        return [
            'success' => true,
            'data' => [
                'id' => $purchase->id,
                'number_full' => "{$number_full}",
            ],
        ];
    }

    /*public function store(PurchaseRequest $request)
    {
        $has_error = false;
        $message = '';
        $data = self::convert($request);
        $purchase = DB::connection('tenant')->transaction(function () use ($data, &$has_error, &$message) {
            try {
                //DB::connection('tenant')->beginTransaction();
                $series = $data['series'];
                $number = $data['number'];
                $purchase = Purchase::where('series', $series)
                    ->where('number', $number)
                    ->where('document_type_id', 'NE76')
                    ->first();
                if ($purchase) {
                    $has_error = true;
                    $message = "El documento {$series}-{$number} ya ha sido registrado.";
                    throw new Exception($message);
                }
                $doc = Purchase::create($data);
                foreach ($data['items'] as $row) {
                    $unit_price = floatval($row['unit_price']);
                    $p_item = new PurchaseItem;
                    $p_item->fill($row);
                    $p_item->purchase_id = $doc->id;
                    $p_item->save();
                    $item = Item::findOrFail($row['item_id']);
                    if (isset($row['sale_unit_price']) && $row['sale_unit_price'] != 0 && $row['sale_unit_price'] != null) {
                        $item->sale_unit_price = $row['sale_unit_price'];
                        Food::where('item_id', $row['item_id'])->update(['price' => $row['sale_unit_price']]);
                        ItemWarehousePrice::where('item_id', $row['item_id'])
                            ->where('warehouse_id', $doc->establishment_id)->update(['price' => $row['sale_unit_price']]);
                    }
                    $purchase_unit_price_item = floatval($item->purchase_unit_price);
                    if ($unit_price != $purchase_unit_price_item) {
                        $item->purchase_unit_price = $unit_price;
                    }
                    $item->purchase_affectation_igv_type_id = $row['affectation_igv_type_id'];
                    $item->save();

                    ItemCodeService::generateCodesForItemWarehouse($item->id, $row['warehouse_id']);

                    if (array_key_exists('color_size', $row)) {
                        foreach ($row['color_size'] as $color_size) {

                            $color_size_exists = ItemColorSize::where('item_id', $row['item_id'])
                                ->where('warehouse_id', $row['warehouse_id'])
                                ->where('code', $color_size['code'])
                                ->where('color', $color_size['color'])
                                ->where('size', $color_size['size'])
                                ->first();
                            if ($color_size_exists) {
                                $color_size_exists->stock += $color_size['stock'];

                                if (!empty($color_size['code'])) {

                                    if (strpos($color_size_exists->code, $color_size['code']) === false) {
                                        $color_size_exists->code .= '-' . $color_size['code'];
                                    }
                                }

                                $price = $color_size['price'];
                                if ($price !== 0 && ($price !== null && $price !== '')) {
                                    $color_size_exists->price = $price;
                                }

                                $color_size_exists->save();
                            } else {
                                $item->color_size()->create([
                                    'item_id' => $row['item_id'],
                                    'warehouse_id' => $row['warehouse_id'],
                                    'color' => $color_size['color'],
                                    'code' => $color_size['code'],
                                    'price' => $color_size['price'],
                                    'size' => $color_size['size'],
                                    'stock' => $color_size['stock'],
                                ]);
                            }
                        }
                    }
                    if (array_key_exists('lots', $row)) {
                        foreach ($row['lots'] as $lot) {
                            $item_lot = ItemLot::where('series', $lot['series'])
                                ->where('item_id', $row['item_id'])
                                ->whereRaw('LENGTH(series) = ?', [strlen($lot['series'])])
                                ->first();

                            if ($item_lot) {
                                $message = "La serie {$lot['series']} ya existe en el sistema";
                                throw new Exception($message);
                            }

                            $p_item->lots()->create([
                                'date' => $lot['date'],
                                'series' => $lot['series'],
                                'item_id' => $row['item_id'],
                                'warehouse_id' => $row['warehouse_id'],
                                'has_sale' => false,
                                'state' => $lot['state']
                            ]);
                        }
                    }

                    if (array_key_exists('item', $row)) {
                        if ($row['item']['lots_enabled'] == true) {
                            if (isset($row['lot_code'])) {
                                ItemLotsGroup::create([
                                    'code' => $row['lot_code'],
                                    'quantity' => $row['quantity'],
                                    'date_of_due' => $row['date_of_due'],
                                    'item_id' => $row['item_id'],
                                    'warehouse_id' => $row['warehouse_id'],
                                ]);
                            }
                            $lots = $row['item']['lots_group'];
                            if (count($lots) > 0) {
                                foreach ($lots as $lot) {
                                    ItemLotsGroup::create([
                                        'code' => $lot['code'],
                                        'quantity' => $lot['quantity'],
                                        'date_of_due' => $lot['date_of_due'],
                                        'item_id' => $row['item_id'],
                                        'warehouse_id' => $row['warehouse_id'],
                                    ]);
                                }
                            }
                        }
                    }
                }

                // Check if user is admin or superadmin
                $isAdminOrSuperadmin = in_array(auth()->user()->type, ['admin', 'superadmin']);

                // Get cash only for non-admin users
                $cash = $isAdminOrSuperadmin ? true : Cash::where('user_id', auth()->id())
                    ->where('state', 1)
                    ->latest()
                    ->first();

                $company = Company::active();
                $soap_type_id = $company->soap_type_id;
                $last_box = null;
                $time_box = null;
                $date_box = null;

                if ($cash && !$isAdminOrSuperadmin) {
                    $last_box = Box::where('cash_id', $cash->id)->latest()->first();
                    $time_box = $last_box ? $last_box->created_at->format('H:i:s') : date('H:i:s');
                    $date_box = $last_box ? $last_box->date : date('Y-m-d');
                }

                if (count($data['payments']) > 0 && !$cash && !$isAdminOrSuperadmin) {
                    $has_error = true;
                    $message = "No se puede realizar la compra, no tiene caja aperturada";
                    throw new Exception($message);
                }

                        foreach ($data['payments'] as $index => $payment) {

                            // buscar el método de pago en la tabla PaymentMethodType si viene el id
                            $payment_method = null;
                            $boxData = $data['boxes'][$index] ?? null;

                            if (!empty($payment['payment_method_type_id'])) {
                                $payment_method = PaymentMethodType::find($payment['payment_method_type_id']);
                            } else {
                                // loguear que no vino el id para facilitar debugging del frontend
                                Log::warning('payment_method_type_id ausente en payment, se intentará derivar desde boxData', ['index' => $index, 'payment' => $payment, 'boxData' => $boxData]);
                            }

                            // Determinar nombre del método de pago (priorizar dato enviado por frontend en boxes)
                            if (is_array($boxData) && !empty($boxData['method'])) {
                                $methodName = $boxData['method'];
                            } elseif (is_object($boxData) && property_exists($boxData, 'method') && !empty($boxData->method)) {
                                $methodName = $boxData->method;
                            } else {
                                $methodName = $payment_method ? $payment_method->description : null;
                            }

                            // Si no encontramos el PaymentMethodType por id, intentar buscar por descripción
                            if (!$payment_method && !empty($methodName)) {
                                $payment_method = PaymentMethodType::where('description', $methodName)->first();
                                if ($payment_method) {
                                    Log::info('Se resolvió payment_method_type por descripción', ['index' => $index, 'methodName' => $methodName, 'payment_method_id' => $payment_method->id]);
                                }
                            }

                            // Determinar cadena a usar para consultar el saldo en boxes
                            $methodToQuery = $payment_method ? $payment_method->description : $methodName;

                            if (empty($methodToQuery)) {
                                // No se puede determinar método de pago para validar saldo
                                Log::error('No se pudo determinar el método de pago para validar saldo disponible', ['index' => $index, 'payment' => $payment, 'boxData' => $boxData]);
                                throw new Exception("Método de pago no encontrado al validar saldo disponible.");
                            }

                            // saldo disponible en esa caja y método (usando la descripción/etiqueta del método)
                            $saldoDisponible = Box::where('cash_id', $arcaCash->id)
                                ->where('method', $methodToQuery)
                                ->selectRaw("\n                                            SUM(\n                                                CASE \n                                                    WHEN type = 1 THEN amount \n                                                    WHEN type = 2 THEN -amount \n                                                    ELSE 0 \n                                                END\n                                            ) as saldo\n                                        ")
                                ->value('saldo') ?? 0;

                            // validar saldo
                            if ($saldoDisponible < $payment['payment']) {
                                $faltante = number_format($payment['payment'] - $saldoDisponible, 2);
                                throw new Exception("Saldo insuficiente en {$methodToQuery}. Faltan S/ {$faltante}. Puede usar otro método de pago con fondos para completar la compra.");
                            }
                        }
                    $this->setFilename($doc);
                }

                $configuration = Configuration::first();
                if ($configuration->sale_note_credit_penalty && $cash && !$isAdminOrSuperadmin) {
                    $total = (new CashTransferController)->available();
                    if ($total > 0) {
                        $date = date('Y-m-d');
                        $time_box = $time_box;
                        $time_now = date('H:i:s');
                        $total_with_purchase = $total + $doc->total;
                        $message = "El usuario arca - administrador hasta la fecha {$date_box} / {$time_box} contaba con monto de S/{$total_with_purchase} y ha realizado una compra el {$date} a las {$time_now} por un monto de S/{$doc->total}, quedando un saldo a favor de S/{$total}";
                        $website = $this->getTenantWebsite();
                        WhatsappSendMessageProccess::dispatch($website->id, $message, null, null, $doc->establishment_id);
                    }
                }

                DB::connection('tenant')->commit();
                $this->createPdf($doc, "a4", $doc->filename);

                return $doc;
            } catch (Exception $e) {
                DB::connection('tenant')->rollBack();
                $has_error = true;
                $message = $e->getMessage();
                return null;
            }
        });

        if ($has_error) {
            return [
                'success' => false,
                'message' => $message,
            ];
        }

        if ($request->number_guia != null || $request->series_guia != null) {
            $number_full = $request->series_guia . "-" . $request->number_guia;
        } else {
            $number_full = $purchase->series . "-" . $purchase->number;
        }

        return [
            'success' => true,
            'data' => [
                'id' => $purchase->id,
                'number_full' => "{$number_full}",
            ],
        ];
    }*/

    public function toPrinter($id)
    {
        $purchase = Purchase::where('id', $id)->first();

        if (!$purchase) {
            throw new Exception("El código {$id} es inválido, no se encontró el pedido relacionado");
        }

        if (empty($purchase->filename)) {
            throw new Exception("El pedido {$id} no tiene un nombre de archivo asignado.");
        }

        $databaseName = config('database.connections.tenant.database');
        $tenantDirectory = "tenancy/tenants/{$databaseName}/purchase/";

        $filename = $purchase->filename;
        if (!Str::endsWith($filename, '.pdf')) {
            $filename .= '.pdf';
        }

        $filePath = storage_path("app/{$tenantDirectory}{$filename}");

        if (!file_exists($filePath)) {
            throw new Exception("El archivo PDF no se encuentra en la ruta esperada: {$filePath}");
        }

        return response()->file($filePath, $this->generalPdfResponseFileHeaders($filename));
    }


    public function toPrint($external_id, $format)
    {
        $purchase = Purchase::where('external_id', $external_id)->first();

        if (!$purchase) throw new Exception("El código {$external_id} es inválido, no se encontro el pedido relacionado");

        $this->reloadPDF($purchase, $format, $purchase->filename);
        $temp = tempnam(sys_get_temp_dir(), 'purchase');

        file_put_contents($temp, $this->getStorage($purchase->filename, 'purchase'));

        /*
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$purchase->filename.'"'
            ];
            */

        return response()->file($temp, $this->generalPdfResponseFileHeaders($purchase->filename));
    }

    private function reloadPDF($purchase, $format, $filename)
    {
        $this->createPdf($purchase, $format, $filename);
    }

    public function createPdf($purchase = null, $format_pdf = null, $filename = null)
    {

        ini_set("pcre.backtrack_limit", "5000000");
        $template = new Template();
        $pdf = new Mpdf();

        $document = ($purchase != null) ? $purchase : $this->purchase;

        $company = Company::active();
        if ($filename == null) {
            $filename = $this->createFilename($document);
            $this->setFilename($document);
        }
        // $base_template = Establishment::find($document->establishment_id)->template_pdf;
        $base_template = Configuration::first()->formats;

        $html = $template->pdf($base_template, "purchase", $company, $document, $format_pdf);


        $pdf_font_regular = config('tenant.pdf_name_regular');
        $pdf_font_bold = config('tenant.pdf_name_bold');

        if ($pdf_font_regular != false) {
            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $pdf = new Mpdf([
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
            ]);
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
                $html_footer = $template->pdfFooter($base_template, $document);
                $pdf->SetHTMLFooter($html_footer);
            }
        }

        $this->uploadFile($filename, $pdf->output('', 'S'), 'purchase');
    }

    private function createFilename($purchase)
    {

        $name = [$purchase->series, $purchase->number, $purchase->id, date('Ymd')];
        return join('-', $name);
    }

    private function setFilename($purchase)
    {

        $name = [$purchase->series, $purchase->number, $purchase->id, date('Ymd')];
        $purchase->filename = join('-', $name);
        $purchase->save();
    }

    public function uploadFile($filename, $file_content, $file_type)
    {
        $this->uploadStorage($filename, $file_content, $file_type);
    }

    public function update(PurchaseRequest $request)
    {
        //dd();
        $purchase = DB::connection('tenant')->transaction(function () use ($request) {
            $doc = Purchase::firstOrNew(['id' => $request['id']]);
            // return json_encode($doc);
            $doc->fill($request->all());
            $doc->save();
            $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
            //proceso para eliminar los actualizar el stock de proiductos
            foreach ($doc->items as $item) {
                $item->purchase->inventory_kardex()->create([
                    'date_of_issue' => date('Y-m-d'),
                    'item_id' => $item->item_id,
                    'warehouse_id' => $item->warehouse_id,
                    'quantity' => -$item->quantity,
                    'user_id' => isset(auth()->user()->id) ? auth()->user()->id : null,
                ]);
                $wr = ItemWarehouse::where([['item_id', $item->item_id], ['warehouse_id', $item->warehouse_id]])->first();
                $wr->stock =  $wr->stock - $item->quantity;
                $wr->save();
            }
            foreach ($doc->items()->get() as $it) {
                // dd($it);
                $it->lots()->delete();
            }
            $doc->items()->delete();
            foreach ($request['items'] as $row) {
                $unit_price = floatval($row['unit_price']);
                $p_item = new PurchaseItem;
                $p_item->fill($row);
                $p_item->purchase_id = $doc->id;
                $p_item->save();
                $item = Item::findOrFail($row['item_id']);
                if (isset($row['sale_unit_price']) && $row['sale_unit_price'] != 0 && $row['sale_unit_price'] != null) {
                    $item->sale_unit_price = $row['sale_unit_price'];
                    Food::where('item_id', $row['item_id'])->update(['price' => $row['sale_unit_price']]);
                    ItemWarehousePrice::where('item_id', $row['item_id'])
                        ->where('warehouse_id', $doc->establishment_id)->update(['price' => $row['sale_unit_price']]);
                }
                $purchase_unit_price_item = floatval($item->purchase_unit_price);
                if ($unit_price != $purchase_unit_price_item) {
                    $item->purchase_unit_price = $unit_price;
                }
                $item->purchase_affectation_igv_type_id = $row['affectation_igv_type_id'];
                $item->save();
                if (array_key_exists('lots', $row)) {
                    foreach ($row['lots'] as $lot) {
                        $p_item->lots()->create([
                            'date' => $lot['date'],
                            'series' => $lot['series'],
                            'item_id' => $row['item_id'],
                            'warehouse_id' => $row['warehouse_id'],
                            'has_sale' => false
                        ]);
                    }
                }
            }

            // $doc->purchase_payments()->delete();
            $this->deleteAllPayments($doc->purchase_payments);

            foreach ($request['payments'] as $payment) {

                $record_payment = $doc->purchase_payments()->create($payment);

                if (isset($payment['payment_destination_id'])) {
                    $this->createGlobalPayment($record_payment, $payment);
                }

                if (isset($payment['payment_filename'])) {
                    $record_payment->payment_file()->create([
                        'filename' => $payment['payment_filename']
                    ]);
                }
            }
            // foreach ($doc->items as $item) {
            //     $this->updateStock($item->item_id);
            // }
            return $doc;
        });

        return [
            'success' => true,
            'data' => [
                'id' => $purchase->id,
            ],
        ];
    }

    public function updateStock($id)
    {
        $saldo_stock = 0.00;
        //Saldo Inicial
        $saldo_inicial = floatval(Inventory::where('item_id', $id)->sum('quantity'));
        //Compras
        $compras = floatval(PurchaseItem::where('item_id', $id)->sum('quantity'));
        $sale_notelist = SaleNote::where('state_type_id', '<>', "11")->get();
        $array_sales_id = [];
        $sale_note = DB::connection('tenant')->table('sale_note_items')
            ->join('sale_notes', 'sale_notes.id', '=', 'sale_note_items.sale_note_id')
            ->select('sale_note_items.quantity', 'sale_note_items.sale_note_id')
            ->where('item_id', $id)
            ->whereRaw("JSON_EXTRACT(sale_note_items.item, '$.is_stock') = 'Si'")
            ->where('sale_notes.state_type_id', "!=", "11")
            ->get();
        $sale_note = $sale_note->sum('quantity');
        $document = DB::connection('tenant')->table('document_items')
            //->select(DB::raw("sum(document_items.quantity) as quantity"))
            ->select('document_items.quantity', 'document_items.document_id')
            ->join('documents', 'documents.id', '=', 'document_items.document_id')
            ->where('documents.state_type_id', "!=", "11")
            ->whereRaw("JSON_EXTRACT(document_items.item, '$.is_stock') = 'Si'")
            ->where('item_id', $id)
            ->get();
        $document = $document->sum('quantity');
        if ($document != null) {
            if ($document != null) {
                $document = $document;
            } else {
                $document = 0;
            }
        } else {
            $document = 0;
        }
        if ($sale_note != null) {
            if ($sale_note != null) {
                $sale_note = $sale_note;
            } else {
                $sale_note = 0;
            }
        } else {
            $sale_note = 0;
        }
        $saldo_stock = ($saldo_inicial + $compras) - ($sale_note + $document);
        DB::connection('tenant')->table('items')->where('id', $id)->update(['stock' => $saldo_stock]);
        DB::connection('tenant')->table('item_warehouse')->where('item_id', $id)->update(['stock' => $saldo_stock]);
    }

    //validar para anular 
    /*public function anular($id)
    {
        try {
            DB::connection('tenant')->beginTransaction();
            $obj =  Purchase::find($id);
            $obj->state_type_id = 11;
            $obj->save();

            $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
            // $warehouse = Warehouse::where('establishment_id', $establishment->id)->first();
            $type = "App\Models\Tenant\Purchase";
            //proceso para eliminar los actualizar el stock de proiductos
            // $quantity = 0;
            foreach ($obj->items as $item) {
                $inventoryKardex = InventoryKardex::where('item_id', $item->item_id)
                    ->where('inventory_kardexable_type', $type)->where('inventory_kardexable_id', $id)->first();
                $item->purchase->inventory_kardex()->create([
                    'date_of_issue' => date('Y-m-d'),
                    'item_id' => $item->item_id,
                    'warehouse_id' => $inventoryKardex->warehouse_id,
                    'quantity' => -$item->quantity,
                    'user_id' => isset(auth()->user()->id) ? auth()->user()->id : null,
                ]);
                $wr = ItemWarehouse::where([['item_id', $item->item_id], ['warehouse_id', $inventoryKardex->warehouse_id]])->first();
                if ($wr->stock == 0 || $wr->stock < $item->quantity) {
                    throw new Exception("El stock del producto {$item->item->description} no es suficiente para anular la compra");
                }
                $wr->stock =  $wr->stock - $item->quantity;
                $wr->save();
                $it = Item::find($item->item_id);
                $it->stock -= $item->quantity;
                $it->save();
                $this->removeDetailItems($item);
            }

            DB::connection('tenant')->commit();

            return [
                'success' => true,
                'message' => 'Compra anulada con éxito'
            ];
        } catch (Exception $e) {
            DB::connection('tenant')->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }*/


    public function anular($id)
    {
        try {
            DB::connection('tenant')->beginTransaction();

            $obj = Purchase::find($id);
            $obj->state_type_id = 11;
            $obj->save();

            $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
            $type = "App\Models\Tenant\Purchase";

            foreach ($obj->items as $item) {
                $inventoryKardex = InventoryKardex::where('item_id', $item->item_id)
                    ->where('inventory_kardexable_type', $type)->where('inventory_kardexable_id', $id)->first();
                $item->purchase->inventory_kardex()->create([
                    'date_of_issue' => date('Y-m-d'),
                    'item_id' => $item->item_id,
                    'warehouse_id' => $inventoryKardex->warehouse_id,
                    'quantity' => -$item->quantity,
                    'user_id' => isset(auth()->user()->id) ? auth()->user()->id : null,
                ]);
                $wr = ItemWarehouse::where([['item_id', $item->item_id], ['warehouse_id', $inventoryKardex->warehouse_id]])->first();
                if (!$wr) {
                    throw new Exception("No se encontró stock en el almacén para el producto {$item->item->description}");
                }
                // 🚨 Validación correcta
                if ($wr->stock < $item->quantity) {
                    throw new Exception("No se puede anular, el stock actual ({$wr->stock}) es menor a lo ingresado en la compra ({$item->quantity}).");
                }
                /* if ($wr->stock == 0 || $wr->stock < $item->quantity) {
                    throw new Exception("El stock del producto {$item->item->description} no es suficiente para anular la compra");
                } */
                $wr->stock =  $wr->stock - $item->quantity;
                $wr->save();
                $it = Item::find($item->item_id);
                $it->stock -= $item->quantity;
                $it->save();
                $this->removeDetailItems($item);
            }

            /* foreach ($obj->items as $item) {
                $inventoryKardex = InventoryKardex::where('item_id', $item->item_id)
                    ->where('inventory_kardexable_type', $type)
                    ->where('inventory_kardexable_id', $id)
                    ->first();

                // Registrar movimiento inverso en kardex
                $item->purchase->inventory_kardex()->create([
                    'date_of_issue' => date('Y-m-d'),
                    'item_id' => $item->item_id,
                    'warehouse_id' => $inventoryKardex->warehouse_id,
                    'quantity' => -$item->quantity,
                    'user_id' => auth()->id(),
                ]);

                // Actualizar stock
                $wr = ItemWarehouse::where([
                    ['item_id', $item->item_id],
                    ['warehouse_id', $inventoryKardex->warehouse_id]
                ])->first();

                if ($wr->stock == 0 || $wr->stock < $item->quantity) {
                    throw new Exception("El stock del producto {$item->item->description} no es suficiente para anular la compra");
                }

                $wr->stock -= $item->quantity;
                $wr->save();

                $it = Item::find($item->item_id);
                $it->stock -= $item->quantity;
                $it->save();

                $this->removeDetailItems($item);
            } */

            /**
             * 💰 Devolver el monto al box solo si el usuario es ARCA
             */
            $user = auth()->user();

            if ($user->is_arca == 1) {
                // Caja abierta del usuario arca
                $arcaCash = Cash::where('user_id', $user->id)
                    ->where('state', 1)
                    ->latest()
                    ->first();

                if (!$arcaCash) {
                    throw new Exception("El usuario arca no tiene una caja aperturada.");
                }

                // Registrar devolución en box según métodos de pago de la compra
                if ($obj->purchase_payments && $obj->purchase_payments->count() > 0) {
                    foreach ($obj->purchase_payments as $payment) {
                        $method = $payment->payment_method_type->description ?? 'Efectivo';
                        Box::create([
                            'cash_id'          => $arcaCash->id,
                            'date'             => now(),
                            'amount'           => $payment->payment,
                            'expenses'         => 0,
                            'incomes'          => 1,
                            'group_id'         => 1,
                            'category_id'      => 2,
                            'subcategory_id'   => 1,
                            'state'            => 1,
                            'type'             => 1,
                            'soap_type_id'     => Company::active()->soap_type_id,
                            'user_id'          => $user->id,
                            'description'      => "Devolución por anulación de compra {$obj->series}-{$obj->number} con método {$method}",
                            'purchase_id'      => $obj->id,
                            'currency_type_id' => $obj->currency_type_id,
                            'method'           => $method,
                        ]);
                    }
                } else {

                    Box::create([
                        'cash_id'        => $arcaCash->id,
                        'date'           => now(),
                        'amount'         => $obj->total,
                        'expenses'       => 0,
                        'incomes'        => 1,
                        'group_id'       => 1,
                        'category_id'    => 2,
                        'subcategory_id' => 1,
                        'state'          => 1,
                        'type'           => 1,
                        'soap_type_id'   => Company::active()->soap_type_id,
                        'user_id'        => $user->id,
                        'description'    => "Devolución por anulación de compra {$obj->series}-{$obj->number}",
                        'purchase_id'    => $obj->id,
                        'currency_type_id' => $obj->currency_type_id,
                        'method'         => 'Efectivo',
                    ]);
                }
            }
            DB::connection('tenant')->commit();

            return [
                'success' => true,
                'message' => 'Compra anulada con éxito'
            ];
        } catch (Exception $e) {
            DB::connection('tenant')->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    function removeDetailItems($item)
    {
        $item->lots()->delete();
        $r_item = $item->item;
        $item_id = $item->item_id;
        $lots_group = $r_item->lots_group;
        if (isset($lots_group)) {
            foreach ($lots_group as $lot) {
                $code  = $lot->code;
                $quantity = $lot->quantity;
                $item_lot = ItemLotsGroup::where('code', $code)->where('item_id', $item_id)->where('quantity', $quantity)->first();
                if ($item_lot) {
                    $item_lot->delete();
                } else {
                    throw new Exception("No se encontro el lote del producto");
                }
            }
        }
        $color_size = $r_item->color_size;
        if (isset($color_size)) {
            foreach ($color_size as $color) {
                $price = $color->price;
                $size = $color->size;
                $color = $color->color;
                $item_color_size = ItemColorSize::where('color', $color)->where('size', $size)->where('price', $price)->where('item_id', $item_id)->first();
                if ($item_color_size) {
                    $item_color_size->delete();
                } else {
                    throw new Exception("No se encontro el color y talla del producto");
                }
            }
        }
    }
    public static function convert($inputs)
    {
        $company = Company::active();
        $values = [
            'user_id' => auth()->id(),
            'external_id' => Str::uuid()->toString(),
            'supplier' => PersonInput::set($inputs['supplier_id']),
            'soap_type_id' => $company->soap_type_id,
            'group_id' => ($inputs->document_type_id === '01') ? '01' : '02',
            'state_type_id' => '01'
        ];

        $inputs->merge($values);

        return $inputs->all();
    }

    public function table($table)
    {
        switch ($table) {
            case 'suppliers':

                $suppliers = Person::whereType('suppliers')->orderBy('name')->get()->transform(function ($row) {
                    return [
                        'id' => $row->id,
                        'description' => ($row->alias ? $row->alias . " - " : '') . $row->number . ' - ' . $row->name,
                        'name' => $row->name,
                        'number' => $row->number,
                        'perception_agent' => (bool) $row->perception_agent,
                        'identity_document_type_id' => $row->identity_document_type_id,
                        'identity_document_type_code' => $row->identity_document_type->code
                    ];
                });
                return $suppliers;

                break;

            case 'items':
                $items = Item::where('active', 1)
                    ->whereNotIsSet()
                    ->whereIsActive()
                    ->where('unit_type_id', '!=', 'ZZ')
                    ->where('promotions_items', 0)
                    ->where('is_set', 0)
                    ->orderBy('description')
                    ->take(20)
                    ->get();

                return collect($items)->transform(function ($row) {
                    $full_description = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;
                    return [
                        'id' => $row->id,
                        'item_code'  => $row->item_code,
                        'full_description' => $full_description,
                        'description' => $row->description,
                        'internal_id' => $row->internal_id,
                        'currency_type_id' => $row->currency_type_id,
                        'currency_type_symbol' => $row->currency_type['symbol'],
                        'sale_unit_price' => $row->sale_unit_price,
                        'purchase_unit_price' => $row->purchase_unit_price,
                        'unit_type_id' => $row->unit_type_id,
                        'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                        'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                        'has_perception' => (bool) $row->has_perception,
                        'lots_enabled' => (bool) $row->lots_enabled,
                        'percentage_perception' => $row->percentage_perception,
                        'has_color_size' => (bool)$row->has_color_size,
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
                        'init_report' => (bool) $row->init_report,
                        'series_enabled' => (bool) $row->series_enabled,
                        'max_quantity' => $row->max_quantity,
                        'max_quantity_description' => $row->max_quantity_description,
                        'warehouses' => collect($row->warehouses)
                            ->where('active', 1) // Only get warehouses where active=1
                            ->transform(function ($row) {
                                return [
                                    'warehouse_id' => $row->warehouse->id,
                                    'warehouse_description' => $row->warehouse->description,
                                    'stock' => $row->stock,
                                    'active' => $row->active,
                                ];
                            })
                    ];
                });

                break;
            default:

                return [];

                break;
        }
    }

    public function delete($id)
    {

        try {

            DB::connection('tenant')->transaction(function () use ($id) {

                $row = Purchase::findOrFail($id);
                $this->deleteAllPayments($row->purchase_payments);
                $row->delete();
            });

            return [
                'success' => true,
                'message' => 'Compra eliminada con éxito'
            ];
        } catch (Exception $e) {

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function updatefacturar(PurchaseFacturarRequest $request)
    {
        $purchase = Purchase::findOrFail($request->id);

        $this->createPdf($purchase, "a4", $purchase->filename);

        $purchase->document_type_id = $request->document_type_id;
        $purchase->series = $request->series;
        $purchase->number = $request->number;
        $purchase->save();

        // Create a new PDF for the updated document type
        $this->createPdfWithUpdatedHeader($purchase, "a4", $request->document_type_id);

        return [
            "success" => true,
            "message" => "Se guardó con éxito",
            "data" => $purchase
        ];
    }

    private function createPdfWithUpdatedHeader($purchase, $format_pdf, $document_type_id)
    {
        ini_set("pcre.backtrack_limit", "5000000");
        $template = new Template();
        $pdf = new Mpdf();

        $company = Company::active();
        $filename = $this->createFilename($purchase) . '-' . strtolower($document_type_id);

        // Get the base template
        $base_template = Configuration::first()->formats;

        // Generate the HTML with the updated header
        $html = $template->pdf($base_template, "purchase", $company, $purchase, $format_pdf);

        // Update the header based on the document type
        switch ($document_type_id) {
            case '01':
                $html = str_replace('GUÍA', 'FACTURA ELECTRÓNICA', $html);
                break;
            case '03':
                $html = str_replace('GUÍA', 'BOLETA ELECTRÓNICA', $html);
                break;
            // Add more cases as needed
            default:
                $html = str_replace('GUÍA', 'DOCUMENTO ELECTRÓNICO', $html);
                break;
        }

        $pdf_font_regular = config('tenant.pdf_name_regular');
        $pdf_font_bold = config('tenant.pdf_name_bold');

        if ($pdf_font_regular != false) {
            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $pdf = new Mpdf([
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
            ]);
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
                $html_footer = $template->pdfFooter($base_template, $purchase);
                $pdf->SetHTMLFooter($html_footer);
            }
        }

        $this->uploadFile($filename, $pdf->output('', 'S'), 'purchase');
    }

    public function xml2array($xmlObject, $out = array())
    {
        foreach ((array) $xmlObject as $index => $node) {
            $out[$index] = (is_object($node)) ?  $this->xml2array($node) : $node;
        }
        return $out;
    }

    function XMLtoArray($xml)
    {
        $previous_value = libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->loadXml($xml);
        libxml_use_internal_errors($previous_value);
        if (libxml_get_errors()) {
            return [];
        }
        return $this->DOMtoArray($dom);
    }

    public function DOMtoArray($root)
    {
        $result = array();

        if ($root->hasAttributes()) {
            $attrs = $root->attributes;
            foreach ($attrs as $attr) {
                $result['@attributes'][$attr->name] = $attr->value;
            }
        }

        if ($root->hasChildNodes()) {
            $children = $root->childNodes;
            if ($children->length == 1) {
                $child = $children->item(0);
                if (in_array($child->nodeType, [XML_TEXT_NODE, XML_CDATA_SECTION_NODE])) {
                    $result['_value'] = $child->nodeValue;
                    return count($result) == 1
                        ? $result['_value']
                        : $result;
                }
            }
            $groups = array();
            foreach ($children as $child) {
                if (!isset($result[$child->nodeName])) {
                    $result[$child->nodeName] = $this->DOMtoArray($child);
                } else {
                    if (!isset($groups[$child->nodeName])) {
                        $result[$child->nodeName] = array($result[$child->nodeName]);
                        $groups[$child->nodeName] = 1;
                    }
                    $result[$child->nodeName][] = $this->DOMtoArray($child);
                }
            }
        }
        return $result;
    }

    public function import(PurchaseImportRequest $request)
    {
        try {
            $model = $request->all();
            $supplier =  Person::whereType('suppliers')->where('number', $model['supplier_ruc'])->first();
            if (!$supplier) {
                return [
                    'success' => false,
                    'data' => 'Supplier not exist.'
                ];
            }
            $model['supplier_id'] = $supplier->id;
            $company = Company::active();
            $values = [
                'user_id' => auth()->id(),
                'external_id' => Str::uuid()->toString(),
                'supplier' => PersonInput::set($model['supplier_id']),
                'soap_type_id' => $company['soap_type_id'],
                'group_id' => ($model['document_type_id'] === '01') ? '01' : '02',
                'state_type_id' => '01'
            ];

            $data = array_merge($model, $values);

            $purchase = DB::connection('tenant')->transaction(function () use ($data) {
                $doc = Purchase::create($data);
                foreach ($data['items'] as $row) {
                    $doc->items()->create($row);
                }

                $doc->purchase_payments()->create([
                    'date_of_payment' => $data['date_of_issue'],
                    'payment_method_type_id' => $data['payment_method_type_id'] ?? '01',
                    'payment' => $data['total'],
                ]);

                return $doc;
            });

            return [
                'success' => true,
                'message' => 'Xml cargado correctamente.',
                'data' => [
                    'id' => $purchase->id,
                ],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function getPersons($type)
    {

        $persons = Person::whereType($type)->orderBy('name')->take(20)->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id,
            ];
        });

        return $persons;
    }
}
