<?php
namespace App\Http\Requests\Tenant;
use Illuminate\Foundation\Http\FormRequest;

class ArqueoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
               'diez_moneda'             =>  'required',                 
               'veinte_moneda'           =>  'required',                 
               'cincuenta_moneda'        =>  'required',                
               'uno_moneda'              =>  'required',                   
               'dos_moneda'              =>  'required',                   
               'cinco_moneda'            =>  'required',                    
               'diez_billete'            =>  'required',                    
               'veinte_billete'          =>  'required',                    
               'cincuenta_billete'       =>  'required',                
               'cien_billete'            =>  'required',                 
               'docientos_billete'       =>  'required',     
               'fecha'                   =>  'required',              
               'total_sistema'           =>  'required',
               'total_moneda'            =>  'required',
        //       'total_billete'           =>  'required',
               'egresos'                 =>  'required',
               'efectivo_total'          =>  'required',
               'establishment_id'        =>  'required',
               'total'                   =>  'required',
        ];
         
    }
    public function messages()
    {
        return [
            'diez_moneda.required'        => 'Es obligatorio.',
            'veinte_moneda.required'      => 'Es obligatorio.',
            'cincuenta_moneda.required'   => 'Es obligatorio.',
            'uno_moneda.required'         => 'Es obligatorio.',
            'dos_moneda.required'         => 'Es obligatorio.',
            'cinco_moneda.required'       => 'Es obligatorio.',
            'diez_billete.required'       => 'Es obligatorio.',
            'veinte_billete.required'     => 'Es obligatorio.',
            'cincuenta_billete.required'  => 'Es obligatorio.',
            'cien_billete.required'       => 'Es obligatorio.',
            'docientos_billete.required'  => 'Es obligatorio.',
            'fecha.required'              => 'Es obligatorio.',
            'total_sistema.required'      => 'Es obligatorio.',
            'total_moneda.required'       => 'Es obligatorio.',
            'total_billete.required'      => 'Es obligatorio.',
            'egresos.required'            => 'Es obligatorio.',
            'fecha.required'              => 'Es obligatorio.',
            'efectivo_total.required'     => 'Es obligatorio.',
            'establishment_id.required'   => 'Es obligatorio.',
            'total.required'              => 'Es obligatorio.',               
        ];
    }

}