<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecialtyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
             'description' => 'required',                 
        ];
         
    }
    public function messages()
    {
        return [
            'description.required' => 'Es obligatorio.',        
        ];
    }
}