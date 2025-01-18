<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'patient_id'             =>  'required',   
               'medic_id'               =>  'required',    
               'date'                   =>  'required',    
               'time'                   =>  'required',    
               'price'                  =>  'required',
               'state'                  =>  'required', 
               'reason_consultation'    =>  'required', 
               'observation'            =>  'required',               
        ];
         
    }
    public function messages()
    {
        return [
            'patient_id.required'           => 'Es obligatorio.',        
            'medic_id.required'             => 'Es obligatorio.', 
            'date.required'                 => 'Es obligatorio.', 
            'time.required'                 => 'Es obligatorio.', 
            'price.required'                => 'Es obligatorio.', 
            'state.required'                => 'Es obligatorio.', 
            'reason_consultation.required'  => 'Es obligatorio.', 
            'observation.required'          => 'Es obligatorio.', 
        ];
    }

}