<?php

namespace App\Http\Controllers\Tenant;

use Exception;
use Carbon\Carbon;
use App\Models\Tenant\Box;
use App\Models\Tenant\Item;
use App\Models\Tenant\User;
use App\Models\Tenant\Arqueo;
use App\Models\Tenant\Person;
use App\Models\Tenant\Series;
use GuzzleHttp\Client;
use App\Models\Tenant\Company;
use App\Models\Tenant\ItemSet;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use Nexmo\Account\Price;
use App\Models\Tenant\Inventory;
use App\Models\Tenant\StateType;
use App\Models\Tenant\Warehouse;
use App\Mail\DocumentEmail;
use Illuminate\Support\Str;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\PurchaseItem;
use App\Models\Tenant\SaleNoteItem;
use App\Traits\OfflineTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemWarehouse;
use App\Exports\PaymentExport;
use Modules\Item\Models\Brand;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\SaleNotePayment;
use App\CoreFacturalo\Facturalo;
use App\Imports\DocumentsImport;
use App\Models\Tenant\PaymentCondition;
use App\Models\Tenant\PaymentMethodType;
use App\Models\Tenant\Catalogs\PriceType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Restaurant\Models\Area;
use App\CoreFacturalo\WS\Zip\ZipFly;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\Restaurant\Models\Orden;
use App\Models\Tenant\Catalogs\CurrencyType;
use App\Models\Tenant\Catalogs\DocumentType;
use Illuminate\Support\Facades\Cache;
use Modules\Item\Models\CategoryItem;
use App\Http\Requests\Tenant\DocumentRequest;
use App\Models\Tenant\Catalogs\AttributeType;
use App\Models\Tenant\Catalogs\NoteDebitType;
use App\Models\Tenant\Catalogs\OperationType;
use App\Models\Tenant\Catalogs\SystemIscType;
use App\Models\Tenant\Catalogs\DetractionType;
use App\Models\Tenant\Catalogs\NoteCreditType;
use App\Http\Resources\Tenant\DocumentResource;
use Modules\Finance\Traits\FinanceTrait;
use App\Http\Resources\Tenant\DocumentResource2;
use App\Imports\DocumentsImportTwoFormat;
use Modules\Restaurant\Events\PrintEvent;
use App\Http\Resources\Tenant\DocumentCollection;
use GuzzleHttp\Exception\RequestException;
use App\Http\Requests\Tenant\DocumentEmailRequest;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Catalogs\ChargeDiscountType;
use App\Http\Requests\Tenant\DocumentVoidedRequest;
use Modules\Item\Http\Requests\BrandRequest;
use Modules\BusinessTurn\Models\BusinessTurn;
use App\Models\System\Configuration as Config;
use Modules\Item\Http\Requests\CategoryRequest;
use  Modules\Inventory\Models\InventoryConfiguration;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Exports\DocumentExport;
use App\Models\Tenant\BankAccount;
use App\Models\Tenant\Cash;
use Modules\Inventory\Models\Warehouse as ModuleWarehouse;
use App\Models\Tenant\Catalogs\PaymentMethodType as CatPaymentMethodType;
use App\Models\Tenant\CreditList;
use App\Models\Tenant\HotelRent;
use App\Models\Tenant\HotelRentDocument;
use App\Models\Tenant\HotelRentItem;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\NumberActivity;
use App\Models\Tenant\Seller;
use App\Models\Tenant\Summary;
use App\Services\RoleService;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\Http;
use Modules\Item\Models\ItemLot;
use Modules\Item\Models\ItemLotsGroup;
use Modules\Restaurant\Events\OrdenReadyEvent;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Services\Data\ServiceData;
use GuzzleHttp\Client as ClientGuzzleHttp;
use Modules\Restaurant\Models\Table;

class DocumentController extends Controller
{
    use StorageDocument, OfflineTrait, FinanceTrait;
    private $max_count_payment = 0;
    protected $document_state = [
        '-' => '-',
        '0' => 'No Existe',
        '1' => 'Aceptado',
        '2' => 'Anulado',
        '3' => 'AUTORIZADO',
        '4' => 'NO AUTORIZADO'
    ];
    public function __construct()
    {

        $this->middleware('input.request:document,web', ['only' => ['store']]);
    }
    public function checkSummarie()
    {
        $hostname = Website::query()
            ->where('uuid', app(\Hyn\Tenancy\Environment::class)->tenant()->uuid)
            ->first()
            ->hostnames
            ->first();
        $summaries = Summary::query()
            ->where([
                'soap_type_id' => Company::firstOrFail()->active()->soap_type_id,
                'summary_status_type_id' => '1',
                'state_type_id' => '03',
            ])
            ->get();
        foreach ($summaries as $summary) {
            $constructor_params = [
                'base_uri' => config('tenant.force_https') ? "https://{$hostname->fqdn}" : "https://{$hostname->fqdn}",
                'verify' => false
            ];

            $clientGuzzleHttp = new ClientGuzzleHttp($constructor_params);

            $response = $clientGuzzleHttp->post('/api/summaries/status', [
                'http_errors' => false,
                'headers' => [
                    'Authorization' => 'Bearer ' . auth()->user()->api_token,
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'external_id' => $summary->external_id,
                    'ticket' => $summary->ticket
                ]
            ]);



            $res = json_decode($response->getBody()->getContents(), true);

            $longitud = count($res);

            if ($longitud == 1) {
                Log::error($res["message"]);
            }
            if (!$res['success']) $this->info("{$summary->external_id} - {$summary->ticket} - {$res['message']}");
        }
        return [
            'success' => true,
            'message' => 'Se consultó los resumenes'

        ];
    }
    public function createSummarie()
    {
        $hostname = Website::query()
            ->where('uuid', app(\Hyn\Tenancy\Environment::class)->tenant()->uuid)
            ->first()
            ->hostnames
            ->first();
        // $hostname=config('tenant.app_url_base');
        $documents = Document::query()
            ->select('date_of_issue')
            ->where([
                'soap_type_id' => Company::firstOrFail()->active()->soap_type_id,
                'state_type_id' => '01',
                'group_id' => '02'
            ])
            ->groupBy('date_of_issue')
            ->get();
        $curl = curl_init();
        foreach ($documents as $document) {

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://{$hostname->fqdn}" . '/api/summaries',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
            "fecha_de_emision_de_documentos": "' . $document->date_of_issue . '",
            "codigo_tipo_proceso": "1"
          }
          ',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . auth()->user()->api_token
                ),
            ));

            $response = curl_exec($curl);
            $res = json_decode($response, true);
            if (!$res['success']) $this->info("{$document->date_of_issue} - {$res['message']}");
        }

        curl_close($curl);
        return [
            'success' => true,
            'message' => 'Se envió los resumenes'

        ];
    }
    public function totals($request)
    {

        $records =  Document::where([['state_type_id', '01'], ['currency_type_id', 'PEN']])->get();
        $total_pen = 0;
        $total_paid_pen = 0;
        $total_pending_paid_pen = 0;


        $total_pen = $records->sum('total');

        foreach ($records as $document) {

            $total_paid_pen += $document->payments->sum('payment');
        }

        $total_pending_paid_pen = $total_pen - $total_paid_pen;

        return [
            'total_pen' => number_format($total_pen, 2, ".", ""),
            'total_paid_pen' => number_format($total_paid_pen, 2, ".", ""),
            'total_pending_paid_pen' => number_format($total_pending_paid_pen, 2, ".", "")
        ];
    }
    public function index()
    {
        $roleService = new RoleService();
        $is_accountant = $roleService->isAccountant(auth()->user()->worker_type_id);
        $is_client = $this->getIsClient();
        $import_documents = config('tenant.import_documents');
        $import_documents_second = config('tenant.import_documents_second_format');
        $configuration = Configuration::first();
        $company = Company::first();
        return view('tenant.documents.index', compact(
            'company',
            'is_accountant',
            'is_client',
            'import_documents',
            'import_documents_second',
            'configuration'
        ));
    }
    public function documents()
    {
        $is_client = $this->getIsClient();
        $import_documents = config('tenant.import_documents');
        $import_documents_second = config('tenant.import_documents_second_format');
        $configuration = Configuration::first();
        //return view('restaurant::restaurant', compact('configuration'));
        return view('restaurant::documents.list', compact('is_client', 'import_documents', 'import_documents_second', 'configuration'));
    }

    public function columns()
    {
        return [
            'number' => 'Número',
            'date_of_issue' => 'Fecha de emisión'
        ];
    }
    public function notpayment()
    {
        $document = Document::where('state_type_id', '!=', '11')->get();
        foreach ($document as $row) {
            $documentPayment = DocumentPayment::where('document_id', $row->id)->first();
            if ($documentPayment == null) {
                $documentFind = Document::findOrFail($row->id);
                $documentFind->notpayment = true;
            } else {
                $documentFind = Document::findOrFail($row->id);
                $documentFind->notpayment = false;
            }
            $documentFind->save();
        }
        $saleNote = SaleNote::where('state_type_id', '!=', '11')->get();
        foreach ($saleNote as $rows) {
            $documentPayment = SaleNotePayment::where('sale_note_id', $rows->id)->first();

            if ($documentPayment == null) {
                //dd($rows->id);
                $salenoteFind = SaleNote::findOrFail($rows->id);
                $salenoteFind->notpayment = true;
            } else {
                $salenoteFind = SaleNote::findOrFail($rows->id);
                $salenoteFind->notpayment = false;
            }
            $salenoteFind->save();
        }
    }
    public function records(Request $request)
    {

        $records = $this->getRecords($request);

        return new DocumentCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function records_list(Request $request)
    {
        $records = $this->getRecords($request);
        return new DocumentCollection($records->get());
    }
    public function searchCustomers(Request $request)
    {

        //tru de boletas en env esta en true filtra a los con dni   , false a todos
        $identity_document_type_id = $this->getIdentityDocumentTypeId($request->document_type_id, $request->operation_type_id);
        //        $operation_type_id_id = $this->getIdentityDocumentTypeId($request->operation_type_id);

        $customers = Person::where('number', 'like', "%{$request->input}%")
            ->orWhere('name', 'like', "%{$request->input}%")
            ->orWhere('address', 'like', "%{$request->input}%")
            ->whereType('customers')->orderBy('name')
            ->whereIn('identity_document_type_id', $identity_document_type_id)
            ->whereIsEnabled()
            ->get()->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->number . ' - ' . $row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'identity_document_type_id' => $row->identity_document_type_id,
                    'identity_document_type_code' => $row->identity_document_type->code,
                    'addresses' => $row->addresses,
                    'address' =>  $row->address,
                    'seller_id' =>  $row->seller_id
                ];
            });

        return compact('customers');
    }

    public function validar_cpe($id)
    {
        try {
            $documents = Document::where('id', $id)->first();
            $api_url = config('app.api_peru_service_url');
            $token = config('app.api_peru_service_token');
            $company = Company::first();
            $response = Http::withoutVerifying()->withToken($token)->accept('application/json')->post($api_url . "/cpe", [
                'ruc_emisor' => $company->number, 'codigo_tipo_documento' => $documents->document_type_id, 'serie_documento' => $documents->series, 'numero_documento' => $documents->number, 'fecha_de_emision' => Carbon::parse($documents->date_of_issue)->format('Y-m-d'), 'total' => $documents->total
            ]);
            if ($response->ok()) {
                $body = $response->json();
                $data = $body['data'];
                $success = $body['success'];
                if ($success) {
                    $sales = Document::findOrFail($id);
                    if ($data["comprobante_estado_codigo"] == "0") {
                        $state_type = "01";
                    } else {
                        $description = $this->document_state[$data["comprobante_estado_codigo"]];
                        $state_type = StateType::where('description', 'like', "%{$description}%")->first();
                        $state_type = $state_type->id;
                    }
                    $sales->state_type_id = $state_type;
                    $sales->save();

                    return [
                        "success" => true,
                        "message" => $this->document_state[$data["comprobante_estado_codigo"]]
                    ];
                } else {
                    return [
                        "success" => false,
                        "message" => Functions::valueKeyInArray($body, 'message', "Ocurrió un problema")
                    ];
                }
            } else {
                return [
                    "success" => false,
                    "message" => "Intente nuevamente en unos minutos Sunat no responde..."
                ];
            }
        } catch (RequestException $exception) {
            return $exception->getResponse()->getBody();
        }
    }
    public function create($id = null)
    {
        if (auth()->user()->type == 'integrator')
            return redirect('/documents');
        $configuration = Configuration::first();
        $is_contingency = 0;


        if ($id != null) {
            $documentInfo = Document::where('id', $id)->first();
            $number = $documentInfo->number;
        } else {
            $number = 0;
        }

        return view('tenant.documents.form', compact('is_contingency', 'configuration', 'id', 'number'));
    }

    public function create_pos($id = null)
    {
        //if (auth()->user()->type == 'integrator')
        //    return redirect('/documents');
        $configuration = Configuration::first();
        $is_contingency = 0;
        //dd($configuration);
        return view('restaurant::documents.form', compact('is_contingency', 'configuration', 'id'));
    }

    public function create_tensu()
    {
        if (auth()->user()->type == 'integrator')
            return redirect('/documents');

        $is_contingency = 0;
        return view('tenant.documents.form_tensu', compact('is_contingency'));
    }


    public function tables()
    {
        $exchange_rate_sale = 1;
        $fecha_actual = Carbon::now();
        try {
            $exchange_rate_sale = ServiceData::exchange_rate();
        } catch (Exception $e) {
            $exchange_rate_sale  = 1;
        }
        $row_arqueo = Arqueo::where('fecha', $fecha_actual->format('Y-m-d'))->where('state', '1')->first();
        if ($row_arqueo != null) {
            $closebox = (bool) $row_arqueo->state;
        } else {
            $closebox = false;
        }
        $customers = $this->table('customers');
        $establishments = Establishment::where('id', auth()->user()->establishment_id)->get(); // Establishment::all();
        $series = collect(Series::all())->transform(function ($row) {
            return [
                'id' => $row->id,
                'contingency' => (bool) $row->contingency,
                'document_type_id' => $row->document_type_id,
                'establishment_id' => $row->establishment_id,
                'number' => $row->number
            ];
        });
        $configuration = Configuration::first();
        $document_types_invoice = DocumentType::whereIn('id', ['01', '03'])->where('active', '1')->get();
        $document_types_note = DocumentType::whereIn('id', ['07', '08'])->where('active', '1')->get();
        $note_credit_types = NoteCreditType::whereActive()->orderByDescription()->get();
        $note_debit_types = NoteDebitType::whereActive()->orderByDescription()->get();
        $currency_types = CurrencyType::whereActive()->get();
        $operation_types = OperationType::whereActive()->get();
        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->get();
        $charge_types = ChargeDiscountType::whereType('charge')->whereLevel('item')->get();
        $company = Company::active();
        $document_type_03_filter = config('tenant.document_type_03_filter');
        $user = auth()->user()->type;
        $users = User::all();
        $user_select = User::select('id')->where('id', auth()->user()->id)->first();
        $payment_method_types = PaymentMethodType::all();
        $business_turns = BusinessTurn::where('active', true)->get();
        $enabled_discount_global = config('tenant.enabled_discount_global');
        $is_client = $this->getIsClient();
        $select_first_document_type_03 = config('tenant.select_first_document_type_03');
        $payment_conditions = PaymentCondition::all();
        $sellers = Seller::where('active', true)
            ->where('establishment_id', auth()->user()->establishment_id)
            ->get();
        $document_types_guide = DocumentType::whereIn('id', ['09', '31'])->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'active' => (bool) $row->active,
                'short' => $row->short,
                'description' => ucfirst(mb_strtolower($row->description)),
            ];
        });

        // $cat_payment_method_types = CatPaymentMethodType::whereActive()->get();
        // $detraction_types = DetractionType::whereActive()->get();

        //        return compact('customers', 'establishments', 'series', 'document_types_invoice', 'document_types_note',
        //                       'note_credit_types', 'note_debit_types', 'currency_types', 'operation_types',
        //                       'discount_types', 'charge_types', 'company', 'document_type_03_filter',
        //                       'document_types_guide');

        // return compact('customers', 'establishments', 'series', 'document_types_invoice', 'document_types_note',
        //                'note_credit_types', 'note_debit_types', 'currency_types', 'operation_types',
        //                'discount_types', 'charge_types', 'company', 'document_type_03_filter');

        $payment_destinations = Cash::where('state', 1)->get()->transform(function ($cash) {

            return [
                'id' => $cash->id,
                'cash_id' => $cash->id,
                'description' => ($cash->reference_number) ? "CAJA GENERAL - {$cash->reference_number}" : "CAJA GENERAL",
            ];
        });
        // this->getPaymentDestinations();

        return compact(
            'sellers',
            'exchange_rate_sale',
            'customers',
            'establishments',
            'series',
            'document_types_invoice',
            'document_types_note',
            'note_credit_types',
            'note_debit_types',
            'currency_types',
            'operation_types',
            'discount_types',
            'charge_types',
            'company',
            'document_type_03_filter',
            'document_types_guide',
            'user',
            'users',
            'user_select',
            'payment_method_types',
            'enabled_discount_global',
            'business_turns',
            'is_client',
            'select_first_document_type_03',
            'payment_destinations',
            'payment_conditions',
            'closebox',
            'configuration'
        );
    }

    public function item_tables()
    {
        $items = $this->table('items');
        $categories = []; //Category::cascade();
        $affectation_igv_types = AffectationIgvType::whereActive()->get();
        $system_isc_types = SystemIscType::whereActive()->get();
        $price_types = PriceType::whereActive()->get();
        $operation_types = OperationType::whereActive()->get();
        $discount_types = ChargeDiscountType::whereType('discount')->whereLevel('item')->get();
        $charge_types = ChargeDiscountType::whereType('charge')->whereLevel('item')->get();
        $attribute_types = AttributeType::whereActive()->orderByDescription()->get();
        $is_client = $this->getIsClient();
        $row_rest = InventoryConfiguration::first();
        $restringir_stock = (bool)$row_rest->stock_control;
        return compact(
            'items',
            'categories',
            'affectation_igv_types',
            'system_isc_types',
            'price_types',
            'operation_types',
            'discount_types',
            'charge_types',
            'attribute_types',
            'is_client',
            'restringir_stock'
        );
    }

    public function table($table)
    {
        if ($table === 'customers') {
            $customers = Person::with('addresses')->whereType('customers')->whereIsEnabled()->orderBy('name')->get()->transform(function ($row) {

                return [
                    'id' => $row->id,
                    'description' => $row->number . ' - ' . $row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'identity_document_type_id' => $row->identity_document_type_id,
                    'identity_document_type_code' => $row->identity_document_type->code,
                    'addresses' => $row->addresses,
                    'address' =>  $row->address,
                    'seller_id' =>  $row->seller_id,
                ];
            });
            return $customers;
        }

        if ($table === 'prepayment_documents') {
            $prepayment_documents = Document::whereHasPrepayment()->get()->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->series . '-' . $row->number,
                    'series' => $row->series,
                    'number' => $row->number,
                    'document_type_id' => ($row->document_type_id == '01') ? '02' : '03',
                    'amount' => $row->total_value,
                    'total' => $row->total,

                ];
            });
            return $prepayment_documents;
        }

        if ($table === 'items') {

            $establishment_id = auth()->user()->establishment_id;
            $warehouse = ModuleWarehouse::where('establishment_id', $establishment_id)->first();

            $items_u = Item::whereWarehouse()->whereIsActive()->whereNotIsSet()->orderBy('description')->take(20)->get();
            $items_s = Item::where('unit_type_id', 'ZZ')->whereIsActive()->orderBy('description')->take(10)->get();
            $items = $items_u->merge($items_s);

            return collect($items)->transform(function ($row) use ($warehouse) {
                $detail = $this->getFullDescription($row, $warehouse);
                return [
                    'id' => $row->id,
                    'full_description' => $detail['full_description'],
                    'brand' => $detail['brand'],
                    'category' => $detail['category'],
                    'stock' => $detail['stock'],
                    'internal_id' => $row->internal_id,
                    'description' => $row->description,
                    'currency_type_id' => $row->currency_type_id,
                    'currency_type_symbol' => $row->currency_type->symbol,
                    'sale_unit_price' => round($row->sale_unit_price, 2),
                    'purchase_unit_price' => $row->purchase_unit_price,
                    'unit_type_id' => $row->unit_type_id,
                    'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                    'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                    'calculate_quantity' => (bool) $row->calculate_quantity,
                    'has_igv' => (bool) $row->has_igv,
                    'is_set' => (bool) $row->is_set,
                    'is_stock' => $row->is_stock,
                    'amount_plastic_bag_taxes' => $row->amount_plastic_bag_taxes,
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
                    'warehouses' => collect($row->warehouses)->transform(function ($row) use ($warehouse) {
                        return [
                            'warehouse_description' => $row->warehouse->description,
                            'stock' => $row->stock,
                            'warehouse_id' => $row->warehouse_id,
                            'checked' => ($row->warehouse_id == $warehouse->id) ? true : false,
                        ];
                    }),
                    'attributes' => $row->attributes ? $row->attributes : [],
                    'lots_group' => collect($row->lots_group)->transform(function ($row) {
                        return [
                            'id'  => $row->id,
                            'code' => $row->code,
                            'quantity' => $row->quantity,
                            'date_of_due' => $row->date_of_due,
                            'checked'  => false
                        ];
                    }),
                    'lots' => $row->item_lots->where('has_sale', false)->where('warehouse_id', $warehouse->id)->transform(function ($row) {
                        return [
                            'id' => $row->id,
                            'series' => $row->series,
                            'date' => $row->date,
                            'item_id' => $row->item_id,
                            'warehouse_id' => $row->warehouse_id,
                            'has_sale' => (bool)$row->has_sale,
                            'lot_code' => ($row->item_loteable_type) ? (isset($row->item_loteable->lot_code) ? $row->item_loteable->lot_code : null) : null
                        ];
                    }),
                    'lots_enabled' => (bool) $row->lots_enabled,
                    'series_enabled' => (bool) $row->series_enabled,

                ];
            });
            //            return $items;
        }

        return [];
    }

    public function getFullDescription($row, $warehouse)
    {

        $desc = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;
        $category = ($row->category) ? "{$row->category->name}" : "";
        $brand = ($row->brand) ? "{$row->brand->name}" : "";



        if ($row->unit_type_id != 'ZZ') {
            $warehouse_stock = ($row->warehouses && $warehouse) ? number_format($row->warehouses->where('warehouse_id', $warehouse->id)->first()->stock, 2) : 0;
            $stock = ($row->warehouses && $warehouse) ? "{$warehouse_stock}" : "";
        } else {
            $stock = '';
        }

        $desc = "{$desc} - {$brand}";

        return [
            'full_description' => $desc,
            'brand' => $brand,
            'category' => $category,
            'stock' => $stock,
        ];
    }
    public function getRecord($id)
    {
        $record = Document::find($id);
        return $record;
    }

    public function record($id)
    {
        //return Document::findOrFail($id);
        $record = new DocumentResource(Document::findOrFail($id));
        return $record;
    }
    public function record2($id)
    {
        $record = new DocumentResource2(Document::findOrFail($id));

        return $record;
    }
    public function store2(DocumentRequest $request)
    {

        $fact = DB::connection('tenant')->transaction(function () use ($request) {
            $facturalo = new Facturalo();


            $facturalo->save($request->all());
            $facturalo->createXmlUnsigned();
            $facturalo->signXmlUnsigned();
            $facturalo->updateHash();
            $facturalo->updateQr();
            $facturalo->createPdf();
            $facturalo->senderXmlSignedBill();

            return $facturalo;
        });

        $document = $fact->getDocument();
        $response = $fact->getResponse();
        $boxes    = Box::firstOrNew(['id' => 0]);
        $company = Company::first();
        $boxes->group_id = 1;
        $boxes->category_id = 1;
        $boxes->subcategory_id = 1;

        $boxes->amount = $boxes->amount + $request->input('total');
        $boxes->date = Carbon::parse($request->input('date_of_issue'))->format('Y-m-d');
        $boxes->type = '1';
        $boxes->state = '1';
        //$boxes->seller_id=$request->input('user_id');
        $boxes->user_id = auth()->user()->id;
        $document_save = Document::where('id', $document->id)->first();
        switch ($document_save->document_type_id) {
            case "01":
                $type_document = "FACTURA ELECTRONICA";
                break;
            case "03":
                $type_document = "BOLETA DE VENTA ELECTRONICA";
                break;
            case "07":
                $type_document = "NOTA DE CREDITO";
                break;
            case "08":
                $type_document = "NOTA DE DEBITO";
                break;
        }
        $documents_rows = $type_document . " N° " . $document_save->series . " - " . $document_save->number;
        $boxes->description = "VENTAS " . $documents_rows;
        $boxes->soap_type_id = $company->soap_type_id;
        $boxes->save();
        $establishment = Establishment::where('id', $document_save->establishment_id)->first();


        return [
            'success' => true,
            'data' => [
                'number' => $document->number_full,
                'filename' => $document->filename,
                'external_id' => $document->external_id,
                'state_type_id' => $document->state_type_id,
                'number_to_letter' => $document->number_to_letter,
                'hash' => $document->hash,
                'qr' => $document->qr,
                'token_user' => $document->token_user,
                'id' => $document->id,
                'format_printer' => $establishment->format_printer,
                'printer' => $establishment->printer,
                'printer_serve' => $establishment->printer_serve,
                'direct_printing' => $establishment->direct_printing,
                'print_ticket' => url('') . "/print/document/{$document_save->external_id}/ticket",
                'print_a4' => url('') . "/print/document/{$document_save->external_id}/a4",
                'print_a5' => url('') . "/print/document/{$document_save->external_id}/a5",
                'response' => $response

            ],
        ];
    }

    public function store(DocumentRequest $request)
    {


        $ids = [];
        if (key_exists('id', $request->all())) {
            $document_id = $request->id;

            $ids = Orden::where('document_id', $document_id)->pluck('id')->toArray();

            Orden::where('document_id', $document_id)->update(["document_id" => null]);
        }
        try {
            $fact = DB::connection('tenant')->transaction(function () use ($request) {
                $facturalo = new Facturalo();
                $facturalo->save($request->all());
                $facturalo->createXmlUnsigned();
                $facturalo->signXmlUnsigned();
                $facturalo->updateHash();
                $facturalo->updateQr();
                $facturalo->createPdf();
                $facturalo->senderXmlSignedBill();
                return $facturalo;
            });
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
        $document = $fact->getDocument();
        $this->associateSaleNoteToDocument($request, $document->id);
        Box::where('document_id', $document->id)->delete();
        // $Payments = DocumentPayment::where('document_id', $document->id)->first();

        $response = $fact->getResponse();
        $company = Company::first();
        //&& $request->afectar_caja === true
        $configuration = Configuration::first();
        if (!$request->has_related_sale_note && $request->variation == false && $request->payment_condition_id === "01") {
            if ($request->boxes) {
                $message="";
                foreach ($request->boxes as $currentBox) {
                    $method = $currentBox['method'];
                    $amount = $currentBox['amount'];
                    $operation_number = Functions::valueKeyInArray($currentBox, 'operation_number');
                    $bank_account_id = Functions::valueKeyInArray($currentBox, 'bank_account_id');
                    $bank_account_operation = Functions::valueKeyInArray($currentBox, 'number_operation');
                    $box = new Box;
                    $box->group_id = 1;
                    $box->operation_number = $operation_number;
                    $box->method = $method;
                    if($method == "Yape"|| $method == "PLIN"){
                        $message.= "Pago por ".$method." por S/".$amount."- N° Operación: ".$operation_number ?? "-";
                    }
                    $box->bank_account_id = $bank_account_id;
                    $box->bank_account_operation = $bank_account_operation;
                    $box->category_id = 1;
                    $box->subcategory_id = 1;
                    $box->amount = $amount;
                    $box->date = Carbon::parse($request->input('date_of_issue'))->format('Y-m-d');
                    $box->type = '1';
                    $box->state = '1';
                    $box->cash_id = $request->cash_id;
                    $box->orden_id =  $request->orden_id;
                    $box->document_id = $document->id;
                    $box->user_id = auth()->user()->id;
                    $box->establishment_id = auth()->user()->establishment_id;
                    $document_save = Document::where('id', $document->id)->first();
                    $document_save->cash_id = $request->cash_id;
                    switch ($document_save->document_type_id) {
                        case "01":
                            $type_document = "FACTURA ELECTRONICA";
                            break;
                        case "03":
                            $type_document = "BOLETA DE VENTA ELECTRONICA";
                            break;
                    }
                    $documents_rows = $type_document . " N° " . $document_save->series . " - " . $document_save->number;
                    $box->description = "VENTAS " . $documents_rows;
                    if ($bank_account_id) {
                        $bank_account = BankAccount::findOrFail($bank_account_id);
                        $bank_account->balance = $bank_account->balance + $currentBox['amount'];
                        $bank_account->save();
                        $box->description = "VENTAS " . $documents_rows . " - " . $bank_account->bank->description . " - " . $bank_account->currency_type->description;
                    }
                    $box->soap_type_id = $company->soap_type_id;
                    $box->soap_type_id = $company->soap_type_id;
                    $box->save();
                }
                if($configuration->send_whatsapp_digital_pay){
                
                    if($message){
                        $numbers = NumberActivity::all();
                        foreach ($numbers as $key => $number) {
                            (new WhatsappController)->sendMessage($message, $number->number);
                        }
                        (new WhatsappController)->sendMessage($message);
                    }
                }
            } else {
                if ($request->sale_note_id == null && $request->method_pay) {
                    $boxes    = Box::firstOrNew(['document_id' =>  $document->id]);
                    $boxes->group_id = 1;
                    $boxes->method = $request->method_pay;
                    $boxes->operation_number = $request->operation_number;
                    $boxes->category_id = 1;
                    $boxes->subcategory_id = 1;
                    $boxes->amount = $request->input('total_payment');
                    $boxes->date = Carbon::parse($request->input('date_of_issue'))->format('Y-m-d');
                    $boxes->type = '1';
                    $boxes->state = '1';
                    $boxes->cash_id = $request->cash_id;
                    $boxes->orden_id =  $request->orden_id;
                    $boxes->document_id = $document->id;
                    $boxes->user_id = auth()->user()->id;
                    $boxes->establishment_id = auth()->user()->establishment_id;
                    $document_save = Document::where('id', $document->id)->first();
                    switch ($document_save->document_type_id) {
                        case "01":
                            $type_document = "FACTURA ELECTRONICA";
                            break;
                        case "03":
                            $type_document = "BOLETA DE VENTA ELECTRONICA";
                            break;
                    }
                    $documents_rows = $type_document . " N° " . $document_save->series . " - " . $document_save->number;
                    $boxes->description = "VENTAS " . $documents_rows;
                    $boxes->soap_type_id = $company->soap_type_id;
                    $boxes->soap_type_id = $company->soap_type_id;
                    $boxes->save();
                }
            }
        }
        if ($request->orden_id != null) {
            $Orden = Orden::FindOrFail($request->orden_id);
            $Orden->document_id = $document->id;
            $Orden->status_orden_id = 4;
            $Orden->customer_id = $document->customer_id;
            $Orden->save();
            $document_orden = Document::FindOrFail($document->id);;
            $document_orden->orden_id = $request->orden_id;
            $document_orden->save();
            $orden_items = OrdenItem::where('orden_id', $request->orden_id)->get();
            foreach ($orden_items as $orden_item) {
                $orden_item->status_orden_id = 4;
                $orden_item->save();
                event(new OrdenReadyEvent($orden_item->id));
            }
        }
        if($request->orden_ids){
            $ids = $request->orden_ids;
            foreach ($ids as $id) {
                $Orden = Orden::findOrFail($id);
                $Orden->document_id = $document->id;
                $Orden->status_orden_id = 4;
                $Orden->customer_id = $document->customer_id;
                $Orden->save();
                $orden_items = OrdenItem::where('orden_id', $id)->get();
                foreach ($orden_items as $orden_item) {
                    $orden_item->status_orden_id = 4;
                    $orden_item->save();
                }
            }
        }
        if($request->is_list_credit){
            CreditList::where('customer_id', $document->customer_id)->update(['paid' => true]);
        }
        if($request->hotel_rent_item_ids){
            $hotel_rent_items = HotelRentItem::whereIn('id', $request->hotel_rent_item_ids)->get();
            foreach ($hotel_rent_items as $item) {
                $item->payment_status = "Pagado";
                $item->document = $document->id;
                $item->checkout_date = date('Y-m-d');
                $item->checkout_time = date('H:i:s');
                $item->save();
                $table = Table::where('id', $item->table_id)->first();
                $table->status_table_id = 5;
                $table->sendMessageDesocupied();
                $table->save();
                
            }
        }
        if($request->hotel_rent_id){
            $hotel_rent= HotelRent::findOrFail($request->hotel_rent_id);

            if($request->is_advance){
                HotelRentDocument::create([
                    'hotel_rent_id' => $hotel_rent->id,
                    'document_id' => $document->id,
                    'is_advance' => true,
                ]);
            }else{
                $hotel_rent_items = $hotel_rent->items;
                foreach ($hotel_rent_items as $item) {
                    $item->payment_status = "Pagado";
                    $table = Table::where('id', $item->table_id)->first();
                    $table->status_table_id = 5;
                    $table->sendMessageDesocupied();
                    $table->save();
                    $item->checkout_date = date('Y-m-d');
                    $item->checkout_time = date('H:i:s');
                    $item->save();
                }
                $hotel_rent->payment_status = "Pagado";
                $hotel_rent->document_id = $document->id;
                $hotel_rent->paid = 1;
                $hotel_rent->save();
            }
         
        
        }
        if (count($ids) != 0) {
            Orden::whereIn('id', $ids)->update(['document_id' => $document->id]);
        }
        if ($request->generar_document == "Si") {
            foreach ($request->items as $row_item) {
                if ($row_item['item']['is_stock'] == "No") {
                    $inventoryKardex = InventoryKardex::where('item_id', $row_item['item_id'])->get()->last();
                    $row_inventory = InventoryKardex::findOrFail($inventoryKardex->id);
                    $row_inventory->delete();
                }
            }
        }
        if ($request->sale_note_id) {
            $desc = "App\Models\SaleNote";
            SaleNoteItem::where('sale_note_id', $request->sale_note_id)->update(["inventory_kardex_id" => null]);
            InventoryKardex::where('inventory_kardexable_type', $desc)->where('inventory_kardexable_id', $request->sale_note_id)->delete();
        }
        $establishment = Establishment::where('id', $document->establishment_id)->first();
        event(new PrintEvent($document->id, $document->document_type_id, $request->printerOn, 0));
        return [
            'success' => true,
            'data' => [
                'number' => $document->number_full,
                'filename' => $document->filename,
                'external_id' => $document->external_id,
                'state_type_id' => $document->state_type_id,
                'number_to_letter' => $document->number_to_letter,
                'hash' => $document->hash,
                'qr' => $document->qr,
                'token_user' => $document->token_user,
                'id' => $document->id,
                'format_printer' => $establishment->format_printer,
                'printer' => $establishment->printer,
                'printer_serve' => $establishment->printer_serve,
                'direct_printing' => (bool) $establishment->direct_printing,
                'print_ticket' => url('') . "/print/document/{$document->external_id}/ticket",
                'print_a4' => url('') . "/print/document/{$document->external_id}/a4",
                'print_a5' => url('') . "/print/document/{$document->external_id}/a5",
                'response' => $response
            ],
        ];
    }

    public function reStore($document_id)
    {
        $fact = DB::connection('tenant')->transaction(function () use ($document_id) {
            $document = Document::find($document_id);

            $type = 'invoice';
            if ($document->document_type_id === '07') {
                $type = 'credit';
            }
            if ($document->document_type_id === '08') {
                $type = 'debit';
            }
            $facturalo = new Facturalo();
            $facturalo->setDocument($document);
            $facturalo->setType($type);
            $facturalo->createXmlUnsigned();
            $facturalo->signXmlUnsigned();
            $facturalo->updateHash();
            $facturalo->updateQr();
            $facturalo->updateSoap('02', $type);
            $facturalo->updateState('01');
            $facturalo->createPdf($document, $type, 'ticket');
            //            $facturalo->senderXmlSignedBill();
        });

        //        $document = $fact->getDocument();
        //        $response = $fact->getResponse();

        return [
            'success' => true,
            'message' => 'El documento se volvio a generar.',
        ];
    }
    public function updateBox($id, $Payments, $method_payment, $total_payment)
    {
        $box = Box::where('document_id', $id)->first();
        $documents = Document::where('id', $id)->first();
        $payment = PaymentMethodType::where('id', $method_payment)->first();
        $method = $payment->description;
        // }
        if ($method_payment == "01") {
            if ($box == null) {

                if ($documents != null) {
                    $document_saves = Document::where('id', $id)->first();
                    if ($document_saves->document_type_id == "01") {
                        $type_document = "PAGO DE FACTURA N° ";
                    } else {
                        if ($document_saves->document_type_id == "03") {
                            $type_document = "BOLETA DE VENTA N° ";
                        }
                    }
                    $boxes = Box::firstOrNew(['document_id' => $id]);
                    $company = Company::first();
                    $boxes->group_id = 1;
                    $boxes->category_id = 1;
                    $boxes->subcategory_id = 1;
                    $boxes->amount = $total_payment;
                    $boxes->date = $Payments->date_of_payment;
                    $boxes->type = '1';
                    $boxes->state = '1';
                    $boxes->method = $method;
                    $boxes->user_id = "1";
                    $boxes->state = '1';
                    $type_document = $type_document . " N° " . $documents->series . " " . $documents->number;
                    $boxes->description = "PAGO DE " . $type_document;
                    $boxes->soap_type_id = $company->soap_type_id;
                    $boxes->save();
                }
                //Insertar
            } else {
                //Actualizar
                $payment = PaymentMethodType::where('id', $method_payment)->first();
                $boxes = Box::findOrFail($box->id);
                $boxes->amount = $total_payment;
                $payment->description;
                $boxes->method = $method;
                $boxes->date = $Payments->date_of_payment;
                $boxes->document_id = null;
                $boxes->save();
            }
        }
    }
    public function email(DocumentEmailRequest $request)
    {
        $company = Company::active();
        $document = Document::find($request->input('id'));
        $customer_email = $request->input('customer_email');
        Configuration::setConfigSmtpMail();
        Mail::to($customer_email)->send(new DocumentEmail($company, $document));

        return [
            'success' => true
        ];
    }

    public function send($document_id)
    {
        $document = Document::find($document_id);

        $fact = DB::connection('tenant')->transaction(function () use ($document) {
            $facturalo = new Facturalo();
            $facturalo->setDocument($document);
            $facturalo->loadXmlSigned();
            $facturalo->onlySenderXmlSignedBill();
            return $facturalo;
        });

        $response = $fact->getResponse();

        return [
            'success' => true,
            'message' => $response['description'],
        ];
    }

    public function consultarcdr($document_id)
    {
        $document = Document::find($document_id);

        $fact = DB::connection('tenant')->transaction(function () use ($document) {
            $facturalo = new Facturalo();
            $facturalo->setDocument($document);
            $facturalo->consultCdr();
        });

        $response = $fact->getResponse();

        return [
            'success' => true,
            'message' => $response['description'],
        ];
    }

    public function sendServer($document_id, $query = false)
    {
        $document = Document::find($document_id);
        // $bearer = config('tenant.token_server');
        // $api_url = config('tenant.url_server');
        $bearer = $this->getTokenServer();
        $api_url = $this->getUrlServer();
        $client = new Client(['base_uri' => $api_url, 'verify' => false]);

        // $zipFly = new ZipFly();
        if (!$document->data_json) throw new Exception("Campo data_json nulo o inválido - Comprobante: {$document->fullnumber}");

        $data_json = (array) $document->data_json;
        $data_json['numero_documento'] = $document->number;
        $data_json['external_id'] = $document->external_id;
        $data_json['hash'] = $document->hash;
        $data_json['qr'] = $document->qr;
        $data_json['query'] = $query;
        $data_json['file_xml_signed'] = base64_encode($this->getStorage($document->filename, 'signed'));
        $data_json['file_pdf'] = base64_encode($this->getStorage($document->filename, 'pdf'));
        // dd($data_json);
        $res = $client->post('/api/documents_server', [
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . $bearer,
                'Accept' => 'application/json',
            ],
            'form_params' => $data_json
        ]);

        $response = json_decode($res->getBody()->getContents(), true);

        if ($response['success']) {
            $document->send_server = true;
            $document->save();
        }

        return $response;
    }
    public function getSeriesByItem($item_id)
    {
        return ItemLot::where('item_id', $item_id)->where('has_sale', 0)->where('state', 'Activo')->count();
    }
    public function updateStock($id, $is_set = false)
    {
        if ($is_set == true) {
            $ItemSet = ItemSet::where('item_id', $id)->get();

            foreach ($ItemSet as $row_item) {

                $saldo_final = ItemWarehouse::where('item_id', $row_item->individual_item_id)->first();

                $saldo_inicial = floatval(Inventory::where('item_id', $row_item->individual_item_id)->sum('quantity'));
                //Compras
                $compras = floatval(PurchaseItem::where('item_id', $row_item->individual_item_id)->sum('quantity'));
                $sale_note = DB::connection('tenant')->table('sale_note_items')
                    ->join('sale_notes', 'sale_notes.id', '=', 'sale_note_items.sale_note_id')
                    ->select('sale_note_items.quantity', 'sale_note_items.sale_note_id')
                    ->where('item_id', $row_item->individual_item_id)
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
                    ->where('item_id', $row_item->individual_item_id)
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

                DB::connection('tenant')->table('items')->where('id', $row_item->individual_item_id)->update(['stock' => $saldo_final->stock - abs($saldo_stock)]);
                DB::connection('tenant')->table('item_warehouse')->where('item_id', $row_item->individual_item_id)->update(['stock' => $saldo_final->stock - abs($saldo_stock)]);
            }
        } else {
            // $saldo_stock = 0.00;
            // $saldo_final=ItemWarehouse::where('item_id',$id)->first();
            // //Saldo Inicial
            // $saldo_inicial = floatval(Inventory::where('item_id', $id)->sum('quantity'));
            // //Compras
            // $compras = floatval(PurchaseItem::where('item_id', $id)->sum('quantity'));
            // $sale_note = DB::connection('tenant')->table('sale_note_items')
            //     ->join('sale_notes', 'sale_notes.id', '=', 'sale_note_items.sale_note_id')
            //     ->select('sale_note_items.quantity', 'sale_note_items.sale_note_id')
            //     ->where('item_id', $id)
            //     ->whereRaw("JSON_EXTRACT(sale_note_items.item, '$.is_stock') = 'Si'")
            //     ->where('sale_notes.state_type_id', "!=", "11")
            //     ->get();
            // $sale_note = $sale_note->sum('quantity');
            // $document = DB::connection('tenant')->table('document_items')
            //     //->select(DB::raw("sum(document_items.quantity) as quantity"))
            //     ->select('document_items.quantity', 'document_items.document_id')
            //     ->join('documents', 'documents.id', '=', 'document_items.document_id')
            //     ->where('documents.state_type_id', "!=", "11")
            //     ->whereRaw("JSON_EXTRACT(document_items.item, '$.is_stock') = 'Si'")
            //     ->where('item_id', $id)
            //     ->get();
            // $document = $document->sum('quantity');

            // if ($document != null) {
            //     if ($document != null) {
            //         $document = $document;
            //     } else {
            //         $document = 0;
            //     }
            // } else {
            //     $document = 0;
            // }
            // if ($sale_note != null) {
            //     if ($sale_note != null) {
            //         $sale_note = $sale_note;
            //     } else {
            //         $sale_note = 0;
            //     }
            // } else {
            //     $sale_note = 0;
            // }
            // $saldo_stock = ($saldo_inicial + $compras) - ($sale_note + $document);

            // DB::connection('tenant')->table('items')->where('id', $id)->update(['stock' => $saldo_final->stock-abs($saldo_stock)]);
            // DB::connection('tenant')->table('item_warehouse')->where('item_id', $id)->update(['stock' => $saldo_final->stock - abs($saldo_stock)]);
        }
    }

    public function checkServer($document_id)
    {
        $document = Document::find($document_id);
        $bearer = $this->getTokenServer();
        $api_url = $this->getUrlServer();

        $client = new Client(['base_uri' => $api_url, 'verify' => false]);

        $res = $client->get('/api/document_check_server/' . $document->external_id, [
            'headers' => [
                'Authorization' => 'Bearer ' . $bearer,
                'Accept' => 'application/json',
            ],
        ]);

        $response = json_decode($res->getBody()->getContents(), true);

        if ($response['success']) {
            $state_type_id = $response['state_type_id'];
            $document->state_type_id = $state_type_id;
            $document->save();

            if ($state_type_id === '05') {
                $this->uploadStorage($document->filename, base64_decode($response['file_cdr']), 'cdr');
            }
        }

        return $response;
    }

    public function searchCustomerById($id)
    {

        $customers = Person::with('addresses')->whereType('customers')
            ->where('id', $id)
            ->get()->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->number . ' - ' . $row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'phone' => $row->telephone,
                    'identity_document_type_id' => $row->identity_document_type_id,
                    'identity_document_type_code' => $row->identity_document_type->code,
                    'addresses' => $row->addresses,
                    'address' =>  $row->address,
                    'client_zone_id' => $row->client_zone_id,
                ];
            });

        return compact('customers');
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

    public function changeToRegisteredStatus($document_id)
    {
        $document = Document::find($document_id);
        if ($document->state_type_id === '01') {
            $document->state_type_id = '05';
            $document->save();

            return [
                'success' => true,
                'message' => 'El estado del documento fue actualizado.',
            ];
        }
    }

    public function excel(Request $request)
    {
        $records = $this->getRecords($request)->get();
        $establishment = Establishment::first();
        $company = Company::active();
        return (new DocumentExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Reporte_Ventas_' . Carbon::now() . '.xlsx');
    }
    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new DocumentsImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }

    public function importTwoFormat(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new DocumentsImportTwoFormat();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }

    public function messageLockedEmission()
    {

        $configuration = Configuration::first();
        // $quantity_documents = Document::count();
        $quantity_documents = $configuration->quantity_documents;

        if ($configuration->limit_documents !== 0 && ($quantity_documents > $configuration->limit_documents))
            return [
                'success' => false,
                'message' => 'Alcanzó el límite permitido para la emisión de comprobantes',
            ];


        return [
            'success' => true,
            'message' => '',
        ];
    }

    public function getRecords($request)
    {
        $d_end = $request->d_end;
        $d_start = $request->d_start;
        $date_of_issue = $request->date_of_issue;
        $document_type_id = $request->document_type_id;
        $state_type_id = $request->state_type_id;
        $seller_id = $request->seller_id;
        $number = $request->number;
        $series = $request->series;
        $company = Company::first();
        $soap_type_id = $company->soap_type_id;
        $pending_payment = ($request->pending_payment == "true") ? true : false;
        $customer_id = $request->customer_id;
        $item_id = $request->item_id;
        $category_id = $request->category_id;
        $payment_condition_id = $request->payment_condition_id;
        if ($d_start && $d_end) {
            $records = Document::where('document_type_id', 'like', '%' . $document_type_id . '%')
                ->where('soap_type_id', '=', $soap_type_id)
                ->where('series', 'like', '%' . $series . '%')
                ->where('number', 'like', '%' . $number . '%')
                // ->where('establishment_id', auth()->user()->establishment_id)
                ->where('state_type_id', 'like', '%' . $state_type_id . '%')
                ->whereBetween('date_of_issue', [$d_start, $d_end])

                ->OrderBy('id', 'desc')
                ->OrderBy('number', 'desc')
                ->latest();
        } else {
            $records = Document::where('date_of_issue', 'like', '%' . $date_of_issue . '%')
                // ->where('establishment_id', auth()->user()->establishment_id)
                ->where('soap_type_id', '=', $soap_type_id)
                ->where('document_type_id', 'like', '%' . $document_type_id . '%')
                ->where('state_type_id', 'like', '%' . $state_type_id . '%')
                ->where('series', 'like', '%' . $series . '%')
                ->where('number', 'like', '%' . $number . '%')
                ->OrderBy('id', 'desc')
                ->OrderBy('number', 'desc')
                ->latest();
        }
        $roleService = new RoleService;

        if (!$roleService->isAccountant(auth()->user()->worker_type_id) && !(auth()->user()->type != "superadmin" || auth()->user()->type != "admin")) {


            $records = $records->where('establishment_id', auth()->user()->establishment_id)->whereTypeUser();
        }
        if ($pending_payment) {
            $records = $records->where('payment_condition_id', '02')
                ->where(function ($query) {
                    $query->doesntHave('boxes')
                        ->orWhere(function ($subquery) {
                            $subquery->whereExists(function ($innerQuery) {
                                $innerQuery->select(DB::raw('1'))
                                    ->from('boxes')
                                    ->whereRaw('documents.id = boxes.document_id')
                                    ->groupBy('boxes.document_id')
                                    ->havingRaw('SUM(boxes.amount) != documents.total');
                            });
                        });
                });
        }


        if ($customer_id) {
            $records = $records->where('customer_id', $customer_id);
        }
        if ($payment_condition_id) {
            $records = $records->where('payment_condition_id', $payment_condition_id);
        }

        if ($item_id) {
            $records = $records->whereHas('items', function ($query) use ($item_id) {
                $query->where('item_id', $item_id);
            });
        }
        if ($seller_id) {
            $records = $records->where('seller_id', $seller_id);
        }
        if ($category_id) {

            $records = $records->whereHas('items', function ($query) use ($category_id) {
                $query->whereHas('relation_item', function ($q) use ($category_id) {
                    $q->where('category_id', $category_id);
                });
            });
        }

        return $records;
    }
    private function associateSaleNoteToDocument(Request $request, int $documentId)
    {
        if ($request->sale_note_id) {
            SaleNote::where('id', $request->sale_note_id)
                ->update(['document_id' => $documentId]);
        }
        $notes = $request->sale_notes_relateds;
        if ($notes) {
            foreach ($notes as $note) {
                //si note es un numero 
                if (is_numeric($note)) {
                    $sale_note_id = $note;
                    if ($sale_note_id) {
                        $sale_note = SaleNote::find($sale_note_id);
                        if (!empty($sale_note)) {
                            $sale_note->document_id = $documentId;
                            $sale_note->push();
                        }
                    }
                } else {
                    $sale_note_id = $note['id'] ?? null;
                    if ($sale_note_id) {
                        $sale_note = SaleNote::find($sale_note_id);
                        if (!empty($sale_note)) {
                            $sale_note->document_id = $documentId;
                            $sale_note->push();
                        }
                    }
                }
            }
        }
    }
    public function data_table()
    {

        $customers = $this->table('customers');
        $items = $this->getItems();
        $sellers = Seller::all();
        $categories = CategoryItem::orderBy('name')->get();
        $state_types = StateType::get();
        $document_types = DocumentType::whereIn('id', ['01', '03', '07', '08'])->get();
        $series = Series::whereIn('document_type_id', ['01', '03', '07', '08'])->get();
        $establishments = Establishment::where('id', auth()->user()->establishment_id)->get(); // Establishment::all();
        $payment_conditions = PaymentCondition::all();
        return compact('customers', 'sellers', 'payment_conditions', 'document_types', 'series', 'establishments', 'state_types', 'items', 'categories');
    }


    public function getItems()
    {

        $items = Item::orderBy('description')->take(20)->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => ($row->internal_id) ? "{$row->internal_id} - {$row->description}" : $row->description,
            ];
        });

        return $items;
    }

    public function getDataTableItem(Request $request)
    {

        $items = Item::where(function ($query) use ($request) {
            $query->where('description', 'like', "%{$request->input}%")
                ->orWhere('internal_id', 'like', "%{$request->input}%");
        });
        if ($request->series) {
            $items = $items->where('series_enabled', 1);
        }

        if ($request->service) {
            $items = $items->where('unit_type_id', 'ZZ');
        }
        $items =  $items->orderBy('description')
            ->get()->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'max_quantity' => $row->max_quantity,
                    'max_quantity_description' => $row->max_quantity_description,
                    'unit_type_description' => $row->unit_type->description,
                    'series_enabled' => $row->series_enabled,
                    'description' => ($row->internal_id) ? "{$row->internal_id} - {$row->description}" : $row->description,
                    'sale_unit_price' => $row->sale_unit_price,

                ];
            });

        return $items;
    }


    private function updateMaxCountPayments($value)
    {
        if ($value > $this->max_count_payment) {
            $this->max_count_payment = $value;
        }
        // $this->max_count_payment = 20 ;//( $value > $this->max_count_payment) ? $value : $this->$max_count_payment;
    }

    private function transformReportPayment($resource)
    {

        $records = $resource->transform(function ($row) {

            $total_paid = collect($row->payments)->sum('payment');
            $total = $row->total;
            $total_difference = round($total - $total_paid, 2);

            $this->updateMaxCountPayments($row->payments->count());

            return (object)[

                'id' => $row->id,
                'ruc' => $row->customer->number,
                // 'date' =>  $row->date_of_issue->format('Y-m-d'),
                // 'date' =>  $row->date_of_issue,
                'date' =>  \Carbon\Carbon::parse($row->date_of_issue)->format('d-m-Y'),
                'invoice' => $row->number_full,
                'comercial_name' => $row->customer->trade_name,
                'business_name' => $row->customer->name,
                'zone' => $row->customer->department->description,
                'total' => number_format($row->total, 2, ".", ""),

                'payments' => $row->payments,

                /*'payment1' =>  ( isset($row->payments[0]) ) ?  number_format($row->payments[0]->payment, 2) : '',
                'payment2' =>  ( isset($row->payments[1]) ) ?  number_format($row->payments[1]->payment, 2) : '',
                'payment3' =>   ( isset($row->payments[2]) ) ?  number_format($row->payments[2]->payment, 2) : '',
                'payment4' =>   ( isset($row->payments[3]) ) ?  number_format($row->payments[3]->payment, 2) : '', */

                'balance' => $total_difference,
                'person_type' => isset($row->person->person_type->description) ? $row->person->person_type->description : '',
                'department' => $row->customer->department->description,
                'district' => $row->customer->district->description,

                /*'reference1' => ( isset($row->payments[0]) ) ?  $row->payments[0]->reference : '',
                'reference2' =>  ( isset($row->payments[1]) ) ?  $row->payments[1]->reference : '',
                'reference3' =>  ( isset($row->payments[2]) ) ?  $row->payments[2]->reference : '',
                'reference4' =>  ( isset($row->payments[3]) ) ?  $row->payments[3]->reference : '', */
            ];
        });

        return $records;
    }

    public function report_payments()
    {

        $records = Document::get();

        $source =  $this->transformReportPayment($records);


        return (new PaymentExport)
            ->records($source)
            ->payment_count($this->max_count_payment)
            ->download('Reporte_Pagos_' . Carbon::now() . '.xlsx');
    }

    public function destroyDocument($document_id)
    {
        try {
            $date_now = Carbon::now()->format('Y-m-d');

            $deleted = DB::connection('tenant')->transaction(function () use ($document_id, $date_now) {

                $record = Document::findOrFail($document_id);
                $establishment_id = $record->establishment_id;
                $date_of_issue = $record->date_of_issue;
                $issued_date = Carbon::parse($date_of_issue);
                $date_now = Carbon::now();
                $date_now->setTime(0, 0, 0);
                $two_days_ago = $date_now->copy()->subDays(2);
                $same_date = $issued_date >= $two_days_ago && $issued_date <= $date_now;
                //si issued_date es mayor al dia de hoy
                if ($issued_date > $date_now) {
                    $same_date = true;
                }
                if ($same_date) {
                    $this->deleteAllPayments($record->payments);
                    $record->state_type_id = "11";
                    $items = $record->items;
                    foreach ($items as $it) {
                        $lots = $it->item->lots;
                        foreach ($lots as $lot) {
                            ItemLot::find($lot->id)->update(["has_sale" => 0]);
                        }
                        $quantity = $it->quantity;
                        if (isset($it->item->has_unit_type)) {
                            $unit_type = ItemUnitType::where('item_id', $it->item_id)
                                ->where('description', $it->item->has_unit_type)->first();
                            if ($unit_type) {

                                $quantity = $quantity * $unit_type->quantity_unit;
                            }
                        }
                        // $warehouse = Warehouse::where('establishment_id', $establishment_id)->first();
                        // $warehouse_id = ($warehouse) ? $warehouse->id : null;
                        // ItemWarehouse::where('item_id', $it->item_id)->where('warehouse_id', $warehouse_id)->increment('stock', $quantity);
                    }
                    Box::where('document_id', $document_id)->delete();
                    $orden = Orden::where('document_id', $document_id)->first();
                    $desc = "App\Models\Tenant\Document";
                    InventoryKardex::where("inventory_kardexable_type", $desc)->where("inventory_kardexable_id", $document_id)->delete();
                    $record->save();

                    if ($orden) {
                        OrdenItem::where('orden_id', $orden->id)->update(["status_orden_id" => 5]);
                        $orden->status_orden_id = 5;
                        $orden->save();
                    }
                    return true;
                }
                return false;
            });
            return [
                'success' => $deleted,
                'message' => $deleted ? 'Documento anulado con exito ' : 'El documento no se puede eliminar, debido a que tiene mas de dos días de emitido. ' . $date_now
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El Documento esta siendo usada por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar el Documento'];
        }
    }

    public function storeCategories(CategoryRequest $request)
    {
        $id = $request->input('id');
        $category = CategoryItem::firstOrNew(['id' => $id]);
        $category->fill($request->all());
        $category->save();


        return [
            'success' => true,
            'message' => ($id) ? 'Categoría editada con éxito' : 'Categoría registrada con éxito',
            'data' => $category

        ];
    }

    public function storeBrands(BrandRequest $request)
    {
        $id = $request->input('id');
        $brand = Brand::firstOrNew(['id' => $id]);
        $brand->fill($request->all());
        $brand->save();


        return [
            'success' => true,
            'message' => ($id) ? 'Marca editada con éxito' : 'Marca registrada con éxito',
            'data' => $brand
        ];
    }
}
