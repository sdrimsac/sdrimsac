<?php
namespace App\Http\Requests\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BoxRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

public function rules(){
      {
          $id = $this->input('id');
          return [
            'group_id'                         =>  ['required'],
            'category_id'                      =>  ['required'],
            'subcategory_id'                   =>  ['required'],
            'amount'                           =>  ['required'],
            'date'                             =>  ['required'],
            'description'                      =>  ['required'],
            
          ];
      }
    }
    public function messages()
    {
        return [
            'group_id.required'                => 'Es obligatorio.',
            'category_id.required'             => 'Es obligatorio.',
            'subcategory_id.required'          => 'Es obligatorio.',
            'amount.required'                  => 'Es obligatorio.',
            'date.required'                    => 'Es obligatorio.',
            'description.required'             => 'Es obligatorio.',
                       
        ];
    }
}
