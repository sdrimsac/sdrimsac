<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeriesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        return [
            'document_type_id' => [
                'required',
            ],
            'number' => [
                'required',
                Rule::unique('tenant.series')->ignore($id),
            ],
        ];
    }

    /* public function rules()
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
    } */
}