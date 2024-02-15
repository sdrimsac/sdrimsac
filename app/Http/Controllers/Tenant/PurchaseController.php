<?php

namespace App\Http\Controllers\Tenant;

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
use App\Exports\PurchaseExport;
use App\Models\Tenant\ItemColorSize;
use App\Models\Tenant\ItemWarehousePrice;
use Exception;
use Modules\Restaurant\Models\Food;

class PurchaseController extends Controller
{

    use FinanceTrait;

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


    public function create($purchase_order_id = null)
    {
        return view('tenant.purchases.form', compact('purchase_order_id'));
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
    public function records(Request $request)
    {

        $records = $this->getRecords($request);

        return new PurchaseCollection($records->paginate(config('tenant.items_per_page')));
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

    public function tables()
    {
        $suppliers = $this->table('suppliers');
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $currency_types = CurrencyType::whereActive()->get();
        $document_types_invoice = DocumentType::whereIn('id', ['01', '03', 'GU75', 'NE76'])->get();
        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->get();
        $charge_types = ChargeDiscountType::whereType('charge')->whereLevel('item')->get();
        $company = Company::active();
        $payment_method_types = PaymentMethodType::all();
        $payment_destinations = $this->getPaymentDestinations();
        $customers = $this->getPersons('customers');

        /*  $estados=array(
            ["id"=>"1","name"=>"Nuevo"],            ["id"=>"2","name"=>"Aceptado"],
            ["id"=>"3","name"=>"Repartidor"],
            ["id"=>"4","name"=>"En Camino"],
            ["id"=>"5","name"=>"Entregado"],
            ["id"=>"6","name"=>"Cancelado"],
        );
        $pedidos = array(
            array("number"=>"2323", "category_name"=>"POLLOS", "restaurant_name"=>"EL DORADO","time"=>"20 Min","status"=>true,"estados_id"=>"1"),
            array("number"=>"147852", "category_name"=>"HAMBUERGUESA", "restaurant_name"=>"HAMBUER","time"=>"10 Min","status"=>false,"estados_id"=>"3"),
            array("number"=>"147852", "category_name"=>"PIZZA", "restaurant_name"=>"EL PIZZERO","time"=>"05 Min","status"=>false,"estados_id"=>"2"),
            array("number"=>"147852", "category_name"=>"POLLERIA LOYZA", "restaurant_name"=>"EL POLLERIA","time"=>"10 Min","status"=>true,"estados_id"=>"4"),
            array("number"=>"147852", "category_name"=>"POLLERIA CARBON", "restaurant_name"=>"CARBON","time"=>"10 Min","status"=>false,"estados_id"=>"5"),
        );*/
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
            'customers'
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
                $doc = Purchase::create($data);
                foreach ($data['items'] as $row) {
                    $p_item = new PurchaseItem;
                    $p_item->fill($row);
                    $p_item->purchase_id = $doc->id;
                    $p_item->save();
                    $item = Item::findOrFail($row['item_id']);
                    if ($row['sale_unit_price'] != 0 && $row['sale_unit_price'] != null) {
                        $item->sale_unit_price = $row['sale_unit_price'];
                        Food::where('item_id', $row['item_id'])->update(['price' => $row['sale_unit_price']]);
                        ItemWarehousePrice::where('item_id', $row['item_id'])
                            ->where('warehouse_id', $doc->establishment_id)->update(['price' => $row['sale_unit_price']]);
                    }
                    $item->purchase_affectation_igv_type_id = $row['affectation_igv_type_id'];
                    $item->save();

                    if (array_key_exists('color_size', $row)) {
                        foreach ($row['color_size'] as $color_size) {
                            $color_size_exists = ItemColorSize::where('item_id', $row['item_id'])
                                ->where('warehouse_id', $row['warehouse_id'])
                                ->where('color', $color_size['color'])
                                ->where('size', $color_size['size'])
                                ->first();
                            if ($color_size_exists) {
                                $color_size_exists->stock += $color_size['stock'];
                                $price = $color_size['price'];
                                if ($price != 0 && $price != null || $price != '') {
                                    $color_size_exists->price = $price;
                                }
                                $color_size_exists->save();
                            } else {
                                $item->color_size()->create([
                                    'item_id' => $row['item_id'],
                                    'warehouse_id' => $row['warehouse_id'],
                                    'color' => $color_size['color'],
                                    'price' => $color_size['price'],
                                    'size' => $color_size['size'],
                                    'stock' => $color_size['stock'],
                                ]);
                            }
                        }
                    }
                    if (array_key_exists('lots', $row)) {
                        foreach ($row['lots'] as $lot) {
                            // Verificar si el lote existe en la tabla item_lots
                            $item_lot = ItemLot::where('series', $lot['series'])
                                ->where('item_id', $row['item_id'])
                                ->whereRaw('LENGTH(series) = ?', [strlen($lot['series'])])
                                ->first();

                            if ($item_lot) {

                                $message = "La serie {$lot['series']} ya existe en el sistema";
                                $has_error = true;
                                DB::rollBack();
                                break 2; // Salir de ambos bucles y terminar la transacción
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
                            ItemLotsGroup::create([
                                'code' => $row['lot_code'],
                                'quantity' => $row['quantity'],
                                'date_of_due' => $row['date_of_due'],
                                'item_id' => $row['item_id'],
                                'warehouse_id' => $row['warehouse_id'],
                            ]);
                        }
                    }
                }

                foreach ($data['payments'] as $payment) {
                    $record_payment = $doc->purchase_payments()->create($payment);

                    if (isset($payment['payment_destination_id'])) {
                        $this->createGlobalPayment($record_payment, $payment);
                    }
                }

                return $doc;
            } catch (Exception $e) {
                $has_error = true;
                $message = $e->getMessage();
                throw $e; // Lanza la excepción nuevamente para que se maneje externamente.
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
                    'warehouse_id' => $establishment->id,
                    'quantity' => -$item->quantity,
                ]);
                $wr = ItemWarehouse::where([['item_id', $item->item_id], ['warehouse_id', $establishment->id]])->first();
                $wr->stock =  $wr->stock - $item->quantity;
                $wr->save();
            }
            foreach ($doc->items()->get() as $it) {
                // dd($it);
                $it->lots()->delete();
            }
            $doc->items()->delete();
            foreach ($request['items'] as $row) {
                $p_item = new PurchaseItem;
                $p_item->fill($row);
                $p_item->purchase_id = $doc->id;
                $p_item->save();
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
    public function anular($id)
    {
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
            ]);
            $wr = ItemWarehouse::where([['item_id', $item->item_id], ['warehouse_id', $inventoryKardex->warehouse_id]])->first();
            $wr->stock =  $wr->stock - $item->quantity;
            $wr->save();
            $it = Item::find($item->item_id);
            $it->stock -= $item->quantity;
            $it->save();
            // $this->updateStock($item->item_id);
        }

        return [
            'success' => true,
            'message' => 'Compra anulada con éxito'
        ];
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
                        'description' => $row->number . ' - ' . $row->name,
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

                $items = Item::whereNotIsSet()->whereIsActive()->orderBy('description')
                    ->take(20)->get(); //whereWarehouse()
                return collect($items)->transform(function ($row) {
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

                        'warehouses' => collect($row->warehouses)->transform(function ($row) {
                            return [
                                'warehouse_id' => $row->warehouse->id,
                                'warehouse_description' => $row->warehouse->description,
                                'stock' => $row->stock,
                            ];
                        })
                    ];
                });
                //                return $items;

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
        $purchase->document_type_id = $request->document_type_id;
        $purchase->series = $request->series;
        $purchase->number = $request->number;
        $purchase->save();
        return [
            "success" => true,
            "message" => "Se Guardo con exito",
            "data" => $purchase
        ];
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
                    'payment_method_type_id' => $data['payment_method_type_id'],
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
