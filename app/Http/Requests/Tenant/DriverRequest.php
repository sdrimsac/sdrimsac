<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DriverRequest extends FormRequest
{

    public function rules()
    {
        return [
            
            'number' => [
                'required',
            ],
        ];
    }
}
