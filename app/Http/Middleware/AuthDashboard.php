<?php

namespace App\Http\Middleware;

use App\Models\Tenant\Cash;
use App\Services\RoleService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AuthDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $date=\Carbon\Carbon::now();
        // $date=$date->format('Y-m-d');
        // $cash=Cash::where('date_opening',$date)->first();

        if (!$request->ajax()) {
            if (auth()->user()->type == 'admin' || auth()->user()->type == 'superadmin') {
                $roleService = new RoleService();
                if ($roleService->isInterno()) {

                    Route::redirect('/', '/items');
                } else {
                    Route::redirect('/', '/documents');
                }
            } else {
                if (strtolower(auth()->user()->worker_type->description) == "mozo") {
                    return redirect()->route('restaurant.workers.dashboard');
                } else {
                    $cocina = strripos(strtolower(auth()->user()->area->description), "cocina");
                    $caja = strripos(strtolower(auth()->user()->area->description), "caja");
                    if ($cocina !== false) {
                        $kitchen = true;
                        return redirect()->route('restaurant.kitchen.dashboard');
                    } else if ($caja !== false) {
                        // if($cash==null){
                        //     return redirect()-> route('restaurant.cash.index');
                        // }else{
                        $pos = true;
                        return redirect()->route('restaurant.pos.dashboard');
                        //}
                    }
                }
                // }
            }
        }
        return $next($request);
    }
}
