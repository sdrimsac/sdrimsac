<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseFacturarRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        
        $rules=[
            'id' => 'required',
            'document_type_id' => 'required',
            'series' => 'required',
            'number' => 'required',
        ];
        
        return  $rules;
    }
}
