<?php

namespace Modules\Workshop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoVehiculoRequest extends FormRequest
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
            ],
        ];
    }
}