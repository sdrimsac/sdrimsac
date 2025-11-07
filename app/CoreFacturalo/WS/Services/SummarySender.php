<?php

namespace App\CoreFacturalo\WS\Services;

use App\CoreFacturalo\WS\Response\BaseResult;
use App\CoreFacturalo\WS\Response\SummaryResult;
use App\Models\Tenant\Company;
use Hyn\Tenancy\Environment;
use Illuminate\Support\Facades\Log;
use SoapVar;

/**
 * Class SummarySender.
 */
class SummarySender extends BaseSunat
{
    /**
     * @param string $filename
     * @param string $content
     *
     * @return BaseResult
     */
    /* public function send($filename, $content)
    {

        Log::channel('daily')->info('=== Entrando al método SummarySender::send ===', [
            'filename' => $filename
        ]);

        $client = $this->getClient();
        $result = new SummaryResult();

        try {
            $zipContent = $this->compress($filename . '.xml', $content);
            $params = [
                'fileName' => $filename . '.zip',
                'contentFile' => $zipContent,
            ];
            Log::info('Sending summary with filename: ' . $filename . '.zip');
            $response = $client->call('sendSummary', ['parameters' => $params]);

            Log::info("SOAP Request:\n" . $client->getLastRequest());
            Log::info("SOAP Response:\n" . $client->getLastResponse());

            $result
                ->setTicket($response->ticket)
                ->setSuccess(true);

            Log::info('Summary sent successfully, ticket: ' . $response->ticket);
        } catch (\SoapFault $e) {
            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    } */

    public function send($filename, $content)
    {
        //$tenant = app(Environment::class)->tenant();
        $company = Company::first();
        $isOse = optional($company)->soap_send_id === '02';

        $client = $this->getClient();
        $result = new SummaryResult();

        try {
            $zipContent = $this->compress($filename . '.xml', $content);

            if ($isOse) {
                /* Log::info('=== Enviando a OSE dfsfsdfsdgdfgdfgdfg===', [
                    'filename' => $filename
                ]); */

                $fileParam = new SoapVar($filename . '.zip', XSD_STRING, null, null, 'fileName', 'http://service.sunat.gob.pe');
                $contentParam = new SoapVar($zipContent, XSD_BASE64BINARY, null, null, 'contentFile', 'http://service.sunat.gob.pe');

                $params = new SoapVar(
                    [$fileParam, $contentParam],
                    SOAP_ENC_OBJECT,
                    null,
                    null,
                    'sendSummary',
                    'http://service.sunat.gob.pe'
                );

                $response = $client->call('sendSummary', ['parameters' => $params]);
            } else {

                $params = [
                    'fileName' => $filename . '.zip',
                    'contentFile' => $zipContent,
                ];
                //Log::info('Sending summary with filename: ' . $filename . '.zip');
                $response = $client->call('sendSummary', ['parameters' => $params]);
            }

            // Crear los parámetros con namespace correcto


           // Log::info('Sending summary with filename: ' . $filename . '.zip');

            // Guardar request/response
            //$this->saveSoapLog($client);

            $result
                ->setTicket($response->ticket)
                ->setSuccess(true);

            Log::info('Summary sent successfully, ticket: ' . $response->ticket);
        } catch (\SoapFault $e) {
            //$this->saveSoapLog($client, true);
            Log::error("SOAP Fault capturado: " . $e->getMessage());
            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    }


    /**
     * Guarda el request y response SOAP en un archivo en storage/logs
     */
    /* protected function saveSoapLog($client, $isError = false)
    {
        try {
            $type = $isError ? 'error' : 'ok';
            $path = storage_path("logs/soap_summary_" . $type . "_" . date('Ymd_His') . ".xml");

            file_put_contents(
                $path,
                "==== SOAP REQUEST ====\n" . $client->getLastRequest() .
                    "\n\n==== SOAP RESPONSE ====\n" . $client->getLastResponse()
            );

            Log::info("SOAP log guardado en: " . $path);
        } catch (\Throwable $e) {
            Log::error("No se pudo guardar el SOAP log: " . $e->getMessage());
        }
    } */
}
