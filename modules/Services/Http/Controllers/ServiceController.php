<?php

namespace Modules\Services\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Services\Data\ServiceData;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class ServiceController extends Controller
{
    public function service($type, $number)
    {

        return ServiceData::service($type, $number);
    }

    public function exchange(Request $request)
    {
        $date = $request->date;

        return ServiceData::exchange_rate($date);
    }
}
