<?php

namespace Modules\Billar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarifaCasinoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        return [
            'hora' => [
                'required',
            ],
        ];
    }
}