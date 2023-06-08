<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

class BoxesExportBancarioPos implements  FromView, ShouldAutoSize
{
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

    public function establishment($establishment) {
        $this->establishment = $establishment;

        return $this;
    }

    public function view(): View {
        return view('report::boxes.report_excel_bancario_pos', [
            'records'=> $this->records,
            'company' => $this->company,
            'type_box'=>$this->type_box,

        ]);
    }
}
