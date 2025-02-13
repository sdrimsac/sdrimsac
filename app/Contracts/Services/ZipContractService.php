<?php

namespace App\Contracts\Services;

interface ZipContractService
{
    public function unzipFile($filexml,$filePath);
}