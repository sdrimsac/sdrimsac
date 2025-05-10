<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckExpiredSession
{

    /* public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            DB::connection('tenant')->table('user_sessions')
                ->where('user_id', Auth::id())
                ->update(['last_activity' => now()]);
        }

        return $next($request);
    } */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && config('database.connections.tenant')) {
            try {
                DB::connection('tenant')->table('user_sessions')
                    ->where('user_id', Auth::id())
                    ->update(['last_activity' => now()]);
            } catch (\Exception $e) {
                // Puedes loguear si quieres saber si algo falló
                
            }
        }

        return $next($request);
    }
}
