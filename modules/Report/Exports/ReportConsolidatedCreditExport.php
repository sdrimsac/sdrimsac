<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportConsolidatedCreditExport implements FromView, ShouldAutoSize
{
    use Exportable;
    public $establishment;
    public $company;
    public $data;
    public $viewR = "report::credits.report_excel_consolidated";



    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    public function company($company)
    {
        $this->company = $company;

        return $this;
    }


    public function establishment($establishment)
    {
        $this->establishment = $establishment;

        return $this;
    }

    public function view(): View
    {

        return view($this->viewR, [
            'data' => $this->data,
            'company' => $this->company,
            'establishment' => $this->establishment
        ]);
    }
}
