<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckExpiredSession
{

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            DB::connection('tenant')->table('user_sessions')
                ->where('user_id', Auth::id())
                ->update(['last_activity' => now()]);
        }

        return $next($request);
    }

    /* public function handle($request, Closure $next)
    {
        $sessionId = Session::getId();

        if (!Auth::check()) {
            if ($request->session()->has('session_id')) {
                $userId = $request->session()->get('user_id');
                
                $dbSession = DB::connection('tenant')
                    ->table('user_sessions')
                    ->where('user_id', $userId)
                    ->first();

                if ($dbSession && $dbSession->session_id !== $sessionId) {
                    DB::connection('tenant')->table('user_sessions')
                        ->where('user_id', $userId)
                        ->where('session_id', $dbSession->session_id)
                        ->delete();

                    $request->session()->forget('user_id');
                }
            }
        } else {
            $request->session()->put('user_id', Auth::id());
        }

        return $next($request);
    } */
}
