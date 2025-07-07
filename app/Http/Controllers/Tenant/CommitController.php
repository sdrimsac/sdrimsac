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

        $commit = exec('git rev-parse HEAD');
        $commit = substr($commit, 0, 7);

        if (!$commit) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró ningún commit.',
            ]);
        }

        $update = false;

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
        $versionFile = base_path('.version');

        if (!file_exists($versionFile)) {
            return response()->json([
                'success' => false,
                'message' => 'Archivo de versión no encontrado.',
            ]);
        }

        $commit = trim(file_get_contents($versionFile));

        $update = false;

        $existingCommit = DB::connection('tenant')->table('commits')->where('commit', $commit)->first();

        if (!$existingCommit) {
            DB::connection('tenant')->table('commits')->insert(['commit' => $commit]);
            $update = true;
        }

        return response()->json([
            'success' => true,
            'update' => $update,
            'commit' => $commit,
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
