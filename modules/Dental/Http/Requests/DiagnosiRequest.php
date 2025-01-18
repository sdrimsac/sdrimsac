<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiagnosiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'diagnosis_types_id'=>  'required',   
               'date'              =>  'required',     
               'patient_id'        =>  'required'                
              
        ];
         
    }
    public function messages()
    {
        return [
            'diagnosis_types_id.required'=> 'Es obligatorio.',        
            'date.required'              => 'Es obligatorio.', 
            'patient_id.required'        => 'Es obligatorio.' 
      
        ];
    }

}