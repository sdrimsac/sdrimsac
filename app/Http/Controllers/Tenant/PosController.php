<?php

namespace App\Http\Controllers\Tenant;

use Exception;
use App\Models\Tenant\Box;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Item;
use App\Models\Tenant\User;
use App\Models\Tenant\Person;
use App\Models\Tenant\Series;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\CardBrand;
use Illuminate\Http\Request;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Desarrollador;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\PaymentMethodType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\BoxCollection;
use App\Models\Tenant\Catalogs\CurrencyType;
use Modules\Item\Models\CategoryItem;
use Modules\Inventory\Models\Warehouse;
use Modules\Finance\Traits\FinanceTrait;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Catalogs\IdentityDocumentType;
use App\Models\Tenant\Seller;
use Carbon\Carbon;
use Modules\College\Models\CollegeStudent;
use Modules\Document\Models\SeriesConfiguration;
use Modules\Inventory\Models\ItemWarehouse;
use Modules\Inventory\Models\InventoryConfiguration;
use Modules\Item\Models\ItemLotsGroup;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\Table;
use Modules\Services\Data\ServiceData;

class PosController extends Controller
{
    use FinanceTrait;

    public function last_number_documents(Request $request)
    {
        $company = Company::first();
        $series = $request->series;
        $customer = null;
        $orden_id = $request->ordenId;
        if ($orden_id) {
            $orden = Orden::find($orden_id);
            if ($orden) {
                $ref = $orden->ref;
                if ($ref != null) {
                    $ref = trim($ref);
                    $length = strlen($ref);
                    if ($length >= 8) {
                        $customer = Person::where('number', $ref)->where('type', 'customers')->first();
                        if ($customer == null) {
                            if ($length == 8 || $length == 11) {
                                $type = $length == 8 ? 'dni' : 'ruc';

                                try {
                                    $customer =  ServiceData::service($type, $ref);
                                    if (key_exists('data', $customer)) {
                                        $customer = $this->savePerson($customer['data'], $type);
                                    }
                                } catch (Exception $e) {
                                    $customer = null;
                                }
                            }
                        }
                    }
                }
            }
        }
        $result = [];
        if ($series != null) {
            foreach ($series as $serie) {
                $prefix = $serie["number"];
                if (str_contains($prefix, "NV")) {
                    $last_sale_note  = SaleNote::where("series", $prefix)->where('soap_type_id', $company->soap_type_id)->latest()->first();
                    if ($last_sale_note) {
                        $last_sale_note = $last_sale_note->number + 1;
                    } else {
                        $series_configuration = SeriesConfiguration::where('series', $prefix)->first();
                        if ($series_configuration) {
                            $last_sale_note = $series_configuration->number;
                        } else {

                            $last_sale_note = 1;
                        }
                    }
                    $result[$prefix] = $last_sale_note;
                } else {
                    $last_document  = Document::where("series", $prefix)->where('soap_type_id', $company->soap_type_id)->latest("id")->first();
                    if ($last_document) {
                        $last_document = $last_document->number + 1;
                    } else {
                        $series_configuration = SeriesConfiguration::where('series', $prefix)->first();
                        if ($series_configuration) {
                            $last_document = $series_configuration->number;
                        } else {

                            $last_document = 1;
                        }
                    }
                    $result[$prefix] = $last_document;
                }
            }
        }
        return ["success" => true, "result" => $result, "customer" => $customer];
    }

    function savePerson($data, $type)
    {
        $customer = [];
        $customer["number"] = $type == 'dni' ? $data['numero'] : $data['ruc'];
        $customer["name"] = $type == 'dni' ? $data['nombre_completo'] : $data['nombre_o_razon_social'];
        $customer["identity_document_type_id"] = $type == 'dni' ? 1 : 6;
        $customer["country_id"] = 'PE';
        $customer["department_id"] = $data['ubigeo'][0];
        $customer["province_id"] = $data['ubigeo'][1];
        $customer["district_id"] = $data['ubigeo'][2];
        $customer["address"] = $data['direccion_completa'];
        $customer["seller_id"] = auth()->user()->id;
        if ($type == 'ruc') {
            $customer["condition"] = $data['condicion'];
            $customer["state"] = $data['estado'];
        }


        $person = new Person;
        $person->fill($customer);
        $person->save();

        if ($person->id != null) {
            return Person::find($person->id);
        }
        return null;
        // $customer 

    }
    public function index()
    {
        $cash = Cash::where([['user_id', auth()->user()->id], ['state', true]])->first();

        if (!$cash) return redirect()->route('tenant.cash.index');

        $configuration = Configuration::first();

        $company = Company::select('soap_type_id')->first();
        $soap_company  = $company->soap_type_id;

        return view('tenant.pos.index', compact('configuration', 'soap_company', 'desarrollador'));
    }

    public function index_full()
    {
        $cash = Cash::where([['user_id', auth()->user()->id], ['state', true]])->first();

        if (!$cash) return redirect()->route('tenant.cash.index');

        return view('tenant.pos.index_full');
    }

    public function search_items(Request $request)
    {
        $configuration =  Configuration::first();

        $items = Item::where('description', 'like', "%{$request->input_item}%")
            ->orWhere('internal_id', 'like', "%{$request->input_item}%")
            ->orWhereHas('category', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input_item . '%');
            })
            ->orWhereHas('brand', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input_item . '%');
            })
            ->whereWarehouse()
            ->whereIsActive()
            ->get()->transform(function ($row) use ($configuration) {
                $full_description = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;
                return [
                    'id' => $row->id,
                    'item_id' => $row->id,
                    'full_description' => $full_description,
                    'description' => $row->description,
                    'currency_type_id' => $row->currency_type_id,
                    'internal_id' => $row->internal_id,
                    'currency_type_symbol' => $row->currency_type['symbol'],
                    'sale_unit_price' => number_format($row->sale_unit_price, $configuration->decimal_quantity, ".", ""),
                    'purchase_unit_price' => $row->purchase_unit_price,
                    'unit_type_id' => $row->unit_type_id,
                    'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                    'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                    'calculate_quantity' => (bool) $row->calculate_quantity,
                    'is_set' => (bool) $row->is_set,
                    'stock' => $row->stock,
                    'is_stock' => $row->is_stock,
                    'edit_unit_price' => false,
                    'has_igv' => (bool) $row->has_igv,
                    'aux_quantity' => 1,
                    'aux_sale_unit_price' => number_format($row->sale_unit_price, $configuration->decimal_quantity, ".", ""),
                    'edit_sale_unit_price' => number_format($row->sale_unit_price, $configuration->decimal_quantity, ".", ""),
                    'image_url' => ($row->image !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $row->image) : asset("/logo/{$row->image}"),
                    'sets' => collect($row->sets)->transform(function ($r) {
                        return [
                            $r->individual_item->description
                        ];
                    }),
                    'warehouses' => collect($row->warehouses)->transform(function ($row) {
                        return [
                            'warehouse_description' => $row->warehouse->description,
                            'stock' => $row->stock,
                        ];
                    }),
                    'unit_type' => $row->item_unit_types
                ];
            });

        return compact('items');
    }
    public function print_default()
    {
        $user = User::where('id', auth()->user()->id)->first();

        $printer = Establishment::where('id', $user->establishment_id)->first();
        return compact('printer');
    }
    public function date_of_issue(Request $request)
    {
        if ($request->document_type_id == "01" || $request->document_type_id == "03") {
            $documents = Document::select(DB::raw('MAX(id) AS id'))
                ->where('document_type_id', $request->document_type_id)->first();
            $row = Document::where('id', $documents->id)->first();
        } else {
            $saleNote = SaleNote::select(DB::raw('MAX(id) AS saleNote_id'))->first();
            $row = SaleNote::where('id', $saleNote->saleNote_id)->first();
        }
        $date_last = \Carbon\Carbon::parse($row->date_of_issue)->format('d-m-Y');
        return compact('date_last');
    }
    public function tables()
    {
        $sellers = Seller::where('establishment_id', auth()->user()->establishment_id)->get();
        $products_to_due = ItemLotsGroup::where('date_of_due', '<=', Carbon::now()->addMonths(2))
            ->where('quantity', '>', 0)
            ->count();
        $affectation_igv_types = AffectationIgvType::whereActive()->get();
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $method_payment = PaymentMethodType::where('active', 1)->orderBy('description', 'asc')->get();
        if (!$establishment) {
            $establishment = Establishment::first();
        }
        $currency_types = CurrencyType::whereActive()->get();
        $documents_type = IdentityDocumentType::where('active', 1)->get();
        $customers = $this->table('customers');
        $user = User::findOrFail(auth()->user()->id);
        $customers_default = Person::where('id', "=", $establishment->customer_id)->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id,
                'identity_document_type_code' => $row->identity_document_type->code,
                'phone' => $row->telephone
            ];
        });
        $customers_variation = Person::where('number', "=", "88888888")->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id,
                'identity_document_type_code' => $row->identity_document_type->code,
                'phone' => $row->telephone
            ];
        });
        $items = [];
        $company = Company::first();
        // $categories = CategoryItem::all();
        $categories = CategoryItem::query()
            ->whereHas('items', function ($query) use ($user) {
                $query->whereHas('warehouses', function ($query) use ($user) {
                    $query->where('warehouse_id', $user->establishment_id);
                });
            })
            ->where('name', '<>', 'INSUMOS')
            ->get();
        //  dd($row,$documents);
        $item_default = null;
        $config = Configuration::first();
        if ($config->item_variation_id) {
            $item_default = Item::where('id', $config->item_variation_id)->first();
        }
        $areas = Area::all();
        $tablesClean = [];
        $tablesLeave = [];
        if ($config->hotels) {
            $tablesClean = DB::connection('tenant')->table('tables')->where('is_cleaning', true)->get();

            $configuration = Configuration::first();
            $time_to_leave = $configuration->alarm_to_end;
            $date = Carbon::now()->addMinutes($time_to_leave)->format('Y-m-d');
            $time = Carbon::now()->addMinutes($time_to_leave)->format('H:i:s');
            $tablesLeave = Table::with(['hotel_rent_items'])
                ->whereHas('hotel_rent_items', function ($query) use ($date, $time) {
                    $query->where(function ($query) use ($date, $time) {
                        $query->where('checkout_date_estimated', '<', $date)
                            ->orWhere(function ($query) use ($date, $time) {
                                $query->where('checkout_date_estimated', '=', $date)
                                    ->where('checkout_time_estimated', '<', $time);
                            });
                    })
                        // ->where('payment_status', 'Pendiente')
                        ->where('was_cancel', 0);
                })
                ->where('is_room', true)
                ->where('status_table_id', '<>', 1)
                ->get();
        }
        return compact(
            'tablesLeave',
            'tablesClean',
            'sellers',
            'products_to_due',
            'areas',
            'customers_variation',
            'item_default',
            'documents_type',
            'items',
            'customers',
            'affectation_igv_types',
            'establishment',
            'method_payment',
            'user',
            'currency_types',
            'categories',
            'company',
            'customers_default',
            'config'
        );
    }

    public function payment_tables()
    {
        $establishment = auth()->user()->establishment_id;
        if (!$establishment) {
            $establishment = Establishment::first()->id;
        }
        $series = Series::whereIn('document_type_id', ['01', '03', '80'])
            ->where([['establishment_id', $establishment], ['contingency', false]])
            ->get();

        $payment_method_types = PaymentMethodType::all();
        $cards_brand = CardBrand::all();
        $payment_destinations = $this->getPaymentDestinations();


        return compact('series', 'payment_method_types', 'cards_brand', 'payment_destinations');
    }

    public function table_customer($id)
    {
        $configuration = Configuration::first();

        $customers = Person::where('id', $id)
            ->whereType('customers')->whereIsEnabled()->orderBy('created_at', 'desc');




        if ($configuration->college) {
            $customers = $customers->whereIn('id', function ($query) {

                $query->select('parent_id')
                    ->from('parents');
            });
        }
        $customers = $customers->limit(5)->get();

        $customers = $customers->transform(function ($row) {
            $students = CollegeStudent::whereHas('member', function ($query) use ($row) {
                $query->whereHas('parent', function ($query) use ($row) {
                    $query->where('parent_id', $row->id);
                });
            })->get()->transform(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->person->name,
                    'class' => mb_strtoupper($student->classroom->description),
                ];
            });

            return [
                'students' => $students,
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id,
                'identity_document_type_code' => $row->identity_document_type->code,
                'phone' => $row->telephone
            ];
        });
        return $customers;
    }
    public function table($table)
    {
        $configuration = Configuration::first();
        if ($table === 'customers') {

            $customers = Person::whereType('customers')->whereIsEnabled()->orderBy('created_at', 'desc');




            if ($configuration->college) {
                $customers = $customers->whereIn('id', function ($query) {

                    $query->select('parent_id')
                        ->from('parents');
                });
            }
            $customers = $customers->limit(5)->get();

            $customers = $customers->transform(function ($row) {
                $students = CollegeStudent::whereHas('member', function ($query) use ($row) {
                    $query->whereHas('parent', function ($query) use ($row) {
                        $query->where('parent_id', $row->id);
                    });
                })->get()->transform(function ($student) {
                    return [
                        'id' => $student->id,
                        'name' => $student->person->name,
                        'class' => mb_strtoupper($student->classroom->description),
                    ];
                });

                return [
                    'students' => $students,
                    'id' => $row->id,
                    'description' => $row->number . ' - ' . $row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'identity_document_type_id' => $row->identity_document_type_id,
                    'identity_document_type_code' => $row->identity_document_type->code,
                    'phone' => $row->telephone
                ];
            });
            return $customers;
        }

        if ($table === 'items') {
            $configuration =  Configuration::first();
            $items = Item::whereWarehouse()->whereIsActive()->where('unit_type_id', '!=', 'ZZ')->orderBy('description')->limit(10)
                ->get()->transform(function ($row) use ($configuration) {
                    $full_description = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;
                    return [
                        'id' => $row->id,
                        'item_id' => $row->id,
                        'full_description' => $full_description,
                        'description' => $row->description,
                        'currency_type_id' => $row->currency_type_id,
                        'internal_id' => $row->internal_id,
                        'currency_type_symbol' => $row->currency_type->symbol,
                        'sale_unit_price' => number_format($row->sale_unit_price, $configuration->decimal_quantity, ".", ""),
                        'purchase_unit_price' => $row->purchase_unit_price,
                        'unit_type_id' => $row->unit_type_id,
                        'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                        'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                        'calculate_quantity' => (bool) $row->calculate_quantity,
                        'has_igv' => (bool) $row->has_igv,
                        'is_set' => (bool) $row->is_set,
                        'is_stock' => $row->is_stock,
                        'stock' => $row->stock,
                        'edit_unit_price' => false,
                        'aux_quantity' => 1,
                        'edit_sale_unit_price' => number_format($row->sale_unit_price, $configuration->decimal_quantity, ".", ""),
                        'aux_sale_unit_price' => number_format($row->sale_unit_price, $configuration->decimal_quantity, ".", ""),
                        'image_url' => ($row->image !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $row->image) : asset("/logo/{$row->image}"),
                        'warehouses' => collect($row->warehouses)->transform(function ($row) {
                            return [
                                'warehouse_description' => $row->warehouse->description,
                                'stock' => $row->stock,
                            ];
                        }),
                        'category' =>  optional($row->category)->name,
                        'category_id' => ($row->category) ? $row->category->id : null,
                        'sets' => collect($row->sets)->transform(function ($r) {
                            return [
                                $r->individual_item->description
                            ];
                        }),
                        'unit_type' => $row->item_unit_types
                    ];
                });
            return $items;
        }


        if ($table === 'card_brands') {

            $card_brands = CardBrand::all();
            return $card_brands;
        }

        return [];
    }

    public function payment()
    {
        return view('tenant.pos.payment');
    }

    public function status_configuration()
    {

        $configuration = Configuration::first();

        return $configuration;
    }

    public function validate_stock($item_id, $quantity)
    {

        $inventory_configuration = InventoryConfiguration::firstOrFail();
        $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();
        $item_warehouse = ItemWarehouse::where([['item_id', $item_id], ['warehouse_id', $warehouse->id]])->first();
        $item = Item::findOrFail($item_id);

        if ($item->is_set) {

            $sets = $item->sets;

            foreach ($sets as $set) {

                $individual_item = $set->individual_item;
                $item_warehouse = ItemWarehouse::where([['item_id', $individual_item->id], ['warehouse_id', $warehouse->id]])->first();

                if (!$item_warehouse)
                    return [
                        'success' => false,
                        'message' => "El producto seleccionado no está disponible en su almacén!"
                    ];

                $stock = $item_warehouse->stock - $quantity;


                if ($item_warehouse->item->unit_type_id !== 'ZZ') {
                    if (($inventory_configuration->stock_control) && ($stock < 0)) {
                        return [
                            'success' => false,
                            'message' => "El producto {$item_warehouse->item->description} registrado en el conjunto {$item->description} no tiene suficiente stock!"
                        ];
                    }
                }
                // dd($individual_item);
            }
        } else {


            if (!$item_warehouse)
                return [
                    'success' => false,
                    'message' => "El producto seleccionado no está disponible en su almacén!"
                ];

            $stock = $item_warehouse->stock - $quantity;


            if ($item_warehouse->item->unit_type_id !== 'ZZ') {
                if (($inventory_configuration->stock_control) && ($stock < 0)) {
                    return [
                        'success' => false,
                        'message' => "El producto {$item_warehouse->item->description} no tiene suficiente stock!"
                    ];
                }
            }
        }



        return [
            'success' => true,
            'message' => ''
        ];
    }
    public function destroy($id)
    {
        $boxes = Box::findOrFail($id);
        $boxes->delete();
        return [
            "success" => true,
            "message" => "Eliminado con exito"
        ];
    }
}
