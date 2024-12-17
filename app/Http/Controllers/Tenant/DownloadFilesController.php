<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\Http\Controllers\Controller;


class DownloadController extends Controller
{
    use StorageDocument;

    public function download_all_files()
    {
    }

    public function index()
    {
        return view('tenant.download_files.index');
    }


}
