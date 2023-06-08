<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Tenant\User;
class PerfilRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user= User::find($this->id);
        return [
            'name' => [
                'required'
            ],
            'email' => 'required|email|unique:users,email,'.$this->id,
            'number' => [
                'required'
            ],
            'address' => [
                'required'
            ],
            'telephone' => [
                'required'
            ],
            'password' => [
                'min:6',
                'required',
            ]
        ];
    }
    public function messages()
{
    return [
        'name.required' => 'Es obligatorio.',
        'email.required' =>'Es obligatorio.',
        'number.required' => 'Es obligatorio.',
        'address.required' => 'Es obligatorio.',
        'telephone.required' => 'Es obligatorio.',
        'password' => 'Es obligatorio.',
    ];
}
}