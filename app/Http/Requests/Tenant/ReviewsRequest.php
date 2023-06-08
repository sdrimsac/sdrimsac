<?php
namespace App\Http\Requests\Tenant;
use Illuminate\Foundation\Http\FormRequest;
class ReviewsRequest extends FormRequest

{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'date_latest_reviews'   =>  'required',                 
               'date_next_reviews'     =>  'required',                 
               'description'           =>  'required',  
               'vehicle_id'            =>  'required',              
             
        ];
         
    }
    public function messages()
    {
        return [
            'date_latest_reviews.required'   => 'Es obligatorio.',
            'date_next_reviews.required'     => 'Es obligatorio.',
            'description.required'           => 'Es obligatorio.',
            'vehicle_id.required'            => 'Es obligatorio.',
          
                
        ];
    }
    

}