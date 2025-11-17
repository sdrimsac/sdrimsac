<?php
namespace App\Http\Middleware;

use Closure;

class ApiKeyMiddleware
{
    public function handle($request, Closure $next)
    {
        $key = $request->header('X-API-KEY');

        if (!$key || $key !== config('app.balanza_api_key')) {
            return response()->json([
                "success" => false,
                "message" => "No autorizado"
            ], 401);
        }

        return $next($request);
    }
}
