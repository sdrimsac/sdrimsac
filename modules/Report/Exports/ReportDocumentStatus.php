<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportDocumentStatus implements FromView, ShouldAutoSize
{
    use Exportable;

    public function infoCompleta($infoCompleta)
    {
        $this->infoCompleta = $infoCompleta;
        return $this;
    }

    

   
    public function view(): View
    {
        return view('report::cash.repor_excel_DocStatus', [
            
            "infoCompleta" => $this->infoCompleta,
            
            
        ]);
    }
}
