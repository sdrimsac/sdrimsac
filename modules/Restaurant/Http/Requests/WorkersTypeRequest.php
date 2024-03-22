<?php

namespace Modules\Restaurant\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkersTypeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        return [
            'description' => [

                'required',
                Rule::unique('tenant.workers_type')->ignore($id),
            ],
            'active' => [
                'required',
            ]
        ];
    }
}
