<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiseaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'disease_type_id'      =>  'required',   
               'consultation_reason'  =>  'required',    
               'signs_symptoms'       =>  'required',    
               'personal_background'  =>  'required',    
               'family_background'    =>  'required',
               'medicine'             =>  'required',  
               'medicine_name'        =>  'required', 
               'medicine_reason'      =>  'required', 
               'medicine_dose'        =>  'required',                
               'patient_id'           =>  'required', 
        ];
         
    }
    public function messages()
    {
        return [
            'disease_type_id.required'      => 'Es obligatorio.',        
            'consultation_reason.required'  => 'Es obligatorio.', 
            'signs_symptoms.required'       => 'Es obligatorio.', 
            'personal_background.required'  => 'Es obligatorio.', 
            'family_background.required'    => 'Es obligatorio.', 
            'medicine.required'             => 'Es obligatorio.', 
            'medicine_name.required'        => 'Es obligatorio.', 
            'medicine_reason.required'      => 'Es obligatorio.', 
            'medicine_dose.required'        => 'Es obligatorio.', 
            'patient_id.required'        => 'Es obligatorio.', 
        ];
    }

}