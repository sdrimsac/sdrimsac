<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'orthodontics'     =>  'required',   
               'medicine'         =>  'required',    
               'allergy'          =>  'required',    
               'hospital_surgery' =>  'required',    
               'disorder'         =>  'required',
               'brush_teeth'      =>  'required',  
               'high_pressure'    =>  'required', 
               'disease_type_id'  =>  'required', 
               'patient_id'       =>  'required'                
              
        ];
         
    }
    public function messages()
    {
        return [
            'orthodontics.required'      => 'Es obligatorio.',        
            'medicine.required'          => 'Es obligatorio.', 
            'allergy.required'           => 'Es obligatorio.', 
            'hospital_surgery.required'  => 'Es obligatorio.', 
            'disorder.required'          => 'Es obligatorio.', 
            'brush_teeth.required'       => 'Es obligatorio.', 
            'high_pressure.required'     => 'Es obligatorio.', 
            'disease_type_id.required'   => 'Es obligatorio.', 
            'patient_id.required'        => 'Es obligatorio.', 
      
        ];
    }

}