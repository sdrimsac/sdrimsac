<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
             'name' => 'required',                 
        ];
         
    }
    public function messages()
    {
        return [
            'name.required' => 'Es obligatorio.',        
        ];
    }
}