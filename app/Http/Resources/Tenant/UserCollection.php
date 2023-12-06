<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {

            $type = '';
            switch ($row->type) {
                case 'admin':
                    $type =  'Administrador' ;
                    break;
                case 'seller':
                    $type =  'Vendedor' ;
                        break;
                case 'client':
                    $type =  'Cliente' ;
                    break;
                case 'drivers':
                    $type =  'Conductor' ;
                    break;
                default:
                    # code...
                    break;
            }

            return [
                'id' => $row->id,
                'email' => $row->email,
                'name' => $row->name,
                'pin' => $row->pin,
                'api_token' => $row->api_token,
                'establishment_id' => $row->establishment_id,
                'establishment_description' => optional($row->establishment)->description,
                'type' =>$type,
                'area' => optional($row->area)->description,
                'license' => $row->license,
                'category' => $row->category,
                'locked' => (bool) $row->locked,
                'active' => (bool) $row->active,
                'establishment_table_id' => $row->establishment_table_id,
                'warehouse_product_id' => $row->warehouse_product_id,
            ];
        });
    }
}
