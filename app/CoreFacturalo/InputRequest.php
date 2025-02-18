<?php

namespace App\CoreFacturalo;

use Closure;
use Illuminate\Support\Facades\Log;

class InputRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  $type
     * @param  $service
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next, $type, $service)
    {
        $inputs = $request->all();
        if($service === 'api') {
            $inputs = $this->transformInputs($inputs, $type);
        }
        $inputs = $this->validationInputs($inputs, $type, $service);
        $request->replace($this->setInputs($inputs, $type, $service));
        return $next($request);
    }

    private function transformInputs($inputs, $type)
    {
        $class = "App\\CoreFacturalo\\Requests\\Api\\Transform\\".ucfirst($type)."Transform";
        Log::info('class transform: ' . $class);
        return $class::transform($inputs);
    }

    private function validationInputs($inputs, $type, $service)
    {
        $class = "App\\CoreFacturalo\\Requests\\".ucfirst($service)."\\Validation\\".ucfirst($type)."Validation";
        Log::info('class validation: ' . $class);
        Log::info('inputs validation: ' . json_encode($inputs));
        return $class::validation($inputs);
    }

    private function setInputs($inputs, $type, $service)
    {
        $class = "App\\CoreFacturalo\\Requests\\Inputs\\".ucfirst($type)."Input";
        return $class::set($inputs, $service);
    }
}