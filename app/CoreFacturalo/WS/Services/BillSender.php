<?php

namespace App\CoreFacturalo\WS\Services;

use App\CoreFacturalo\WS\Response\BillResult;
use App\Models\Tenant\Company;
use Illuminate\Support\Facades\Log;
use SoapVar;

/**
 * Class BillSender.
 */
class BillSender extends BaseSunat
{
    /**
     * @param string $filename
     * @param string $content
     *
     * @return mixed
     */
    /* public function send($filename, $content)
    {
        $client = $this->getClient();
        $result = new BillResult();

        try {
            $zipContent = $this->compress($filename . '.xml', $content);
            $params = [
                'fileName' => $filename . '.zip',
                'contentFile' => $zipContent,
            ];
            $response = $client->call('sendBill', ['parameters' => $params]);
            $cdrZip = $response->applicationResponse;
            $result
                ->setCdrResponse($this->extractResponse($cdrZip))
                ->setCdrZip($cdrZip)
                ->setSuccess(true);
        } catch (\SoapFault $e) {
            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    } */

    public function send($filename, $content)
    {

        $company = Company::first();
        $isOse = optional($company)->soap_send_id === '02';

        $client = $this->getClient();
        $result = new BillResult();

        try {
            // Comprimir el XML
            $zipContent = $this->compress($filename . '.xml', $content);

            if ($isOse) {

                $fileParam = new SoapVar($filename . '.zip', XSD_STRING, null, null, 'fileName', 'http://service.sunat.gob.pe');
                $contentParam = new SoapVar($zipContent, XSD_BASE64BINARY, null, null, 'contentFile', 'http://service.sunat.gob.pe');

                $params = new SoapVar(
                    [$fileParam, $contentParam],
                    SOAP_ENC_OBJECT,
                    null,
                    null,
                    'sendBill',
                    'http://service.sunat.gob.pe'
                );

                // Llamada SOAP
                $response = $client->call('sendBill', ['parameters' => $params]);
            } else {

                $params = [
                    'fileName' => $filename . '.zip',
                    'contentFile' => $zipContent,
                ];
                $response = $client->call('sendBill', ['parameters' => $params]);
            }

            // Forzar prefijo ns1 si quieres (opcional)


            // Guardar SOAP request y response en archivos
            /* file_put_contents(storage_path("logs/soap_request_{$filename}.xml"), $client->getLastRequest());
            file_put_contents(storage_path("logs/soap_response_{$filename}.xml"), $client->getLastResponse()); */

            // Guardar en log de Laravel
            //Log::info('SOAP Request sendBill:', ['request' => $client->getLastRequest()]);
            //Log::info('SOAP Response sendBill:', ['response' => $client->getLastResponse()]);

            // Procesar response
            $cdrZip = $response->applicationResponse;
            $result
                ->setCdrResponse($this->extractResponse($cdrZip))
                ->setCdrZip($cdrZip)
                ->setSuccess(true);
        } catch (\SoapFault $e) {
            // Guardar también request/response si hay error
            /* file_put_contents(storage_path("logs/soap_request_{$filename}.xml"), $client->getLastRequest());
            file_put_contents(storage_path("logs/soap_response_{$filename}.xml"), $client->getLastResponse()); */

            Log::error('SOAP Fault sendBill:', [
                'message' => $e->getMessage(),
                'request' => $client->getLastRequest(),
                'response' => $client->getLastResponse(),
            ]);

            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    }
}
