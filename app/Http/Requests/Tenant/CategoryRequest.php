<?php
namespace App\Http\Requests\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

public function rules(){
      {
          $id = $this->input('id');
          return [
            'category'                         =>  ['required'],
            
          ];
      }
    }
    public function messages()
    {
        return [
            'category.required'                => 'Es obligatorio.',
                       
        ];
    }
}
