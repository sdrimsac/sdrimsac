<?php

namespace Modules\Services\Data;

use App\Models\System\ExchangeRate;
use GuzzleHttp\Client;
use App\Models\Tenant\Configuration;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ServiceData
{
    public static function exchange_rate($date = null)
    {

        $fecha = $date ??  Carbon::now()->format('y-m-d');
        $exchange_rate = ExchangeRate::where('date', $fecha)->first();
        if ($exchange_rate) {
            return $exchange_rate->sale;
        }
        Log::warning('No se encontró el tipo de cambio para la fecha: ' . $date."haciendo consulta");
        $url_api_peru = config('app.api_peru_service_url');
        $token_api_peru = config('app.api_peru_service_token');
        $full_url_api_peru = $url_api_peru . "/tipo_de_cambio";

        $fecha = $date ??  Carbon::now()->format('y-m-d');
        $response2 = Http::withoutVerifying()->withToken($token_api_peru)->accept('application/json')->post($full_url_api_peru, [
            "fecha" => $fecha
        ]);
        if ($response2->ok()) {

            $body = $response2->json();
            $data = $body['data'];
            $venta = $data['venta'];
            ExchangeRate::create([
                'date' => $fecha,
                'sale' => $venta,
                'purchase' => 0,
            ]);
            return $venta;
        }
        return 1;
    }

    public static function service($type, $number)
    {
        // Try Peru API first
        $url_api_peru = config('app.api_peru_service_url');
        $token_api_peru = config('app.api_peru_service_token');

        $full_url_api_peru = $url_api_peru . "/" . $type . "/" . $number . "?api_token=" . $token_api_peru;
        $client2 = new Client(['base_uri' => $full_url_api_peru, 'verify' => false]);
        
        try {
            $res2 = $client2->request('GET', $full_url_api_peru);
            $response2 = json_decode($res2->getBody()->getContents(), true);

            // If Peru API has data, process and return it
            if (isset($response2["data"]) && !empty($response2["data"])) {
                if ($type == 'ruc') {
                    $response2['data']['direccion'] = $response2['data']['direccion_completa'];
                }
                return $response2;
            }
        } catch (RequestException $exception) {
            Log::warning('Peru API failed: ' . $exception->getMessage());
        }

        // Fallback to Factiliza API if Peru API doesn't have data or fails
        $url_api_factiliza = config('app.api_factiliza_service_url');
        $token_api_factiliza = config('app.api_factiliza_service_token');

        if ($url_api_factiliza && $token_api_factiliza) {
            try {
                // Factiliza API has different endpoint structure
                if ($type == 'dni') {
                    $endpoint = "/v1/dni/info/" . $number;
                } elseif ($type == 'ruc') {
                    $endpoint = "/v1/ruc/info/" . $number;
                } else {
                    $endpoint = "/v1/" . $type . "/info/" . $number;
                }

                Log::info('Factiliza API endpoint: ' . $endpoint);
                
                $full_url_factiliza = $url_api_factiliza . $endpoint;
                $client_factiliza = new Client(['verify' => false]);
                $res_factiliza = $client_factiliza->request('GET', $full_url_factiliza, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token_api_factiliza,
                        'Accept' => 'application/json'
                    ]
                ]);
                $response_factiliza = json_decode($res_factiliza->getBody()->getContents(), true);

                if (isset($response_factiliza["data"]) && !empty($response_factiliza["data"])) {
                    if ($type == 'ruc') {
                        $response_factiliza['data']['direccion'] = $response_factiliza['data']['direccion_completa'];
                    }
                    return $response_factiliza;
                }
            } catch (RequestException $exception) {
                Log::warning('Factiliza API failed: ' . $exception->getMessage());
            }
        }

        // Return empty response if both APIs fail or have no data
        return ['data' => null, 'message' => 'No data found in both APIs'];
    }


    public function validar_cpe($file)
    {
        try {
            //91654192
            //$configuration = Configuration::first();
            $api_url = config('app.api_peru_service_url');
            $token = config('app.api_peru_service_token');
            // $api_url = config('configuration.api_service_url');
            // $token = config('configuration.api_service_token');

            $this->client = new Client(['base_uri' => $api_url, 'verify' => false, 'http_errors' => false]);
            $curl = [
                CURLOPT_URL => $api_url . '/api/validar/txt',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('file' => new \CURLFILE(public_path('storage/txt/' . $file))),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $token,
                ),
            ];
            $responses = $this->client->request(strtoupper("POST"), '/api/validar/txt', [
                'curl' => $curl,
            ]);

            return $responses->getBody()->getContents();
        } catch (RequestException $exception) {
            return $exception->getResponse()->getBody();
        }
    }
}
