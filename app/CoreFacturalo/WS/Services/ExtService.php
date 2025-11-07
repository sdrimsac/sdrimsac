<?php

namespace App\CoreFacturalo\WS\Services;

use App\CoreFacturalo\WS\Response\Error;
use App\CoreFacturalo\WS\Response\StatusResult;
use App\Models\Tenant\Company;
use Hyn\Tenancy\Environment;
use Illuminate\Support\Facades\Log;
use SoapVar;

/**
 * Class ExtService.
 */
class ExtService extends BaseSunat
{
    /**
     * @param string $ticket
     *
     * @return StatusResult
     */
    /* public function getStatus($ticket)
    {
        $client = $this->getClient();
        $result = new StatusResult();

        try {
            $params = [
                'ticket' => $ticket,
            ];
            $response = $client->call('getStatus', ['parameters' => $params]);
            $status = $response->status;
            $code = $status->statusCode;

            $result->setCode($code);

            if ($this->isPending($code)) {
                $result->setError($this->getCustomError($code));

                return $result;
            }

            if ($this->isProcessed($code)) {
                $cdrZip = $status->content;
                $result
                    ->setSuccess(true)
                    ->setCdrResponse($this->extractResponse($cdrZip))
                    ->setCdrZip($cdrZip);

                $code = $result->getCdrResponse()->getCode();
            }

            if ($this->isExceptionCode($code)) {
                $this->loadErrorByCode($result, $code);
            }
        } catch (\SoapFault $e) {
            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    } */

    public function getStatus($ticket)
    {

        /* $tenant = app(Environment::class)->tenant();
        $company = Company::find(optional($tenant)->id);
        $isOse = optional($company)->soap_send_id === '02'; */

        $company = Company::first();
        $isOse = optional($company)->soap_send_id === '02';

        $client = $this->getClient();
        $result = new StatusResult();

        try {
            // Forzar prefijo ns1 en <ticket>
            if ($isOse) {

                $ticketParam = new SoapVar($ticket, XSD_STRING, null, null, 'ticket', 'http://service.sunat.gob.pe');
                $params = new SoapVar([$ticketParam], SOAP_ENC_OBJECT, null, null, 'getStatus', 'http://service.sunat.gob.pe');

                // Llamada SOAP
                $response = $client->call('getStatus', ['parameters' => $params]);
            } else {
                $params = [
                    'ticket' => $ticket,
                ];
                $response = $client->call('getStatus', ['parameters' => $params]);
            }

            // Guardar XML request y response
            /* file_put_contents(storage_path("logs/soap_request_{$ticket}.xml"), $client->getLastRequest());
            file_put_contents(storage_path("logs/soap_response_{$ticket}.xml"), $client->getLastResponse());

            Log::info('SOAP Request getStatus:', ['request' => $client->getLastRequest()]);
            Log::info('SOAP Response getStatus:', ['response' => $client->getLastResponse()]); */

            $status = $response->status;
            $code = $status->statusCode;

            $result->setCode($code);

            if ($this->isPending($code)) {
                $result->setError($this->getCustomError($code));
                return $result;
            }

            if ($this->isProcessed($code)) {
                $cdrZip = $status->content;
                $result
                    ->setSuccess(true)
                    ->setCdrResponse($this->extractResponse($cdrZip))
                    ->setCdrZip($cdrZip);

                $code = $result->getCdrResponse()->getCode();
            }

            if ($this->isExceptionCode($code)) {
                $this->loadErrorByCode($result, $code);
            }
        } catch (\SoapFault $e) {
            // Guardar XML request y response en caso de error
            /* file_put_contents(storage_path("logs/soap_request_{$ticket}.xml"), $client->getLastRequest());
            file_put_contents(storage_path("logs/soap_response_{$ticket}.xml"), $client->getLastResponse()); */

            Log::error('SOAP Fault getStatus:', [
                'message' => $e->getMessage(),
                'request' => $client->getLastRequest(),
                'response' => $client->getLastResponse(),
            ]);

            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    }

    /**
     * @param string $code
     * @return Error
     */
    private function getCustomError($code)
    {
        $error = new Error();
        $error->setCode($code)
            ->setMessage('El procesamiento del comprobante aún no ha terminado');

        return $error;
    }

    private function isProcessed($code)
    {
        return '0' == $code || '99' == $code;
    }

    private function isPending($code)
    {
        return '98' == $code;
    }
}
