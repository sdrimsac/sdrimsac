<?php

namespace App\Contracts\Services;

interface SunatContractService

{

    public function processTxt($file);

    public function processRuc10($userRuc, $userSunat, $userPassword,$ruc);

    public function processDownloadxml($userRuc, $userSunat, $userPassword,$filexml);

    public function processXml($userRuc, $serie, $numero, $mode,$token,$proceso);

    public function processReniec($dni,$usuario,$clave);
}
