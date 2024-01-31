<?php

namespace App\Services;

use App\Models\Tenant\Company;
use App\Models\Tenant\ConfEstablishment;
use App\Models\Tenant\Establishment;
use Modules\Restaurant\Models\WorkersType;

class RoleService
{
    public static function isArcaUserId($id){
        $user = \App\Models\Tenant\User::find($id);
        $worker_type_id = $user->worker_type_id;
        if ($worker_type_id == null) {
            return false;
        }
        $worker_types = WorkersType::where('description', 'ARCA')->first();
        if ($worker_types != null) {
            return $worker_types->id == $worker_type_id;
        }
        return false;
    }
    public static function isLogistic()
    {
        $worker_type_id = auth()->user()->worker_type_id;
        if ($worker_type_id == null) {
            return false;
        }
        $worker_types = WorkersType::where('description', 'LOGISTICA')->first();
        if ($worker_types != null) {
            return $worker_types->id == $worker_type_id;
        }
        return false;
    }
    public function isArca()
    {
        $worker_type_id = auth()->user()->worker_type_id;
        if ($worker_type_id == null) {
            return false;
        }
        $worker_types = WorkersType::where('description', 'ARCA')->first();
        if ($worker_types != null) {
            return $worker_types->id == $worker_type_id;
        }
        return false;
    }
    public function isAccountant($worker_type_id)
    {
        $worker_types = WorkersType::where('description', 'like', '%CONTA%')->first();
        if ($worker_types != null) {
            return $worker_types->id == $worker_type_id;
        }
        return false;
    }

    public function isInterno()
    {
        $company = Company::first();
        return $company->soap_type_id == "03";
    }

    public function documentsDisabled()
    {
        $establishment_id = auth()->user()->establishment_id;
        $conf = Establishment::find($establishment_id);
        $documents = $conf->documents;
        if ($documents) {
            if (count($documents) > 0) {
                $invoice = $documents['invoice'];
                $receipt = $documents['receipt'];

                if ($invoice== false && $receipt == false) {
                    return true;
                }
            }
        }
        return false;
    }
}
