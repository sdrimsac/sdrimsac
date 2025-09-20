<?php

namespace App\Http\Middleware;

use Closure;

class DetectDesarrollador
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        if (str_contains($host, 'sdrimsac') || str_contains($host, 'sdrclientes')) {
            $desarrollador = 'SDRIMSAC SOLUTIONS';
        } else {
            $desarrollador = 'GRUPO VILLACORP';
        }

        view()->share('desarrollador', $desarrollador);

        return $next($request);
    }
}
