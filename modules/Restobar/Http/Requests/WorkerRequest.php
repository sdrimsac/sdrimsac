<?php

namespace Modules\Restobar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class WorkerRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $rules = [
            'name' => [
                'required',
            ],
            //  'area_id' => ['required']
        ];
    
        if (request()->user()->type == 'seller') {
            $rules['worker_type_id'] = ['required'];
        }
    
        return $rules;
    }
}
