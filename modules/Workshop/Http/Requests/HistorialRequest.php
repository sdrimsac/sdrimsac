<?php

namespace Modules\Workshop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistorialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        return [
            'placa' => [
                'required',
            ],
        ];
    }
}