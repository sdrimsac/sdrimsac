<?php

namespace App\Http\Controllers\Tenant;

use Exception;
use App\Models\Tenant\Person;
use App\Models\Tenant\Turned;
use GuzzleHttp\Client;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\SearchRequest;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Http\Resources\Tenant\SearchResource;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    public function index()
    {
        return view('tenant.search.index');
    }
    public function service($type, $number)
    {


        $api_url = "https://grupopcsystems.xyz";
        $token = "0zvWuTr1zbRWPONCOOWqASrd1pGKLDtaQXYUL1D3EYDGo1cu3U";

        //$url = $configuration->api_service_url =! '' ? $configuration->api_service_url : config('configuration.api_service_url');
        //$token = $configuration->api_service_token =! '' ? $configuration->api_service_token : config('configuration.api_service_token');
        $client = new Client(['base_uri' => $api_url, 'verify' => false]);
        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
        ];
        $res = $client->request('GET', $api_url . '/api/' . $type . '/' . $number, $parameters);
        $response = json_decode($res->getBody()->getContents(), true);

        return $response;
    }
    public function tables()
    {
        $document_types = DocumentType::whereIn('id', ['01', '03', '07', '08'])->get();
        return compact('document_types');
    }
    public function efectivo(Request $request)
    {
        $company = Company::first();
        $turned = Turned::firstOrNew(['number' => $company->number]);
        $turned->fill($request->all());
        $turned->number = $company->number;
        $turned->save();
        try {

            return [
                "success" => true,
                "message" => "se guardo con exito",
                "data"    => $turned
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function store(SearchRequest $request)
    {
        $customer = Person::where('number', $request->input('customer_number'))
            ->where('type', 'customers')
            ->first();
        if (!$customer) {
           return response()->json([
                'success' => false,
                'message' => 'El cliente no fue encontrado.'
            ], 400);
        }

        $document = Document::where('date_of_issue', $request->input('date_of_issue'))
            ->where('document_type_id', $request->input('document_type_id'))
            ->where('series', strtoupper($request->input('series')))
            ->where('number', (int) $request->input('number'))
            ->where('total', $request->input('total'))
            ->where('customer_id', $customer->id)
            ->first();
        if ($document) {
            return [
                'success' => true,
                'data' => new SearchResource($document)
            ];
        } else {
            return [
                'success' => false,
                'message' => 'El documento no fue encontrado.'
            ];
        }
    }
}
