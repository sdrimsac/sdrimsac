<?php
namespace App\Http\Requests\Tenant;
use Illuminate\Foundation\Http\FormRequest;
class ReceiptRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'date_of_issue'             =>  'required',     
               'establishment_id' =>  'required',    
               'customer_id'       =>  'required',
              // 'specialty_id'     =>  'required',
               'detail'           =>  'required'
          ];
         
    }
    public function messages()
    {
        return [
            'date_of_issue.required'               => 'Es obligatorio.', 
            'establishment_id.required'   => 'Es obligatorio.', 
            'patient_id.required'         => 'Es obligatorio.',
            'specialty_id.required'       => 'Es obligatorio.',
            'medic_id.required'           => 'Es obligatorio.',
            'detail.required'             => 'Es obligatorio.'
         ];
    }

}