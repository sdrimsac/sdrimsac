<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StockMinExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function ordenesCompra($ordenesCompra)
    {
        $this->ordenesCompra = $ordenesCompra;
        return $this;
    }

    public function numOrdengen($numOrdengen)
    {
        $this->numOrdengen = $numOrdengen;

        return $this;
    }

    public function company($company)
    {
        $this->company = $company;

        return $this;
    }
    public function sumOrden($sumOrden){
        $this->sumOreden = $sumOrden;
        return $this;
    }

   
    public function view(): View
    {
        return view('report::cash.repor_excel_stockMin', [
            "numOrdengen" => $this->numOrdengen,
            "company" => $this->company,
            "ordenesCompra" => $this->ordenesCompra,
            "sumOrden" => $this->sumOreden,
            
        ]);
    }
}
