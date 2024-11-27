<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HistorialCollection extends ResourceCollection
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
            return [
                'id' => $row->id,
                'vehiculo_id' => $row->vehiculo_id,
                'vehiculo_placa' => optional($row->vehiculo)->placa ?? '-',
                'vehiculo_marca' => optional($row->vehiculo)->marca ?? '-',
                'personal_id' => $row->personal_id,
                'personal_name' => optional($row->personal)->name ?? '-',
                'observacion' => $row->observacion,
                'motive' => $row->motive,
                'sale_note_id' => $row->sale_note_id,
                'document_id' => $row->document_id,
                'establishment_id' => $row->establishment_id,
                'establishment_description' => optional($row->establishment)->description ?? '-',
                'reparacion' => $row->reparacion,
                'garantia' => $row->garantia,
                'mantenimiento' => $row->mantenimiento,
                'diagnostico' => $row->diagnostico,
                'estado' => $row->estado,
                'created_at' => $row->created_at->format('d-m-Y H:i'),
                'updated_at' => $row->updated_at,
                'item' => $row->historialItem->transform(function ($historial_item) {
                    $description = $historial_item->item->description;
                    return [
                        'id' => $historial_item->id,
                        'historial_id' => $historial_item->historial_id,
                        'item_id' => $historial_item->item_id,
                        'cantidad' => $historial_item->cantidad,
                        'price' => $historial_item->price,
                        'description' => $description
                    ];
                })
            ];
        });
    }
}
