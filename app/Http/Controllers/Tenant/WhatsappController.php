<?php

namespace App\Http\Controllers\Tenant;

use App\Events\MessageEvent;
use App\Events\WhatsappQrEvent;
use GuzzleHttp\Client;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Quotation;
use Illuminate\Support\Facades\Storage;
use App\Models\System\Configuration as Config;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappController extends Controller
{
    protected $client;

    public function sendMessage($message, $number = null)
    {
        if ($number == null) {
            $configuration = Configuration::first();
            $number = $configuration->number_activity;
        }

        if (!$number) {
            Log::alert("No se ha configurado el número de whatsapp para enviar notificaciones");
            return;
        }
        $url = "https://sdrimsac.xyz/api/send-message";



        try {
            $response = Http::post($url, [
                'number' => "51" . $number,
                'sender' => 'sdrimsac',
                'message' => $message,
            ]);

            $status = $response->status();
            $body = $response->body();

            return [
                "success" => $status == 200,
                "message" => $body
            ];
        } catch (\Exception $e) {

            return [
                "message" => $e->getMessage(),
                "line" => $e->getLine(),
            ];
        }
    }
    public function getStatus(Request $request)
    {
        $sender = $request->sender;

        try {
            $response = Http::post("http://localhost:3500/api/get-sesion", [
                'sender' => $sender,
                // 'url' => $url
                // 'description' => $description,
            ]);

            if ($response->ok()) {
                $body = $response->json();

                return ["succes" => false, "message" => "Estado: " . ($body['status'] ? 'Listo' : 'No listo'), "status" => $body['status']];
            } else {
                return ["succes" => false, "message" => "No listo"];
            }
        } catch (Exception $e) {

            return ["succes" => false, "message" => $e->getMessage()];
        }
    }

    public function notification(Request $request)
    {

        $message = $request->message;

        if ($message) {
            event(new MessageEvent($message));
        }

        return ["succes" => true, "message" => "Notificación enviada"];
    }

    public function initWhatsapp(Request $request)
    {
        $sender = $request->sender;
        $url = $request->url;
        $description = "Sesión de " . $sender;
        $response = Http::post("http://localhost:3500/api/init-sesion", [
            'sender' => $sender,
            'url' => $url,
            'description' => $description,
        ]);



        return ["success" => $response->ok()];
    }
    public function receiveQr(Request $request)
    {

        $image_base64 = $request->imgBase64;
        if ($image_base64) {
            event(new WhatsappQrEvent($image_base64));
            return [
                'success' => 'Qr enviado con exito',
            ];
        } else {
            return [
                "success" => false,
                'message' => "Ocurrió un error al enviar el qr"
            ];
        }
    }

    public function getFile(Request $request)
    {
        $url = url("");
        $external_id = "";
        if ($request->document_type_id == "01" || $request->document_type_id == "03") {
            $document = Document::find($request->input('document_id'));
            $document_filename = $document->filename;
            $external_id = $document->external_id;

            $url = $url . "/print/document/" . $external_id . "/ticket";
        } else if ($request->document_type_id == "80") {
            $document = SaleNote::find($request->input('document_id'));
            $document_filename = $document->filename;
            $external_id = $document->external_id;
            $url = $url . "/sale-notes/print/" . $external_id . "/ticket";
            //print/document/2a255ca8-4910-45c5-b549-1a4fed24366f/ticket
            //sale-notes/print/3772fd83-e81a-49ac-a234-8f570952b517/ticket
        }


        $xml = null;
        $pdf =  file_get_contents($url);
        // $pdf = ($request->document_type_id == "80")  ? file_get_contents(Storage::disk('local')->path("sale_note" . DIRECTORY_SEPARATOR . $document_filename . ".pdf")) :  file_get_contents(Storage::disk('local')->path("pdf" . DIRECTORY_SEPARATOR . $document_filename . ".pdf"));
        $pdf = base64_encode($pdf);
        if ($request->document_type_id != "80") {

            $xml = file_get_contents(Storage::disk('local')->path("signed" . DIRECTORY_SEPARATOR . $document_filename . ".xml"));
            $xml = base64_encode($xml);
        }

        return [
            "pdf" => $pdf,
            "xml" => $xml,
            "name" => $document_filename
        ];
    }
    public function index()
    {
        $configuration = Configuration::first();
        return view('restaurant::whatsapp', ['configuration' => $configuration]);
    }
    public function sendwhatsapp(Request $request)
    {
        $url1 = url("");
        $external_id = "";
        $xml = $request->xml ?? false;
        if ($request->document_type_id == "01" || $request->document_type_id == "03") {
            $document = Document::find($request->input('document_id'));
            $document_filename = $document->filename;
            $external_id = $document->external_id;

            $url1 = $url1 . "/print/document/" . $external_id . "/ticket";
        } else if ($request->document_type_id == "80") {
            $document = SaleNote::find($request->input('document_id'));
            $document_filename = $document->filename;
            $external_id = $document->external_id;
            $url1 = $url1 . "/sale-notes/print/" . $external_id . "/ticket";
        } else if ($request->document_type_id == "COT") {
            $document = Quotation::find($request->input('document_id'));
            $document_filename = $document->filename;
            $external_id = $document->external_id;
            $url1 = $url1 . "/quotations/print/" . $external_id . "/ticket";
        }
        //"" 
        if ($request->sender == "sdrimsac") {
            $url = "https://sdrimsac.xyz" . '/api/send-media';
        } else {
            $url = config('app.whatsapp_url') . '/api/send-media';
        }
        // $url = 'http://localhost:3800/api/send-media';

        $content_file = null;

        if (!$xml) {
            $content_file = file_get_contents($url1);
            // $content_file = ($request->document_type_id == "80")  ? file_get_contents(Storage::disk('local')->path("sale_note" . DIRECTORY_SEPARATOR . $document_filename . ".pdf")) :   file_get_contents(Storage::disk('local')->path("pdf" . DIRECTORY_SEPARATOR . $document_filename . ".pdf"));
        } else {
            $content_file = file_get_contents(Storage::disk('local')->path("signed" . DIRECTORY_SEPARATOR . $document_filename . ".xml"));
        }
        $this->client = new Client([
            'verify' => false,
            'stream' => false,
            'headers' => [
                'User-Agent' => 'Testing 1.0'
            ]
        ]);
        try {
            $response = $this->client->post($url, [
                'multipart' => [
                    [
                        'name'     => 'number',
                        'contents' => "51" . $request->customer_telephone
                    ],
                    [
                        'name'     => 'caption',
                        'contents' => $request->mensaje
                    ],
                    [
                        'name'     => 'sender',
                        'contents' => $request->sender ?? 'sdrimsac'
                    ],
                    [
                        'name'     => 'file',
                        'contents' => $content_file,
                        'filename' => $document_filename . ($xml ? ".xml" : ".pdf")
                    ],

                ]
            ]);

            return  $response->getBody()->getContents();
        } catch (\Exception $e) {

            return [
                "message" => $e->getMessage(),
                "line" => $e->getLine(),
            ];
        }
    }

    public function sendHistorial(Request $request)
    {

        if ($request->sender == "sdrimsac" || $request->sender == null) {
            $url = "https://sdrimsac.xyz" . '/api/send-media';
        } else {
            $url = config('app.whatsapp_url') . '/api/send-media';
        }
        // $url = 'http://localhost:3800/api/send-media';
        $resource = $request->resource;
        $sender = $request->sender ?? 'sdrimsac';
        $message = $request->message;
        $file_name = $request->file_name;
        $number = $request->number;
        $from_server = $request->from_server ?? false;
        $file_name = (strpos($file_name, '.') !== false) ? $file_name : $file_name . ".pdf";
        if ($from_server) {

            $content_file = file_get_contents($resource, 0, stream_context_create(["http" => ["timeout" => 60]]));
        } else {

            $content_file = file_get_contents($request->root() . $resource, 0, stream_context_create(["http" => ["timeout" => 60]]));
        }
        $this->client = new Client([
            'verify' => false,
            'stream' => false,
            'headers' => [
                'User-Agent' => 'Testing 1.0'
            ]
        ]);
        try {
            $response = $this->client->post($url, [
                'multipart' => [
                    [
                        'name'     => 'number',
                        'contents' => "51" . $number
                    ],
                    [
                        'name'     => 'caption',
                        'contents' => $message,
                    ],
                    [
                        'name'     => 'sender',
                        'contents' => $sender
                    ],
                    [
                        'name'     => 'file',
                        'contents' => $content_file,
                        'filename' =>   $file_name
                    ],

                ]
            ]);

            ob_get_clean();
            return  $response->getBody()->getContents();
        } catch (\Exception $e) {
Log::warning($e->getMessage());
            return response([
                "message" => $e->getMessage(),
                "line" => $e->getLine(),
            ], 500);
            exit;
        }
    }
    public function sendReporteDocumentos(Request $request)
    {


        if ($request->sender == "sdrimsac") {
            $url = "https://sdrimsac.xyz" . '/api/send-media';
        } else {
            $url = config('app.whatsapp_url') . '/api/send-media';
        }
        // $url = 'http://localhost:3800/api/send-media';

        $documento = $request->file;
        $path = $request->file->getPathname();
        $sender = $request->sender ?? 'sdrimsac';
        $message = $request->message;
        $file_name = $request->file_name;
        $number = $request->number;
        $content_file = file_get_contents($path);

        $this->client = new Client([
            'verify' => false,
            'stream' => false,
            'headers' => [
                'User-Agent' => 'Testing 1.0'
            ]
        ]);


        try {
            foreach ($number as $key => $data) {
                $response = $this->client->post($url, [
                    'multipart' => [
                        [
                            'name'     => 'number',
                            'contents' => "51" . $data
                        ],
                        [
                            'name'     => 'caption',
                            'contents' => $message,
                        ],
                        [
                            'name'     => 'sender',
                            'contents' => $sender
                        ],
                        [
                            'name'     => 'file',
                            'contents' => $content_file,
                            'filename' =>   $file_name
                        ],

                    ]
                ]);

                ob_get_clean();
            }
            return  $response->getBody()->getContents();
        } catch (\Exception $e) {

            return response([
                "message" => $e->getMessage(),
                "line" => $e->getLine(),
            ], 500);
            exit;
        }
    }
}
