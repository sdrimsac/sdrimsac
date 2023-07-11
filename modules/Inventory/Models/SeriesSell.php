<?php

namespace Modules\Inventory\Models;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class SeriesSell implements FromView, ShouldAutoSize
{
    use Exportable;

    public function datosSeries($datosSeries)
    {
        $this->datosSeries = $datosSeries;
        return $this;
    }

    

   
    public function view(): View
    {
        
        return view('inventory::reports.SeriesVendidas.seriesvendidas', [
            
            "datosSeries" => $this->datosSeries,
            
            
        ]);
    }
}