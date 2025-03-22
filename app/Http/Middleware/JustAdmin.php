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
        $isLogistic = false;
        $isArca = false;

        $isLogistic = RoleService::isLogistic();
        //crear una variable $isArca y que sea true si el usuario actual tiene el worker_type de ARCA
        $worker_types = WorkersType::where('description', 'ARCA')->first();
        if ($worker_types != null) {
            $worker_type_id = $user->worker_type_id;
            $isArca = $worker_type_id == $worker_types->id;
        }
        //crear una variable $isAccountant y que sea true si el usuario actual tiene el worker_type de CONTA

        $worker_types = WorkersType::where('description', 'like', '%CONTA%')->first();
        if ($worker_types != null) {
            $worker_type_id = $user->worker_type_id;
            $isAccountant = $worker_type_id == $worker_types->id;
        }

        $paths = ["documents", "documents/not-sent", "summaries", "voided", "reports/inventory"];
        $paths_arca = [
            "items",
            "item-sets",
            "reports/inventory",
            "reports/stockmin",
            "reports/kardex",
            "persons/customers",
            "persons/suppliers",
            "reports/boxes/global",
            "category",
            "advanced",
            "purchases",
            "purchases/create",
            "sale-notes",
            "quotations",
            "summaries",
            "voided",
            "incomes",
            "expenses",
            "boxes",
            "report_closed_cash",
            "documents",
            "banks",
            "documents_ventas"
        ];
        $paths_logistic = [
            "items",
            "purchases",
            "purchases/create",
            "transfers",
            "transfers/transfer_place",
            "dispatches",
            "item-sets",
            "reports/inventory",
            "report_product_client",
            "reports/stockmin",
            "reports/kardex",
            "documents_ventas",
            "nota_venta",
            "productos",
            "receta"
        ];
        $worker_type = WorkersType::find($user->worker_type_id);
        // $redirect_to = "";
        if ($worker_type) {
            $description_type = $worker_type->description;
            $description_type = strtoupper($description_type);
        } else {
            $description_type = "";
        }
        if ($type != 'admin' && $type != "superadmin" || $isLogistic || $isArca) {
            if ($isAccountant) {
                $pathPass = in_array($path, $paths);
                if (!$pathPass) {
                    $roleService = new RoleService();
                    if ($roleService->isInterno()) {
                        return redirect('/items');
                    } else {
                        return redirect('/documents');
                    }
                }
            } else if ($isLogistic) {
                $pathPass = in_array($path, $paths_logistic);
                if (!$pathPass) {
                    return redirect('/purchases');
                }
            } else if ($isArca) {
                $pathPass = in_array($path, $paths_arca);
                if (!$pathPass) {
                    return redirect('/incomes');
                }
            } else {
                $internet = (bool) $config->internet;
                $modo_billar = (bool) $config->modo_billar;
                $workshop = (bool) $config->workshop;
                $odontologia = (bool) $config->odontologia;
                $rent = (bool) $config->mod_renta;
                $salon = (bool) $config->mode_salon;

                if ($config->toll) {
                    $redirect_to = "/caja/worker/dashboard-pos";
                    return redirect($redirect_to);
                }
                if ($internet) {
                    $redirect_to = "/internet/worker/";
                } elseif ($modo_billar) {
                    $redirect_to = "/billar/worker/";
                } 
                else if ($workshop) {
                    if ($description_type == 'CAJERO MECANICO') {

                        $redirect_to = "/workshop/worker/";
                    }else{
                        $redirect_to = "/caja/worker/";
                    }
                } 
                else if ($odontologia) {
                    $redirect_to = "/dental/worker/";
                }
                else {
                    $redirect_to = "/caja/worker/";
                }

             

                if (str_contains($description_type, 'COCI')) {
                    $redirect_to .= 'dashboard-kitchen';
                } else if (str_contains($description_type, 'CAJ') || str_contains($description_type, 'VEN') || str_contains($description_type, 'ANALISTA')) {
                    if($rent){
                        $redirect_to .= 'rent-pos';
                    }
                    else if($salon){
                        $redirect_to .= 'salon-pos';
                    }
                    else{
                        $redirect_to .= 'dashboard-pos';
                    }
                } else if ($description_type == 'LIMPIEZA') {
                    $redirect_to .= 'cleaner';
                } else if ($description_type == 'MANTENIMIENTO') {
                    $redirect_to .= 'maintenance';
                } 
                else if ($description_type == 'ESTILISTA') {
                    $redirect_to .= 'caja/estilista/time-worker';
                }
                else {
                    $redirect_to .= 'dashboard';
                }
                return redirect($redirect_to);
            }
        }

        return $next($request);
    }
}

