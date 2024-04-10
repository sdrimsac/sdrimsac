<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Dispatch;
use App\Models\Tenant\Document;
use App\Models\Tenant\Quotation;
use App\Models\Tenant\SaleNote;
use App\Traits\JobReportTrait;
use Exception;
use GuzzleHttp\Client;
use Hyn\Tenancy\Environment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WhatsappSendDocumentProccess implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels, JobReportTrait;

    protected $message;
    protected $website_id;
    protected $url_file;
    protected $document_id;
    protected $document_type_id;
    protected $xml;
    protected $customer_telephone;
    protected $url;


    public function __construct(
        $message,
        $website_id,
        $url_file,
        $document_id,
        $document_type_id,
        $xml,
        $customer_telephone,
        $url
    ) {
        $this->message = $message;
        $this->website_id = $website_id;
        $this->url_file = $url_file;
        $this->document_id = $document_id;
        $this->document_type_id = $document_type_id;
        $this->xml = $xml;
        $this->customer_telephone = $customer_telephone;
        $this->url = $url;
    }


    public function handle()
    {
        $website = $this->findWebsite($this->website_id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($website);
        $configuration = Configuration::first();
        try {
            $message = $this->message;
            $url1 = "http://".$this->url;
            ///si el ambito es local cambiar https por http
            if (env('APP_ENV') == 'local') {
                $url1 = str_replace("https", "http", $url1);
            }
            $external_id = "";
            $xml = $this->xml ?? false;
            if ($this->document_type_id == "01" || $this->document_type_id == "03") {
                $document = Document::find($this->document_id);
                $document_filename = $document->filename;
                $external_id = $document->external_id;

                $url1 = $url1 . "/print/document/" . $external_id . "/ticket";
            } else if ($this->document_type_id == "80") {
                $document = SaleNote::find($this->document_id);
                $document_filename = $document->filename;
                $external_id = $document->external_id;
                $url1 = $url1 . "/sale-notes/print/" . $external_id . "/ticket";
            } else if ($this->document_type_id == "09") {
                $document = Dispatch::find($this->document_id);
                $company = Company::first();
                $company_name = $company->name;
                //si en $message existe la palabra "de undefined" reemplazalo con "de $company_name"
                $message = str_replace("de *undefined*", "de " . $company_name, $message);
                $document_filename = $document->filename;
                $external_id = $document->external_id;
                $url1 = $url1 . "/print/dispatch/" . $external_id . "/ticket";
            } else if ($this->document_type_id == "COT") {
                $document = Quotation::find($this->document_id);
                $document_filename = $document->filename;
                $external_id = $document->external_id;
                $url1 = $url1 . "/quotations/print/" . $external_id . "/ticket";
            }
            //"" 
            $sender = 'sdrimsac';
            if ($sender == 'tunegociofactvillacorpnet') {
                $sender = 'sdrimsac';
            }
            if ($sender == "sdrimsac") {
                if($configuration->whatsapp_client){
                    $subdomain = explode(".", parse_url($url1, PHP_URL_HOST))[0];
                    $sender = $subdomain;
                    $url = "https://".$subdomain.".sdrpersonal.shop" . '/api/send-media';
                }else{
                    $url = "https://sdrpersonal.shop" . '/api/send-media';
                }
            } else {
                $url = config('app.whatsapp_url') . '/api/send-media';
            }
            // $url = 'http://localhost:3800/api/send-media';

            $content_file = null;

            if (!$xml) {
                $content_file = file_get_contents($url1);
                // $content_file = ($this->document_type_id == "80")  ? file_get_contents(Storage::disk('tenant')->path("sale_note" . DIRECTORY_SEPARATOR . $document_filename . ".pdf")) :   file_get_contents(Storage::disk('tenant')->path("pdf" . DIRECTORY_SEPARATOR . $document_filename . ".pdf"));
            } else {
                $content_file = file_get_contents(Storage::disk('tenant')->path("signed" . DIRECTORY_SEPARATOR . $document_filename . ".xml"));
            }
            $client = new Client([
                'verify' => false,
                'stream' => false,
                'headers' => [
                    'User-Agent' => 'Testing 1.0'
                ]
            ]);
            try {
                $response = $client->post($url, [
                    'multipart' => [
                        [
                            'name'     => 'number',
                            'contents' => "51" . $this->customer_telephone
                        ],
                        [
                            'name'     => 'caption',
                            'contents' => $message
                        ],
                        [
                            'name'     => 'sender',
                            'contents' => $sender ?? 'sdrimsac'
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
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // (new WhatsappController)->sendMessageAll($this->message);
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
