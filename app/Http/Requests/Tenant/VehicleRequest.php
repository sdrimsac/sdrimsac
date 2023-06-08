<?php
namespace App\Http\Requests\Tenant;
use Illuminate\Foundation\Http\FormRequest;
class VehicleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'business_name'           =>  'required',                 
               'filming_plate'           =>  'required',                 
               'vehicle_class'           =>  'required',                
               'axle_number'             =>  'required',                   
               'manufacturing_Year'      =>  'required',                   
               'mark'                    =>  'required',                    
               'chassis_number'          =>  'required',                    
               'model'                   =>  'required',                    
               'number_seats'            =>  'required',                
               'bodywork'                =>  'required',                 
               'load_capacity'           =>  'required',     
               
               
        ];
         
    }
    public function messages()
    {
        return [
            'business_name.required'        => 'Es obligatorio.',
            'filming_plate.required'        => 'Es obligatorio.',
            'vehicle_class.required'        => 'Es obligatorio.',
            'axle_number.required'          => 'Es obligatorio.',
            'manufacturing_Year.required'   => 'Es obligatorio.',
            'mark.required'                 => 'Es obligatorio.',
            'chassis_number.required'       => 'Es obligatorio.',
            'model.required'                => 'Es obligatorio.',
            'number_seats.required'         => 'Es obligatorio.',
            'bodywork.required'             => 'Es obligatorio.',
            'load_capacity.required'        => 'Es obligatorio.',
                
        ];
    }

}