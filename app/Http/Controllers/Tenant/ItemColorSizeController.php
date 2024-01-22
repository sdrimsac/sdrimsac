<?php

namespace App\Http\Controllers\Tenant;


use App\Http\Controllers\Controller;


class ItemColorSizeController extends Controller
{
    public function index()
    {
        return view('tenant.item_color_sizes.index');
    }


    public function columns()
    {
        return [
            'description' => 'Nombre',
            'internal_id' => 'Código interno',
        ];
    }

   
}
