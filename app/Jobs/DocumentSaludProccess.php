<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\CoreFacturalo\Requests\Api\Transform\Common\PersonTransform;
use App\CoreFacturalo\Requests\Api\Validation\DocumentValidation;
use App\CoreFacturalo\Requests\Inputs\DocumentInput;
use App\CoreFacturalo\Requests\Inputs\Functions;
use App\CoreFacturalo\Requests\Inputs\SummaryInput;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Tenant\SummaryController;
use App\Http\Controllers\Tenant\WhatsappController;
use App\Http\Requests\Tenant\SummaryRequest;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\DocumentSalud;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Series;
use App\Models\Tenant\User;
use App\Models\Tenant\Warehouse;
use App\Traits\JobReportTrait;
use Exception;
use Hyn\Tenancy\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class DocumentSaludProccess implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobReportTrait;

    protected $website_id;
    protected $store_path;
    protected $user_id;

    public $timeout = 600;
    public function __construct($website_id, $store_path)
    {
        $this->website_id = $website_id;
        $this->store_path = $store_path;
    }

    function items($inputs)
    {
        ini_set('memory_limit', '3048M');
        $document = $inputs['documento'];
        $establishment_id = self::get_establishment_by_serie(Functions::valueKeyInArray($document, 'serie'));
        $warehouse_id = null;
        $warehouse = Warehouse::where('establishment_id', $establishment_id)->first();
        if ($warehouse) {
            $warehouse_id = $warehouse->id;
        }
        if (key_exists('detalle', $inputs)) {
            $items = [];
            foreach ($inputs['detalle'] as $index => $row) {
                try {
                    // Defensive reads
                    $quantity = Functions::valueKeyInArray($row, 'cantidadItem', 0);
                    $price = Functions::valueKeyInArray($row, 'precioItem', 0);
                    $total = $quantity * $price;

                    $unit_type = Functions::valueKeyInArray($row, 'unidadMedidaItem', null);
                    $currency_type = Functions::valueKeyInArray($document, 'tipoMoneda', null);

                    $items[] = [
                        'warehouse_id' => $warehouse_id,
                        'internal_id' => Functions::valueKeyInArray($row, 'codItem', ''),
                        'description' => Functions::valueKeyInArray($row, 'nombreItem', ''),
                        'name' => null,
                        'second_name' => null,
                        'item_type_id' => '01',
                        'item_code' => Functions::valueKeyInArray($row, 'codItem'),
                        'item_code_gs1' => null,
                        'unit_type_id' => $unit_type ? strtoupper($unit_type) : null,
                        'currency_type_id' => $currency_type,
                        'name_product_pdf' => null,
                        'quantity' => $quantity,
                        'unit_value' => Functions::valueKeyInArray($row, 'precioItemSinIgv', 0),
                        'price_type_id' => null,
                        'unit_price' => $price,
                        'affectation_igv_type_id' => Functions::valueKeyInArray($row, 'codAfectacionIgv', null),
                        'total_base_igv' => Functions::valueKeyInArray($row, 'precioItemSinIgv', 0),
                        'percentage_igv' => 18,
                        'total_igv' => Functions::valueKeyInArray($row, 'montoIgv', 0),
                        'system_isc_type_id' => null,
                        'total_base_isc' => 0,
                        'percentage_isc' => null,
                        'total_isc' => 0,
                        'total_base_other_taxes' => 0,
                        'percentage_other_taxes' => 0,
                        'total_other_taxes' => 0,
                        'total_plastic_bag_taxes' => 0,
                        'total_taxes' => Functions::valueKeyInArray($row, 'montoIgv', 0),
                        'total_value' => Functions::valueKeyInArray($row, 'precioItemSinIgv', 0),
                        'total_charge' => 0,
                        'total_discount' => 0,
                        'total' => $total,
                        'attributes' => null,
                        'discounts' => null,
                        'charges' => null,
                        'additional_information' => Functions::valueKeyInArray($row, 'informacion_adicional', null),

                    ];
                } catch (\Throwable $e) {
                    // Log the problematic row with index and keys to help identify missing index
                    Log::error('Error processing detalle row', [
                        'file' => isset($this->store_path) ? $this->store_path : null,
                        'row_index' => $index,
                        'row_preview' => is_array($row) ? json_encode($row) : (string)$row,
                        'error_message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    // Re-throw to be handled by outer try/catch so the document is marked as failed
                    throw $e;
                }
            }

            return $items;
        }
        return null;
    }
    function getUserId($serie)
    {

        $series = Series::where('number', 'like', '%' . $serie . '%')->first();
        $establishment_id = $series->establishment_id;
        $user = User::where('establishment_id', $establishment_id)->first();
        $this->user_id = $user->id;
        // return $user->id;
    }
    function transform_document($inputs)
    {
        ini_set('memory_limit', '3048M');
        $document = $inputs['documento'];
        $total = $document['mntTotal'];
        //redondeo de totales
        $total_rounded = round($total, 2);
        $additional = $inputs['datosAdicionales'];
        // $totals = $inputs['totales'];
        $series = Functions::valueKeyInArray($document, 'serie');
        $this->getUserId($series);
        $inputs_transform = [
            'series' => $series,
            'user_id' => $this->user_id,
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
            'additional_information' => null,
            'actions' => null,
            'hotel' => [],
            'transport' => [],
            'fee' => [],
            'payment_condition_id' => '01',
        ];

        return $inputs_transform;
    }
    function get_establishment_by_serie($serie)
    {
        Log::info('serie2: ' . $serie);
        $serie = Series::where('number', $serie)->first();

        if ($serie) {
            $establishment_id = $serie->establishment_id;
            return $establishment_id;
        }
        return null;
    }
    public function handle()
    {

        $ids_to_summarie = [];
        ini_set('memory_limit', '3048M');
        $date = date('Y-m-d');
        $website = $this->findWebsite($this->website_id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($website);
        $date_of_issue = null;
        $store_path = $this->store_path;
        $files = scandir(storage_path($store_path));
        $files = array_diff($files, array('.', '..'));
        $files = array_values($files);
        usort($files, function ($a, $b) {
            $a = intval(str_replace('Registro_', '', str_replace('.txt', '', $a)));
            $b = intval(str_replace('Registro_', '', str_replace('.txt', '', $b)));
            return $a - $b;
        });
    foreach ($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if ($extension === 'txt') {
                $path =  storage_path($store_path . '/' . $file);
                if (file_exists($path) && is_readable($path)) {
                    // Convert PHP notices/warnings to ErrorException temporarily so we can catch undefined index errors
                    $previous_error_handler = set_error_handler(function ($severity, $message, $fileErr, $line) {
                        // Only convert notices and warnings
                        if (error_reporting() === 0) {
                            // Error suppressed with @
                            return false;
                        }
                        throw new \ErrorException($message, 0, $severity, $fileErr, $line);
                    });
                    $document = file_get_contents($path);
                    $document = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $document);
                    $document = str_replace('�', '', $document);
                    $document = json_decode($document, true);
                    $identifier = $document['idTransaccion'];
                    $document_salud = new DocumentSalud;
                    $document_salud->date_of_issue = $document['fechaEmision'];

                    $document_salud->date_of_charge = $date;
                    $document_salud->file_name = $file;
                    $document_salud->identifier = $identifier;
                    DocumentSalud::where('identifier', $identifier)->whereNotNull('error')->delete();
                    $document_salud_exists = DocumentSalud::where('identifier', $identifier)
                        ->whereNull('error')
                        ->where('status', 'Aceptado')
                        ->first();
                    if ($document_salud_exists) {
                        $document_salud->status = 'Repetido';
                        $document_salud->error = 'Documento repetido';
                        $document_salud->save();
                        continue;
                    }
                    try {
                        $document_transform = self::transform_document($document);
                        $series = $document_transform['series'];
                        $full_number = $series . '-' . $document_transform['number'];
                        $establishment_id = self::get_establishment_by_serie($series);
                        $document_transform['establishment_id'] = $establishment_id;
                        $user_establishment = User::where('type', 'seller')->where('establishment_id', $establishment_id)->first();
                        if($user_establishment){
                            $document_transform['user_id'] = $user_establishment->id;
                        }
                        Log::info('document_transform: ' . json_encode($document_transform));
                        $document_validated = DocumentValidation::validationSalud($document_transform);
                        $document_input = DocumentInput::set($document_validated);

                        $result = (new DocumentController)->storeTransform($document_input);
                        if (isset($result['success']) && $result['success'] === true) {
                            $document_salud->status = 'Aceptado';
                            $ids_to_summarie[$document_salud->date_of_issue][] =
                                $result['data']['document_id'];
                        } else {
                            $document_salud->status = 'Fallido';
                            $this->sendMessage($establishment_id, $full_number, $this->user_id);
                        }
                    } catch (\Throwable $e) {
                        // Log detailed context to help identify the exact missing index or data
                        Log::error('DocumentSaludProccess error: ' . $e->getMessage(), [
                            'file' => $file,
                            'path' => $path,
                            'exception_file' => $e->getFile(),
                            'exception_line' => $e->getLine(),
                            'exception_trace' => $e->getTraceAsString(),
                            'document_preview' => is_array($document) ? json_encode(array_slice($document, 0, 20)) : substr((string)$document, 0, 1000),
                        ]);

                        // If the exception contains 'Undefined index', try to add more specific context
                        if (strpos($e->getMessage(), 'Undefined index') !== false) {
                            // try to detect which index
                            preg_match('/Undefined index: ([^\s]+)/', $e->getMessage(), $m);
                            $missing = $m[1] ?? null;
                            Log::error('Undefined index detected', [
                                'missing_index' => $missing,
                                'document_keys' => is_array($document) ? array_keys($document) : null,
                            ]);
                        }

                        $this->sendMessage($establishment_id ?? null, $full_number ?? null, $this->user_id ?? null);
                        $document_salud->status = 'Fallido';
                        $message = $e->getMessage();
                        $message = substr($message, 0, 190);
                        $document_salud->error = $message;
                        Log::info('error: file: ' . $file . " " . $e->getMessage() . " " . $e->getLine() . " " . $e->getFile());
                    } finally {
                        // restore previous error handler
                        if (isset($previous_error_handler) && $previous_error_handler !== null) {
                            set_error_handler($previous_error_handler);
                        } else {
                            restore_error_handler();
                        }

                        $document_salud->save();
                    }
                } else {
                    Log::info('no existe: ' . $path);
                }
            }
        }

        if (count($ids_to_summarie) > 0) {
            $this->summarize($ids_to_summarie);
        }
        return [
            'success' => true,
        ];
    }




    public function failed(Throwable $exception)
    {
        Log::error($exception->getMessage());
    }
    function summarize($documents)
    {

        $summary_status_type_id = '1';
        foreach ($documents as $date_of_issue => $document) {
            $summary_documents = array_map(function ($id) {
                return ['document_id' => $id];
            }, $document);

            $inputs = [
                'date_of_reference' => $date_of_issue,
                'summary_status_type_id' => $summary_status_type_id,
                'documents' => $summary_documents,
                'type' => 'summary'
            ];

            try {
                $summary_input = SummaryInput::set($inputs);
                $summary_input = SummaryInput::set($inputs);
                $request = new SummaryRequest($summary_input);
                $response =     (new SummaryController)->store($request);

                if (isset($response['document_id'])) {
                    $status = (new SummaryController)->status($response['document_id']);
                }
            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
    }

    function sendMessage($establishment_id, $serie, $user_id)
    {
        $establishment = Establishment::find($establishment_id);
        $user = User::find($user_id);
        $user_name = $user->name;
        $establishment_name = $establishment->description;
        $message = "El documento con serie $serie del establecimiento $establishment_name, subido por $user_name, no se pudo procesar.";
        (new WhatsappController)->sendMessageAllSupprot($message);
        (new WhatsappController)->sendMessageAll($message);
    }
}
