<?php

namespace Modules\Dental\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TariffRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'process'            =>  'required',   
               'category'           =>  'required',    
               'price'              =>  'required',    
               'measure'            =>  'required',    
               'type_concept'       =>  'required',
               'state'              =>  'required',                 
        ];
         
    }
    public function messages()
    {
        return [
            'process.required'        => 'Es obligatorio.',        
            'category.required'       => 'Es obligatorio.', 
            'price.required'          => 'Es obligatorio.', 
            'measure.required'        => 'Es obligatorio.', 
            'type_concept.required'   => 'Es obligatorio.', 
            'state.required'          => 'Es obligatorio.', 
        ];
    }

}