<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Series;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EstablishmentCollection extends ResourceCollection
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
            $series = Series::where("establishment_id",$row->id) -> whereIn("document_type_id", ['01', '03', '80'])->get();
            $factura = null;
            $boleta = null;
            $nota_venta = null;
            foreach($series as $serie) {
                $nombre_serie= $serie->number;
                if (
                    $serie->document_type_id == "80"
                ){
                   $sale_note = SaleNote::where("series", $nombre_serie)->latest()->first();
                   if ($sale_note){
                    $number = $sale_note->number;
                    $nota_venta=$nombre_serie."-".$number;
                    
                   }
                }else{
                    $document = Document::where("series", $nombre_serie)->latest()->first();
                   if ($document){
                    $number = $document->number;
                    if ($serie->document_type_id == "01"){
                        $factura = $nombre_serie."-".$number;
                    }else{
                        $boleta=$nombre_serie."-".$number;

                    }
                    
                    
                   }
                }

            }
            return [
                'id' => $row->id,
                'code' => $row->code,
                'description' => $row->description,
                'boleta'=> $boleta,
                'factura'=> $factura,
                'nota_venta'=> $nota_venta
            ];
        });
    }
}