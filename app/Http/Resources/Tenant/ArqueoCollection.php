<?php
namespace App\Http\Resources\Tenant;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArqueoCollection extends ResourceCollection
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
            //   $link_labor=Linklabor_ugel::where('user_id',$row->id)->get();
               return [
                   'id'                    => $row->id,
                   'diez_moneda'           => $row->diez_moneda,
                   'veinte_moneda'         => $row->veinte_moneda,
                   'cincuenta_moneda'      => $row->cincuenta_moneda,
                   'uno_moneda'            => $row->uno_moneda,
                   'dos_moneda'            => $row->dos_moneda,
                   'cinco_moneda'          => $row->cinco_moneda,
                   'diez_billete'          => $row->diez_billete,
                   'veinte_billete'        => $row->veinte_billete,
                   'cincuenta_billete'     => $row->cincuenta_billete,
                   'cien_billete'          => $row->cien_billete,
                   'docientos_billete'     => $row->docientos_billete,
                   'fecha'                 => optional($row->fecha)->format('d-m-Y'),
                   'total_sistema'         => $row->total_sistema,
                   'total_moneda'          => $row->total_moneda,
                   'total_billete'         => $row->total_billete,
                   'egresos'               => $row->egresos,
                   'efectivo_total'        => $row->efectivo_total,
                   'establishment_id'      => $row->establishment_id,
                   'total'                 => $row->total,
                   'transferir'            => $row->transferir,
                   'transferir_a'          => $row->transferir_a,
                  'state'                  => $row->state,
               ];
           });
    }
}