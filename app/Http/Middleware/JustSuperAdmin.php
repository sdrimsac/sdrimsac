<?php

namespace App\Http\Middleware;

use Closure;


class JustSuperAdmin
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
        $user = $request->user();
        $type = $user->type;



        if ($type != "superadmin") {



            return redirect("/");
        }

        return $next($request);
    }
}
