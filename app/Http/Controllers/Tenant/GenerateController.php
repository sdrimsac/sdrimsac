<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Requests\Tenant\GroupRequest;
use App\Http\Resources\Tenant\GroupCollection;
use App\Http\Resources\Tenant\GroupResource;
use App\Models\Tenant\Group;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output\Html;

class GenerateController extends Controller
{
    public function index()
    {
        return view('tenant.groups.index');
    }

    public function generateYapeQR($amount)
    {
        $cellphone = '935921640'; // Tu número de teléfono Yape
        $amount = number_format($amount, 2, '.', '');

        // EMVCo pseudo-formato para QR Yape
        $qrString = "00020101021226360014yape.com.pe0118936010{$cellphone}520400005303604540{$amount}5802PE5908MiNegocio6007LIMA0010PagoVenta6304";

        // Generar QR y convertirlo a base64
        $qrCode = new QrCode($qrString);
        $output = new Html();
        $qrHtml = $output->output($qrCode, 300);
        
        return response()->json([
            'qr' => $qrHtml,
            'amount' => $amount
        ]);
    }
}
