<?php

namespace App\Http\Controllers\Tenant;

use App\Events\CommitEvent;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Commit;
use Illuminate\Support\Facades\DB;

class CommitController extends Controller
{

    public function store()
    {
       
        $update = false;

        $commit = exec('git rev-parse HEAD');
        $commit = substr($commit, 0, 7);

        $existingCommit = DB::connection('tenant')->table('commits')->where('commit', $commit)->first();

        if (!$existingCommit) {
            DB::connection('tenant')->table('commits')->insert(['commit' => $commit]);
            /* event(new CommitEvent('Nuevo commit capturado: ' . $commit)); */
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
