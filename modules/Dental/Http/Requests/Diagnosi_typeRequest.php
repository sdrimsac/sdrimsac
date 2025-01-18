<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Diagnosi_TypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
             'CIE10'       => 'required',     
             'description' => 'required',                
        ];
         
    }
    public function messages()
    {
        return [
            'CIE10.required'       => 'Es obligatorio.',    
            'description.required' => 'Es obligatorio.',       
        ];
    }
}