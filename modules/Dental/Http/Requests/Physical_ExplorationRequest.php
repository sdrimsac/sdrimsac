<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Physical_ExplorationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'blood_pressure'               =>  'required',   
               'pulse'                        =>  'required',    
               'temperature'                  =>  'required',    
               'heart_rate'                   =>  'required',    
               'respiratory_rate'             =>  'required',
               'weight'                       =>  'required',  
               'height'                       =>  'required', 
               'imc'                          =>  'required', 
               'general_clinical_examination' =>  'required',                
               'complementary_examination'    =>  'required', 
               'odontostomatological'         =>  'required', 
               'patient_id'                   =>  'required', 
        ];
         
    }
    public function messages()
    {
        return [
            'blood_pressure.required'               => 'Es obligatorio.',        
            'pulse.required'                        => 'Es obligatorio.', 
            'temperature.required'                  => 'Es obligatorio.', 
            'heart_rate.required'                   => 'Es obligatorio.', 
            'respiratory_rate.required'             => 'Es obligatorio.', 
            'weight.required'                       => 'Es obligatorio.', 
            'height.required'                       => 'Es obligatorio.', 
            'imc.required'                          => 'Es obligatorio.', 
            'general_clinical_examination.required' => 'Es obligatorio.', 
            'complementary_examination.required'    => 'Es obligatorio.', 
            'odontostomatological.required'         => 'Es obligatorio.', 
            'patient_id.required'                   => 'Es obligatorio.', 
        ];
    }

}