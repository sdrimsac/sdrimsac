<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class BoxesExportCashClosed implements  FromView, ShouldAutoSize
{
    protected $records;
    protected $company;
    protected $type_box;
    use Exportable;

    public function records($records) {

        $this->records = $records;

        return $this;
    }

    public function company($company) {
        $this->company = $company;

        return $this;
    }
    public function type_box($type_box) {
        $this->type_box = $type_box;
        return $this;
    }

  

    public function view(): View {
        return view('report::boxes.report_excel', [
            'records'=> $this->records,
            'company' => $this->company,
            'type_box'=>$this->type_box,

        ]);
    }
}
