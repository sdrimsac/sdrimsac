<?php

namespace App\Http\Middleware;

use App\Models\Tenant\Configuration;
use Closure;
use App\Services\RoleService;
use Modules\Restaurant\Models\WorkersType;

class JustAdmin
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
        $config = Configuration::first();
        $user = $request->user();
        $path = $request->path();
        $type = $user->type;

        $isAccountant = false;
        $worker_types = WorkersType::where('description', 'like', '%CONTA%')->first();
        if ($worker_types != null) {
            $worker_type_id = $user->worker_type_id;
            $isAccountant = $worker_type_id == $worker_types->id;
        }

        $paths = ["documents", "documents/not-sent", "summaries", "voided", "reports/inventory"];


        if ($type != 'admin' && $type != "superadmin") {
            if ($isAccountant) {
                $pathPass = in_array($path, $paths);
                if (!$pathPass) {
                    $roleService = new RoleService();
                    if ($roleService->isInterno()) {

                        return redirect('/', '/items');
                    } else {
                        return redirect('/', '/documents');
                    }
                }
            } else {

                $internet = (bool) $config->internet;
                $configuration = Configuration::first();
                if ($configuration->toll) {
                    $redirect_to = "toll";
                    return redirect($redirect_to);
                }
                $redirect_to = $internet ? "/internet/worker/" :  "/caja/worker/";

                $worker_type = WorkersType::find($user->worker_type_id);
                $description_type = strtoupper($worker_type->description);
                if (str_contains($description_type, 'COCI')) {
                    $redirect_to .= 'dashboard-kitchen';
                } else if (str_contains($description_type, 'CAJ')) {
                    $redirect_to .= 'dashboard-pos';
                } else if ($description_type == 'LIMPIEZA') {
                    $redirect_to .= 'cleaner';
                } else if ($description_type == 'MANTENIMIENTO') {
                    $redirect_to .= 'maintenance';
                } else {
                    $redirect_to .= 'dashboard';
                }
                return redirect($redirect_to);
            }
        }

        return $next($request);
    }
}
