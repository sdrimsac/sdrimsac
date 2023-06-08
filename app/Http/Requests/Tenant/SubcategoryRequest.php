<?php
namespace App\Http\Requests\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubcategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

public function rules(){
      {
          $id = $this->input('id');
          return [
            'subcategory'                         =>  ['required'],
          ];
      }
    }
    public function messages()
    {
        return [
            'subcategory.required'                => 'Es obligatorio.',
                       
        ];
    }
}
