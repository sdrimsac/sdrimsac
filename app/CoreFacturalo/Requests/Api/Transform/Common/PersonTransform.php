<?php

namespace App\CoreFacturalo\Requests\Api\Transform\Common;

use App\CoreFacturalo\Requests\Api\Transform\Functions;

class PersonTransform
{
    public static function transform($inputs)
    {
        return [
            'identity_document_type_id' => $inputs['codigo_tipo_documento_identidad'],
            'number' => $inputs['numero_documento'],
            'name' => $inputs['apellidos_y_nombres_o_razon_social'],
            'trade_name' => Functions::valueKeyInArray($inputs, 'nombre_comercial'),
            'country_id' => Functions::valueKeyInArray($inputs, 'codigo_pais'),
            'district_id' => Functions::valueKeyInArray($inputs, 'ubigeo'),
            'address' => Functions::valueKeyInArray($inputs, 'direccion'),
            'email' => Functions::valueKeyInArray($inputs, 'correo_electronico'),
            'telephone' => Functions::valueKeyInArray($inputs, 'telefono'),
        ];
    }

    public static function transformSalud($inputs)
    {
        $identity_document_type_id =  $inputs['tipoDocReceptor'];
        $number = $inputs['numDocReceptor'];
        if($identity_document_type_id == "_"){
            $number = "00000000";
            $identity_document_type_id = "1";
        }
        return [
            'identity_document_type_id' => $identity_document_type_id,
            'number' => $number,
            'name' => $inputs['nombreReceptor'],
            'trade_name' => null,
            'country_id' => "PE",
            'district_id' => Functions::valueKeyInArray($inputs, 'direccionUbigeo'),
            'address' => Functions::valueKeyInArray($inputs, 'direccionOrigen'),
            'email' => null,
            'telephone' => null,
        ];
    }
}