<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportConsignmentExport implements FromView, ShouldAutoSize
{
    use Exportable;
    public $establishment;
    public $company;
    public $records;



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


    public function establishment($establishment)
    {
        $this->establishment = $establishment;

        return $this;
    }

    public function view(): View
    {

        return view('report::consignment.report_excel', [
            'records' => $this->records,
            'company' => $this->company,
            'establishment' => $this->establishment
        ]);
    }
}
