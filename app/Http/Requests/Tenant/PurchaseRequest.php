<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        
        $rules=[
            'supplier_id' => 'required',
            'date_of_issue' => 'required',
        ];
      /*  if ($this->input('document_type_id', 'GU75')) {
            $rules['series_guia'] = 'required';
            $rules['number_guia'] = 'required';
        }else{
            $rules['number'] = 'required';
            $rules['series'] = 'required';
        }*/
        return  $rules;
    }
}
