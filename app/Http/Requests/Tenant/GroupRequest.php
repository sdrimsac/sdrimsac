<?php
namespace App\Http\Requests\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

public function rules(){
      {
          $id = $this->input('id');
          return [
            'group'                         =>  ['required'],
            
          ];
      }
    }
    public function messages()
    {
        return [
            'group.required'                => 'Es obligatorio.',
                       
        ];
    }
}
