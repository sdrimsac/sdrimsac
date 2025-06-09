<?php

namespace App\Http\Controllers\Tenant;

use App\Events\CommitEvent;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Commit;
use Illuminate\Support\Facades\DB;

class CommitController extends Controller
{

    /* public function store()
    {
        $update = false;

        $commit = exec('git rev-parse HEAD');
        $commit = substr($commit, 0, 7);

        $existingCommit = DB::connection('tenant')->table('commits')->where('commit', $commit)->first();

        if (!$existingCommit) {
            DB::connection('tenant')->table('commits')->insert(['commit' => $commit]);
            $update = true;
        }

        return response()->json([
            'success' => true,
            'update' => $update,
            'message' => 'Commit capturado y guardado con éxito.',
        ]);
    } */
    public function store()
    {
        $update = false;
        $commit = null;

        // 1. Intentar usar exec() si está disponible
        if (function_exists('exec') && !in_array('exec', explode(',', ini_get('disable_functions')))) {
            $commit = exec('git rev-parse --short HEAD');
        }

        // 2. Si exec falló, intentar leer desde un archivo version.txt
        if (!$commit) {
            $path = public_path('version.txt');
            if (file_exists($path)) {
                $commit = trim(file_get_contents($path));
            }
        }

        // 3. Verificar si obtuvimos un commit válido
        if (!$commit) {
            return response()->json([
                'success' => false,
                'update' => false,
                'message' => 'No se pudo obtener el commit.',
            ], 500);
        }

        // 4. Buscar e insertar si es nuevo
        $existingCommit = DB::connection('tenant')->table('commits')->where('commit', $commit)->first();

        if (!$existingCommit) {
            DB::connection('tenant')->table('commits')->insert(['commit' => $commit]);
            $update = true;
        }

        return response()->json([
            'success' => true,
            'update' => $update,
            'message' => 'Commit capturado y guardado con éxito.',
        ]);
    }
    public function configuration()
    {
        $configuration  = Configuration::first();
        return response()->json([
            'success' => true,
            'socket' => $configuration->socket_channel,
        ]);
    }
}
