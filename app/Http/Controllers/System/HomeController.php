<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\System\Client;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class HomeController extends Controller
{
    public function index()
    {
        $clients = Client::get();
        $delete_permission = config('tenant.admin_delete_client');


        $storage_size = exec("df -h / | awk '{print $5}' | tail -n 1");

        $storage_size = $storage_size != "" ? substr($storage_size, 0) : 0;


        return view('system.dashboard')->with('clients', count($clients))
            ->with('delete_permission', $delete_permission)
            ->with('disc_used', $storage_size)
            ->with('i_used', 0)
            ->with('storage_size', 0)
            ->with('version', 0);
    }

    public function restartWhatsapp()
    {
        try {
            $pm2Process = new Process(['/root/.nvm/versions/node/v18.20.4/bin/pm2', 'restart', 'whatsapp', '--cron', '0,30 21-23 * * *', '--cron', '0,30 0-3 * * *', '--cron', '0 */2 4-20 * * *']);
            $pm2Process->run();

            if (!$pm2Process->isSuccessful()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al reiniciar PM2: ' . $pm2Process->getErrorOutput(),
                ], 500);
            }

            sleep(30);

            $shProcess = new Process(['/home/crons/checkStatus.sh']);
            $shProcess->run();

            if (!$shProcess->isSuccessful()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al ejecutar el script: ' . $shProcess->getErrorOutput(),
                ], 500);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Se reinició el servicio de WhatsApp correctamente.',
            ], 200);
        } catch (ProcessFailedException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error en el proceso: ' . $e->getMessage(),
            ], 500);
        }
    }
}
