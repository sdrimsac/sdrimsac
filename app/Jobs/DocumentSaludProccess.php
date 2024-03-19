<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\CoreFacturalo\Requests\Api\Transform\Common\PersonTransform;
use App\CoreFacturalo\Requests\Api\Validation\DocumentValidation;
use App\CoreFacturalo\Requests\Inputs\DocumentInput;
use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Http\Controllers\Api\DocumentController;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\DocumentSalud;
use App\Traits\JobReportTrait;
use Exception;
use Hyn\Tenancy\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DocumentSaludProccess implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobReportTrait;

    protected $website_id;
    protected $store_path;


    public function __construct($website_id, $store_path)
    {
        $this->website_id = $website_id;
        $this->store_path = $store_path;
    }

     function items($inputs)
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
    public function handle()
    {
        $date = date('Y-m-d');
        $website = $this->findWebsite($this->website_id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($website);
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
                    $document_salud_exists = DocumentSalud::where('identifier', $identifier)->first();
                    if ($document_salud_exists) {
                        $document_salud->status = 'Repetido';
                        $document_salud->error = 'Documento repetido';
                        $document_salud->save();
                        continue;
                    }
                    try {
                        $document_transform = self::transform_document($document);
                        $document_validated = DocumentValidation::validationSalud($document_transform);
                        $document_input = DocumentInput::set($document_validated);
                        $result = (new DocumentController)->storeTransform($document_input);
                        if (isset($result['success']) && $result['success'] === true) {
                            $document_salud->status = 'Aceptado';
                        } else {
                            $document_salud->status = 'Fallido';
                        }
                    } catch (Exception $e) {
                        $document_salud->status = 'Fallido';
                        $message = $e->getMessage();
                        //limitar a 255 caracteres
                        $message = substr($message, 0, 190);
                        $document_salud->error = $message;
                        Log::info('error: file: ' . $file . " " . $e->getMessage(). " " . $e->getLine() . " " . $e->getFile());
                    } finally {
                        $document_salud->save();
                    }
                } else {
                    Log::info('no existe: ' . $path);
                }
            }
        }
        return [
            'success' => true,
        ];
    

        
    }



    /**
     * The job failed to process.
     *
     * @param Exception $exception
     *
     * @return void
     */
    public function failed(Exception $exception)
    {
        Log::error($exception->getMessage());
    }
}
