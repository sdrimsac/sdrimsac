<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SystemGitUpdateController extends Controller
{
    public function updateFromGit(Request $request)
    {
        // Solo permitir a usuarios autorizados (puedes ajustar esto)
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403);
        }

        $commands = [
            'git pull https://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@github.com/sdrimsac/sdrimsac.git',
            'php artisan migrate --force',
            'php artisan tenancy:migrate --force',
            'php artisan optimize:clear',
            'php artisan queue:restart',
        ];
        $output = [];
        foreach ($commands as $cmd) {
            $process = Process::fromShellCommandline($cmd, base_path());
            $process->setTimeout(300);
            $process->run();
            $output[] = [
                'command' => $cmd,
                'output' => $process->getOutput(),
                'error' => $process->getErrorOutput(),
                'success' => $process->isSuccessful(),
            ];
            if (!$process->isSuccessful()) {
                return back()->with('error', 'Error en: ' . $cmd . '<br>' . $process->getErrorOutput());
            }
        }
        return back()->with('success', 'Actualización completada correctamente.')->with('git_output', $output);
    }
}
