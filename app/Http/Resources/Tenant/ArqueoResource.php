<?php
namespace App\Http\Resources\Tenant;
use Illuminate\Http\Resources\Json\JsonResource;

class ArqueoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'establishment_id'  => $this->establishment_id,
            'diez_moneda'       => $this->diez_moneda,
            'veinte_moneda'     => $this->veinte_moneda,
            'cincuenta_moneda'  => $this->cincuenta_moneda,
            'uno_moneda'        => $this->uno_moneda,
            'dos_moneda'        => $this->dos_moneda,
            'cinco_moneda'      => $this->cinco_moneda,
            'diez_billete'      => $this->diez_billete,
            'veinte_billete'    => $this->veinte_billete,
            'cincuenta_billete' => $this->cincuenta_billete,
            'cien_billete'      => $this->cien_billete,
            'docientos_billete' => $this->docientos_billete,
            'fecha'             => $this->fecha->format('Y-m-d'),
            'total_sistema'     => $this->total_sistema,
            'total_moneda'      => $this->total_moneda,
            'total_billete'     => $this->total_billete,
            'total'             => $this->total,
            'egresos'           => $this->egresos,
            'efectivo_total'    => $this->efectivo_total,
            'efectivo_total'    => $this->efectivo_total,
            'transferir'        => $this->transferir,
            'transferir_a'      => $this->transferir_a,
        ];
    }
}