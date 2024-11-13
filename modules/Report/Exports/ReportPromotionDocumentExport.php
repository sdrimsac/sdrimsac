<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportPromotionDocumentExport implements FromView, ShouldAutoSize
{
    use Exportable;
    public $establishment;
    public $company;
    public $records;
    public $viewR = "report::promotions.report_excel";



    public function records($records)
    {
        $this->records = $records;

        return $this;
    }

    public function company($company)
    {
        $this->company = $company;

        return $this;
    }



    public function view(): View
    {

        return view($this->viewR, [
            'records' => $this->records,
            'company' => $this->company,
        ]);
    }
}
