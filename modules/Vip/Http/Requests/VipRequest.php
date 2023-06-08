<?php

namespace Modules\Vip\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VipRequest extends FormRequest
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
                Rule::unique('tenant.vips')->ignore($id),
            ],
            'percentage' => ['required']
        ];
    }
}
