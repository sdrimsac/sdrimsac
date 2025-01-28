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

        $exchange_rate = ExchangeRate::where('date', $date)->first();
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

        $url_api_peru = config('app.api_peru_service_url');
        $token_api_peru = config('app.api_peru_service_token');

        $full_url_api_peru = $url_api_peru . "/" . $type . "/" . $number . "?api_token=" . $token_api_peru;
        $client2 = new Client(['base_uri' => $full_url_api_peru, 'verify' => false]);
        $res2 = $client2->request('GET', $full_url_api_peru);
        $response2 = json_decode($res2->getBody()->getContents(), true);


        if ($type == 'ruc' && isset($response2["data"])) {

            $response2['data']['direccion'] = $response2['data']['direccion_completa'];
        }
        return $response2;
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
