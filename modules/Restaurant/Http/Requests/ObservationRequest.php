<?php

namespace Modules\Restaurant\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ObservationRequest extends FormRequest
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
                Rule::unique('tenant.observations')->ignore($id),
            ],
            'active' => [
                'required',
            ]
        ];
    }
}
