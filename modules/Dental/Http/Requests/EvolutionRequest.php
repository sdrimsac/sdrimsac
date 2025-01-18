<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvolutionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'patient_id'=>  'required',   
               'medic_id'  =>  'required',    
               'date'      =>  'required'    
                            
              
        ];
         
    }
    public function messages()
    {
        return [
            'patient_id.required'        => 'Es obligatorio.',        
            'medic_id.required'          => 'Es obligatorio.', 
            'date.required'              => 'Es obligatorio.', 
           
        ];
    }

}