<?php

namespace Modules\Restaurant\Http\Resources;

use App\Models\Tenant\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\Table;

class OrdenItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {
            $orden = Orden::find($row->orden_id);
            $mozo_name = DB::connection('tenant')->table('seller_mozo')->where('id', $orden->mozo_id)->value('name');
            $table = Table::find($orden->table_id);
            $zone_name = DB::connection('tenant')->table('zones')->where('id', $table->zone_id)->value('name');
            $user = User::find($row->user_id)->name;
            return [
                'orden'              => $orden,
                'table'              => $table,
                'zone_name'          => $zone_name,
                'to_carry'           => ($orden->to_carry== true || $orden->to_carry== 1) ? 'SI' : 'NO',
                'id'                 => $row->id,
                'observations'       => $row->observations,
                'date'              => $row->date,
                'imagen'            => $row->food->imagen,
                'time'              => $row->time,
                'quantity'          => $row->quantity,
                'price'             => $row->price,
                'food'              => $row->food,
                'status_orden_id'   => $row->status_orden_id,
                'user'              => $user,
                'name_product_pdf'  => $row->name_product_pdf,
                'mozo_name'         => $mozo_name,
            ];
        });
    }
}
