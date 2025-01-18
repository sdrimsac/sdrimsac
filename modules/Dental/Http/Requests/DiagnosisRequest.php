<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiagnosisRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'cie10'               =>  'required',   
               'description'         =>  'required',    
                'state'              =>  'required', 
                 
        ];
         
    }
    public function messages()
    {
        return [
            'cie10.required'           => 'Es obligatorio.',        
            'description.required'     => 'Es obligatorio.', 
            'state.required'           => 'Es obligatorio.', 
            
        ];
    }

}