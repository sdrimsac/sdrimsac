<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant\Configuration;
use Illuminate\Support\Facades\DB;

class LockedTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $configuration = Configuration::first();

        

        if($configuration->locked_tenant){
            abort(403);
            // return view('tenant.errors.403');
        }

        return $next($request);
    }
}
