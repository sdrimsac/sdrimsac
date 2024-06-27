<?php

namespace App\Http\Requests\Tenant;

use App\Models\Tenant\Configuration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        $barcodeRules = ["nullable" ];
        $configuration = Configuration::first();
        $health_network = (bool) $configuration->health_network;
        if(!$health_network){
            $barcodeRules = ["nullable", Rule::unique('tenant.items')->ignore($id)];
        }
        return [
            'internal_id' => [
                'nullable',
                Rule::unique('tenant.items')->ignore($id),
            ],
            'barcode' => $barcodeRules,
            // 'barcode' => [
            //     'nullable',
            //     Rule::unique('tenant.items')->ignore($id),
            // ],
            'description' => [
                'required',
            ],

            'unit_type_id' => [
                'required',
            ],
            'currency_type_id' => [
                'required'
            ],
            'sale_unit_price' => [
                'required',
                'numeric',
                'gt:0'
            ],
            'purchase_unit_price' => [
                'required', 'numeric'
            ],
            'stock' => [
                'required',
            ],
            'stock_min' => [
                'required',
            ],
            'sale_affectation_igv_type_id' => [
                'required'
            ],
            'purchase_affectation_igv_type_id' => [
                'required'
            ],
    

        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'El campo nombre es obligatorio.',
            'sale_unit_price.gt' => 'El precio unitario de venta debe ser mayor que 0.',
        ];
    }
}
