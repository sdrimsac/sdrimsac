<?php

namespace App\CoreFacturalo\Requests\Inputs;

use App\Models\Tenant\Company;
use App\Models\Tenant\CompanySameRuc;
use App\Models\Tenant\Document;
use App\Models\Tenant\Series;
use Carbon\Carbon;
use Exception;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Document\Models\SeriesConfiguration;

class Functions
{
    public static function newNumber($soap_type_id, $document_type_id, $series, $number, $model)
    {
        return DB::transaction(function () use ($soap_type_id, $document_type_id, $series, $number, $model) {
            if ($number === '#') {
                $document = $model::select('number')
                    ->where('soap_type_id', $soap_type_id)
                    ->where('document_type_id', $document_type_id)
                    ->where('series', $series)
                    ->orderBy('number', 'desc')
                    ->lockForUpdate() // Bloquear la fila para evitar concurrencia
                    ->first();

                if ($document) {
                    return (int)$document->number + 1;
                } else {
                    $series_configuration = SeriesConfiguration::where([['document_type_id', $document_type_id], ['series', $series]])
                        ->lockForUpdate() // Bloquear la fila para evitar concurrencia
                        ->first();
                    return ($series_configuration) ? (int) $series_configuration->number : 1;
                }
            }
            return $number;
        });

        // if ($number === '#') {

        //     $document = $model::select('number')
        //                             ->where('soap_type_id', $soap_type_id)
        //                             ->where('document_type_id', $document_type_id)
        //                             ->where('series', $series)
        //                             ->orderBy('number', 'desc')
        //                             ->first();

        //     if($document){

        //         return (int)$document->number+1;

        //     }else{

        //         $series_configuration = SeriesConfiguration::where([['document_type_id',$document_type_id],['series',$series]])->first();
        //         return ($series_configuration) ? (int) $series_configuration->number:1;

        //     }

        // }

        // return $number;


    }

    public static function filename($company, $document_type_id, $series, $number)
    {
        return join('-', [$company->number, $document_type_id, $series, $number]);
    }

    public static function validateUniqueDocument($soap_type_id, $document_type_id, $series, $number, $model)
    {
        $document = $model::where('soap_type_id', $soap_type_id)
            ->where('document_type_id', $document_type_id)
            ->where('series', $series)
            ->where('number', $number)
            ->first();
        if ($document) {
            throw new Exception("El documento: {$document_type_id} {$series}-{$number} ya se encuentra registrado.");
        }
    }

    /* public static function identifier($soap_type_id, $date_of_issue, $model)
    {
        $same_rucs = CompanySameRuc::all();
        $path = explode('\\', $model);
        $last = array_pop($path);
        $table = $last === 'Voided' ? 'voided' : 'summaries';

        if (count($same_rucs) > 0) {
            $numeration = 0;
            //$table = $path == 'Voided' ?  'voided' : 'summaries';

            //foreach ($same_rucs as $same_ruc) {
            //    $query = "SELECT COUNT(*) as total FROM " . $same_ruc->uuid . "." . $table . " WHERE soap_type_id = ? AND date_of_issue = ?";
            //    $result = DB::select($query, [$soap_type_id, $date_of_issue]);
            //    $numeration += $result[0]->total;
            // }
            foreach ($same_rucs as $same_ruc) {
                $query = "SELECT COUNT(*) as total FROM " . $same_ruc->uuid . "." . $table . " WHERE soap_type_id = ? AND date_of_issue = ?";
                $result = DB::select($query, [$soap_type_id, $date_of_issue]);
                $numeration += $result[0]->total;
            }
            $numeration += 1;
            $suffix = auth()->user()->company->id;
        } else {
            $documents = $model::where('soap_type_id', $soap_type_id)
                ->where('date_of_issue', $date_of_issue)
                ->get();
            $numeration = count($documents) + 1;
        }
        switch (array_pop($path)) {
            case 'Voided':
                $prefix = 'RA';
                break;
            default:
                $prefix = 'RC';
                break;
        }

        return join('-', [$prefix, Carbon::parse($date_of_issue)->format('Ymd'), $numeration]);
    } */

    /* public static function identifier($soap_type_id, $date_of_issue, $model)
    {
        $same_rucs = CompanySameRuc::all();
        $path = explode('\\', $model);
        $last = array_pop($path);

        $table = $last === 'Voided' ? 'voided' : 'summaries';

        if (count($same_rucs) > 0) {
            $numeration = 0;
            foreach ($same_rucs as $same_ruc) {
                $query = "SELECT COUNT(*) as total FROM " . $same_ruc->uuid . "." . $table . " WHERE soap_type_id = ? AND date_of_issue = ?";
                $result = DB::select($query, [$soap_type_id, $date_of_issue]);
                $numeration += $result[0]->total;
            }
            $numeration += 1;

            // ✅ Diferenciar por aplicativo
            $suffix = auth()->user()->company->id;
        } else {
            $documents = $model::where('soap_type_id', $soap_type_id)
                ->where('date_of_issue', $date_of_issue)
                ->get();
            $numeration = count($documents) + 1;
            $suffix = null;
        }

        $prefix = $last === 'Voided' ? 'RA' : 'RC';

        // ✅ Si hay sufijo, lo añadimos
        return $suffix
            ? join('-', [$prefix, Carbon::parse($date_of_issue)->format('Ymd'), $numeration, $suffix])
            : join('-', [$prefix, Carbon::parse($date_of_issue)->format('Ymd'), $numeration]);
    } */

    /* public static function identifier($soap_type_id, $date_of_issue, $model)
    {
        $same_rucs = CompanySameRuc::all();
        $path = explode('\\', $model);
        $last = array_pop($path);

        $table = $last === 'Voided' ? 'voided' : 'summaries';

        if ($same_rucs->count() > 0) {
            $numeration = 0;

            foreach ($same_rucs as $same_ruc) {
                $query = "SELECT COUNT(*) as total 
                      FROM {$same_ruc->uuid}.{$table} 
                      WHERE soap_type_id = ? AND date_of_issue = ?";
                $result = DB::select($query, [$soap_type_id, $date_of_issue]);
                $numeration += $result[0]->total;
            }

            $numeration += 1;
        } else {
            $documents = $model::where('soap_type_id', $soap_type_id)
                ->where('date_of_issue', $date_of_issue)
                ->count();

            $numeration = $documents + 1;
        }

        $prefix = $last === 'Voided' ? 'RA' : 'RC';

        return join('-', [
            $prefix,
            Carbon::parse($date_of_issue)->format('Ymd'),
            $numeration
        ]);
    } */

    /* public static function identifier($soap_type_id, $date_of_issue, $model)
    {

        //$same_rucs = CompanySameRuc::all();
        $tenant_name = app(\Hyn\Tenancy\Environment::class)->tenant()->uuid;
        $company = Company::first();
        $ruc = $company->number;


        // Prefijo según tipo de documento
        $prefix = $soap_type_id === 'RA' ? 'RA' : 'RC';

        $hostname = Website::query()
            ->where('uuid', app(\Hyn\Tenancy\Environment::class)->tenant()->uuid)
            ->first()
            ->hostnames
            ->first();

        // Llamada al distribuidor para obtener correlativo
        // Determinar archivo CA para la verificación SSL (evita cURL error 77)
        $caFile = ini_get('curl.cainfo') ?: ini_get('openssl.cafile') ?: env('CURL_CA_BUNDLE') ?: env('SSL_CERT_FILE');

        if ($caFile && file_exists($caFile)) {
            $verify = $caFile;
        } else {
            // En entorno local o con debug activado, permitimos desactivar la verificación
            if (config('app.debug') || app()->environment('local')) {
                $verify = false;
            } else {
                throw new \Exception("cURL CA bundle not found. Set 'curl.cainfo' / 'openssl.cafile' in php.ini or define CURL_CA_BUNDLE env var. Current path: {$caFile}");
            }
        }

        // Construir opciones para el cliente HTTP
        $options = ['verify' => $verify];

        // Forzar TLSv1.2 cuando sea posible para evitar errores de versión SSL (cURL error 35)
        if (defined('CURLOPT_SSLVERSION') && defined('CURL_SSLVERSION_TLSv1_2')) {
            $options['curl'] = [
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            ];
        }

        $response = Http::withOptions($options)->post("https://{$hostname->fqdn}/api/summaries/next-correlative", [
            'ruc' => $ruc,
            'type' => $prefix,
            'tenant' => $tenant_name,
        ]);

        if (!$response->successful()) {
            throw new \Exception('No se pudo obtener el correlativo del distribuidor');
        }

        // Correlativo recibido
        $numeration = str_pad($response->json()['correlative'], 3, '0', STR_PAD_LEFT);

        // Retornamos el identificador final
        return join('-', [
            $prefix,
            Carbon::parse($date_of_issue)->format('Ymd'),
            $numeration
        ]);
    } */

    public static function identifier($soap_type_id, $date_of_issue, $model)
    {
        $tenant_name = app(\Hyn\Tenancy\Environment::class)->tenant()->uuid;
        $company = Company::first();
        $ruc = $company->number;

        // Prefijo según tipo de documento
        $prefix = $soap_type_id === 'RA' ? 'RA' : 'RC';

        $hostname = Website::query()
            ->where('uuid', app(\Hyn\Tenancy\Environment::class)->tenant()->uuid)
            ->first()
            ->hostnames
            ->first();

        /**
         * Configurar el cliente HTTP igual que en otras partes del sistema
         * Nota: 'verify' => false evita el error "cURL CA bundle not found"
         */
        $constructor_params = [
            'base_uri' => "https://{$hostname->fqdn}",
            'verify' => false, // Ignorar verificación SSL temporalmente
        ];

        $clientGuzzleHttp = new \GuzzleHttp\Client($constructor_params);

        // Llamada al endpoint del distribuidor
        $response = $clientGuzzleHttp->post('/api/summaries/next-correlative', [
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . auth()->user()->api_token,
                'Accept' => 'application/json',
            ],
            'form_params' => [
                'ruc' => $ruc,
                'type' => $prefix,
                'tenant' => $tenant_name,
            ]
        ]);

        // Validar respuesta
        $body = json_decode($response->getBody(), true);

        if ($response->getStatusCode() !== 200 || !isset($body['correlative'])) {
            throw new \Exception('No se pudo obtener el correlativo del distribuidor. Respuesta: ' . $response->getBody());
        }

        // Correlativo recibido
        $numeration = str_pad($body['correlative'], 3, '0', STR_PAD_LEFT);

        // Retornar identificador final
        return join('-', [
            $prefix,
            \Carbon\Carbon::parse($date_of_issue)->format('Ymd'),
            $numeration
        ]);
    }

    public static function valueKeyInArray($inputs, $key, $default = null)
    {
        if (array_key_exists($key, $inputs)) {
            if (!is_null($inputs[$key])) {
                return $inputs[$key];
            }
        }
        return $default;
    }
}
