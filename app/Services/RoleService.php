<?php

namespace App\Services;

use App\Models\Tenant\Company;
use Modules\Restaurant\Models\WorkersType;

class RoleService
{

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
}
