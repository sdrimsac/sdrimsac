<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Nexmo\Account\Price;
use App\Models\Tenant\Box;
use App\Models\Tenant\Item;
use App\Models\Tenant\User;
use Illuminate\Support\Str;
use App\Traits\OfflineTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\Tenant\Person;
use App\Models\Tenant\Series;
use App\Exports\PaymentExport;
use App\Models\Tenant\Company;
use Modules\Item\Models\Brand;
use App\Models\Tenant\Document;
use App\CoreFacturalo\Facturalo;
use App\CoreFacturalo\Helpers\Number\NumberLetter;
use App\Imports\DocumentsImport;
use App\Models\Tenant\StateType;
use App\Models\Tenant\Warehouse;
use Modules\Item\Models\CategoryItem;
use App\Mail\DocumentEmail;
use Illuminate\Support\Facades\DB;
use App\CoreFacturalo\WS\Zip\ZipFly;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Models\Tenant\PaymentMethodType;
use App\Imports\DocumentsImportTwoFormat;
use App\Models\Tenant\Catalogs\PriceType;
use Modules\Finance\Traits\FinanceTrait;
use App\Models\Tenant\Catalogs\CurrencyType;
use App\Models\Tenant\Catalogs\DocumentType;
use Modules\Item\Http\Requests\BrandRequest;
use App\Http\Requests\DocumentRequest;
use App\Models\Tenant\Catalogs\AttributeType;
use App\Models\Tenant\Catalogs\NoteDebitType;
use App\Models\Tenant\Catalogs\OperationType;
use App\Models\Tenant\Catalogs\SystemIscType;
use Modules\BusinessTurn\Models\BusinessTurn;
use App\Models\Tenant\Catalogs\DetractionType;
use App\Models\Tenant\Catalogs\NoteCreditType;
use App\Http\Resources\DocumentResource;
use Modules\Item\Http\Requests\CategoryRequest;
use App\Http\Requests\DocumentEmailRequest;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Catalogs\ChargeDiscountType;
use App\Http\Requests\DocumentVoidedRequest;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\CoreFacturalo\Requests\Api\Transform\Common\PersonTransform;
use App\CoreFacturalo\Requests\Api\Validation\DocumentValidation;
use App\CoreFacturalo\Requests\Inputs\DocumentInput;
use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Http\Resources\Tenant\Api\DocumentCollection;
use Modules\Inventory\Models\Warehouse as ModuleWarehouse;

use App\Models\Tenant\Catalogs\PaymentMethodType as CatPaymentMethodType;
use App\Services\RoleService;
use Facades\App\Http\Controllers\DocumentController as DocumentControllerSend;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    use StorageDocument;

    public function __construct()
    {
        $this->middleware('input.request:document,api', ['only' => ['store', 'storeServer']]);
    }
    /**
     * Store a file in storage.
     *
     * @param Request $request
     * @return array
     */
    public function storeFile(Request $request)
    {
        if ($request->header('token') !== 'toQB7pooyxV7GoWN008rXGMp4WAOGuSGo') {
            return [
                'success' => false,
                'message' => 'No autorizado',
            ];
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            //if extension is not txt or json return error
            if ($extension !== 'txt' && $extension !== 'json') {
                return [
                    'success' => false,
                    'message' => 'El archivo no es válido',
                ];
            }
            $current = Carbon::now();
            $current = $current->format('Y-m-d H:i:s');
            $current = str_replace(' ', '', $current);
            $current = str_replace('-', '', $current);
            $current = str_replace(':', '', $current);
            $current = str_replace('.', '', $current);
            $name = $current . '_' . Str::random(8);
            $fileName = $name . '.' . $extension;
            $file->storeAs('red_salud', $fileName, 'public');

            return [
                'success' => true,

            ];
        }

        return [
            'success' => false,
            'message' => 'No se ha enviado un archivo',
        ];
    }
    private static function items($inputs)
    {
        $document = $inputs['documento'];
        if (key_exists('detalle', $inputs)) {
            $items = [];
            foreach ($inputs['detalle'] as $row) {
                $quantity = $row['cantidadItem'];
                $price = $row['precioItem'];
                $total = $quantity * $price;
                $items[] = [
                    'internal_id' => isset($row['codItem']) ? $row['codItem'] : '',
                    'description' => $row['nombreItem'],
                    'name' => null,
                    'second_name' => null,
                    'item_type_id' => '01',
                    'item_code' => Functions::valueKeyInArray($row, 'codItem'),
                    'item_code_gs1' => null,
                    'unit_type_id' => strtoupper($row['unidadMedidaItem']),
                    'currency_type_id' => $document['tipoMoneda'],
                    'name_product_pdf' => null,
                    'quantity' => Functions::valueKeyInArray($row, 'cantidadItem'),
                    'unit_value' => Functions::valueKeyInArray($row, 'precioItemSinIgv'),
                    'price_type_id' => null,
                    'unit_price' => Functions::valueKeyInArray($row, 'precioItem'),
                    'affectation_igv_type_id' => Functions::valueKeyInArray($row, 'codAfectacionIgv'),
                    'total_base_igv' => Functions::valueKeyInArray($row, 'precioItemSinIgv'),
                    'percentage_igv' => 18,
                    'total_igv' => Functions::valueKeyInArray($row, 'montoIgv'),
                    'system_isc_type_id' => null,
                    'total_base_isc' => 0,
                    'percentage_isc' => null,
                    'total_isc' => 0,
                    'total_base_other_taxes' => 0,
                    'percentage_other_taxes' => 0,
                    'total_other_taxes' => 0,
                    'total_plastic_bag_taxes' => 0,
                    'total_taxes' => Functions::valueKeyInArray($row, 'montoIgv'),
                    'total_value' => Functions::valueKeyInArray($row, 'precioItemSinIgv'),
                    'total_charge' => 0,
                    'total_discount' => 0,
                    'total' => $total,
                    'attributes' => null,
                    'discounts' => null,
                    'charges' => null,
                    'additional_information' => Functions::valueKeyInArray($row, 'informacion_adicional'),

                ];
            }

            return $items;
        }
        return null;
    }
    function transform_document($inputs)
    {
        $document = $inputs['documento'];
        $total = $document['mntTotal'];
        //redondeo de totales
        $total_rounded = round($total, 2);
        $additional = $inputs['datosAdicionales'];
        // $totals = $inputs['totales'];
        $inputs_transform = [
            'series' => Functions::valueKeyInArray($document, 'serie'),
            'user_id' => Functions::valueKeyInArray($inputs, 1),
            'afectar_caja' => false,
            'method_pay' => 'Efectivo',
            'printerOn' => false,
            'number' => Functions::valueKeyInArray($document, 'correlativo'),
            'date_of_issue' => Functions::valueKeyInArray($inputs, 'fechaEmision'),
            'time_of_issue' => Functions::valueKeyInArray($additional, 'hora'),
            'document_type_id' => Functions::valueKeyInArray($inputs, 'tipoDocumento'),
            'currency_type_id' => Functions::valueKeyInArray($document, 'tipoMoneda'),
            'exchange_rate_sale' => 1,
            'purchase_order' => null,
            'observacion' => null,
            //            'establishment' => EstablishmentTransform::transform($inputs['datos_del_emisor']),
            'customer' => PersonTransform::transformSalud($document),
            'operation_type_id' => '0101',
            'total_prepayment' => 0,
            'total_discount' => 0,
            'total_charge' => 0,
            'total_exportation' => 0,
            'total_free' => 0,
            'total_taxed' => Functions::valueKeyInArray($document, 'mntNeto'),
            'total_taxes' => Functions::valueKeyInArray($document, 'mntTotalIgv'),
            'total_unaffected' => 0,
            'total_exonerated' => 0,
            'total_igv' => Functions::valueKeyInArray($document, 'mntTotalIgv'),
            'total_base_isc' => Functions::valueKeyInArray($document, 'mntNeto'),
            'total_isc' => 0,
            'total_base_other_taxes' => 0,
            'total_other_taxes' => 0,
            'total_plastic_bag_taxes' => 0,
            'total_value' => Functions::valueKeyInArray($document, 'mntNeto'),
            'total' => Functions::valueKeyInArray($document, 'mntTotal'),
            'total_rounded' => $total_rounded,
            //  'tasadefault' => $inputs['tasadefault'],
            'total_payment' => Functions::valueKeyInArray($document, 'mntTotal'),
            'has_prepayment' => false,
            'items' => self::items($inputs),
            'charges' => null,
            'discounts' => null,
            'detraction' => null,
            'perception' => null,
            'prepayments' => null,
            'guides' => null,
            'related' => null,
            // 'legends' => [
            //     [
            //         'code' => '1000',
            //         'value' => Functions::valueKeyInArray($inputs, 'leyenda', 'SON: ' . NumberLetter::convertToLetter($document['mntTotal']))
            //     ]
            // ],
            'additional_information' => null,
            'actions' => null,
            'hotel' => [],
            'transport' => [],
            // 'payments' => self::payments($inputs),
            // 'data_json' => $inputs,
            'fee' => [],
            'payment_condition_id' => '01',
        ];

        return $inputs_transform;
    }
    public function storeZip(Request $request)
    {

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            //if extension is not txt or json return error
            if ($extension !== 'zip') {
                return [
                    'success' => false,
                    'message' => 'El archivo no es válido',
                ];
            }
            $current = Carbon::now();
            $current = $current->format('Y-m-d H:i:s');
            $current = str_replace(' ', '', $current);
            $current = str_replace('-', '', $current);
            $current = str_replace(':', '', $current);
            $current = str_replace('.', '', $current);
            $name = $current . '_' . Str::random(8);
            $fileName = $name . '.' . $extension;
            $file->storeAs('red_salud', $fileName, 'public');
            $zip = new \ZipArchive;
            $res = $zip->open(storage_path('app/public/red_salud/' . $fileName));
            if ($res === TRUE) {
                // $zip->extractTo(storage_path('app/public/red_salud/'));
                //crear un nombre random y extraer los archivos en la carpeta con ese nombre
                $current = Carbon::now();
                $current = $current->format('Y-m-d H:i:s');
                $current = str_replace(' ', '', $current);
                $current = str_replace('-', '', $current);
                $current = str_replace(':', '', $current);
                $current = str_replace('.', '', $current);
                $name = $current . '_' . Str::random(8);
                $zip->extractTo(storage_path('app/public/red_salud/' . $name));
                $zip->close();
                $files = scandir(storage_path('app/public/red_salud/' . $name));

                $files = array_diff($files, array('.', '..'));
                $files = array_values($files);
                usort($files, function ($a, $b) {
                    $a = intval(str_replace('Registro_', '', str_replace('.txt', '', $a)));
                    $b = intval(str_replace('Registro_', '', str_replace('.txt', '', $b)));
                    return $a - $b;
                });
                // Log::info(json_encode($files));
                $txts = [];
                foreach ($files as $file) {
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    if ($extension === 'txt') {
                            $path =  storage_path('app/public/red_salud/' . $name . '/' . $file);
                            if (file_exists($path) && is_readable($path)) {
                                $document = file_get_contents($path);
                                $document = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $document);
                                $document = str_replace('�', '', $document);
                                $document = json_decode($document, true);
                                $document_transform = self::transform_document($document);
                                $document_validated = DocumentValidation::validationSalud($document_transform);
                                $document_input = DocumentInput::set($document_validated);
                                $result = $this->storeTransform($document_input);
                                // return $result;
                            } else {
                                Log::info('no existe: ' . $path);
                            }
                    }
                }
                return [
                    'success' => true,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No se ha podido abrir el archivo',
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'No se ha enviado un archivo',
        ];
    }


    public function storeTransform($inputs)
    {
        $fact = DB::connection('tenant')->transaction(function () use ($inputs) {
            $facturalo = new Facturalo();
            $facturalo->save($inputs);
            $facturalo->createXmlUnsigned();
            $facturalo->signXmlUnsigned();
            $facturalo->updateHash();
            $facturalo->updateQr();
            $facturalo->createPdf();
            // $facturalo->sendEmail();
            // $facturalo->senderXmlSignedBill();

            return $facturalo;
        });

        $document = $fact->getDocument();
        // $response = $fact->getResponse();
        return [
            'success' => true,
            'data' => [
                'document_id' => $document->id,
                'number' => $document->number_full,
                'filename' => $document->filename,
                'external_id' => $document->external_id,
                'state_type_id' => $document->state_type_id,
                'state_type_description' => $this->getStateTypeDescription($document->state_type_id),
                'number_to_letter' => $document->number_to_letter,
                'hash' => $document->hash,
                'qr' => $document->qr,
            ],
            'links' => [
                'xml' => $document->download_external_xml,
                'pdf' => $document->download_external_pdf,
                // 'cdr' => ($response['sent']) ? $document->download_external_cdr : '',
            ],
            // 'response' => ($response['sent']) ? array_except($response, 'sent') : []
        ];
    }
    public function store(Request $request)
    {
        $fact = DB::connection('tenant')->transaction(function () use ($request) {
            $facturalo = new Facturalo();
            $facturalo->save($request->all());
            $facturalo->createXmlUnsigned();
            $facturalo->signXmlUnsigned();
            $facturalo->updateHash();
            $facturalo->updateQr();
            $facturalo->createPdf();
            $facturalo->sendEmail();
            $facturalo->senderXmlSignedBill();

            return $facturalo;
        });

        $document = $fact->getDocument();
        $response = $fact->getResponse();

        return [
            'success' => true,
            'data' => [
                'document_id' => $document->id,
                'number' => $document->number_full,
                'filename' => $document->filename,
                'external_id' => $document->external_id,
                'state_type_id' => $document->state_type_id,
                'state_type_description' => $this->getStateTypeDescription($document->state_type_id),
                'number_to_letter' => $document->number_to_letter,
                'hash' => $document->hash,
                'qr' => $document->qr,
            ],
            'links' => [
                'xml' => $document->download_external_xml,
                'pdf' => $document->download_external_pdf,
                'cdr' => ($response['sent']) ? $document->download_external_cdr : '',
            ],
            'response' => ($response['sent']) ? array_except($response, 'sent') : []
        ];
    }

    public function send(Request $request)
    {
        if ($request->has('external_id')) {
            $external_id = $request->input('external_id');
            $document = Document::where('external_id', $external_id)->first();
            if (!$document) {
                throw new Exception("El documento con código externo {$external_id}, no se encuentra registrado.");
            }
            if ($document->group_id !== '01') {
                throw new Exception("El tipo de documento {$document->document_type_id} es inválido, no es posible enviar.");
            }
            $fact = new Facturalo();
            $fact->setDocument($document);
            $fact->loadXmlSigned();
            $fact->onlySenderXmlSignedBill();
            $response = $fact->getResponse();
            return [
                'success' => true,
                'data' => [
                    'number' => $document->number_full,
                    'filename' => $document->filename,
                    'external_id' => $document->external_id,
                    'state_type_id' => $document->state_type_id,
                    'state_type_description' => $this->getStateTypeDescription($document->state_type_id)
                ],
                'links' => [
                    'cdr' => $document->download_external_cdr,
                ],
                'response' => array_except($response, 'sent')
            ];
        }
    }

    public function storeServer(Request $request)
    {
        $fact = DB::connection('tenant')->transaction(function () use ($request) {
            $facturalo = new Facturalo();
            $facturalo->save($request->all());

            return $facturalo;
        });

        $document = $fact->getDocument();
        $data_json = $document->data_json;

        // $zipFly = new ZipFly();

        $this->uploadStorage($document->filename, base64_decode($data_json->file_xml_signed), 'signed');
        $this->uploadStorage($document->filename, base64_decode($data_json->file_pdf), 'pdf');

        $document->external_id = $data_json->external_id;
        $document->hash = $data_json->hash;
        $document->qr = $data_json->qr;
        $document->save();

        // Send SUNAT
        if ($document->group_id === '01') {
            if ($data_json->query) DocumentControllerSend::send($document->id);
        }

        return [
            'success' => true,
        ];
    }

    public function documentCheckServer($external_id)
    {
        $document = Document::where('external_id', $external_id)->first();

        if ($document->state_type_id === '05' && $document->group_id === '01') {
            $file_cdr = base64_encode($this->getStorage($document->filename, 'cdr'));
        } else {
            $file_cdr = null;
        }

        return [
            'success' => true,
            'state_type_id' => $document->state_type_id,
            'file_cdr' => $file_cdr
        ];
    }

    private function getStateTypeDescription($id)
    {
        return StateType::find($id)->description;
    }



    public function lists()
    {
        $record = Document::orderBy('id', 'desc')->orderBy('number', 'desc')->get();
        $records = new DocumentCollection($record);

        return $records;
    }

    public function records(Request $request)
    {


        $records = $this->getRecords($request);

        return new DocumentCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function getRecords($request)
    {
        $d_end = $request->d_end;
        $customer = $request->customer;
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
        if ($customer) {
            $records = $records->whereHas('person', function ($query) use ($customer) {
                $query->where('name', 'like', '%' . $customer . '%')
                    ->orWhere('number', 'like', '%' . $customer . '%');
            });
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
}
