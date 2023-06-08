<?php

namespace App\Http\ViewComposers\Tenant;

use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;

class CompanyViewComposer
{
    public function compose($view)
    {
        $view->vc_company = Company::first();
        $view->vc_establishment = null;
        if (auth()->user()) {

            $view->vc_establishment = Establishment::find(auth()->user()->establishment_id);
        }
    }
}
