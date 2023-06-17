<?php

namespace Modules\Item\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {

            return [
                'id' => $row->id,
                'name' => $row->name,
                'drag' =>(bool) $row->pos_drag,
                // $directory = 'public'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'category'.DIRECTORY_SEPARATOR;
                'icono' => ($row->icono !== 'imagen-no-disponible.jpg') ? asset('storage/uploads/category/'.$row->icono) : asset("/logo/{$row->icono}"),
                'created_at' => Carbon::parse($row->created_at)->format('Y-m-d'),
                'updated_at' => $row->updated_at,
                'user_name' => $row->user ? $row->user->name : '',
            ];
        });

    }
    
}
