<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Allergies_TypesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
             'description' => 'required',      
             'active'      => 'required',                
        ];
         
    }
    public function messages()
    {
        return [
            'description.required'  => 'Es obligatorio.',    
            'active.required'       => 'Es obligatorio.',       
        ];
    }
}