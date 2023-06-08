<?php
namespace App\Http\Requests\Tenant;
use Illuminate\Foundation\Http\FormRequest;

class TravelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'destination'    =>  'required',                 
               'mileage'        =>  'required',                 
               'price'          =>  'required',                
               'carga'          =>  'required',                   
               'travel_date'    =>  'required',                   
               'vehicle_id'     =>  'required',                    
              
        ];
         
    }
    public function messages()
    {
        return [
            'destination.required'  => 'Es obligatorio.',
            'mileage.required'      => 'Es obligatorio.',
            'price.required'        => 'Es obligatorio.',
            'carga.required'        => 'Es obligatorio.',
            'travel_date.required'  => 'Es obligatorio.',
            'vehicle_id.required'   => 'Es obligatorio.',
                         
        ];
    }

}