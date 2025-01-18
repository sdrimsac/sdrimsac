<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllergiesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'observation'        =>  'required',   
               'allergies_types_id' =>  'required',    
               'patient_id'         =>  'required',    
        ];
         
    }
    public function messages()
    {
        return [
            'observation.required'        => 'Es obligatorio.',        
            'allergies_types_id.required' => 'Es obligatorio.', 
            'patient_id.required'         => 'Es obligatorio.' 
        ];
    }

}