<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

class BoxesExport implements  FromView, ShouldAutoSize
{
    use Exportable;

    public function records($records) {

        $this->records = $records;

        return $this;
    }
    public function date_end($date_end) {
        $this->date_end = $date_end;

        return $this;
    }
    public function date_start($date_start) {
        $this->date_start = $date_start;

        return $this;
    }
    public function user($user) {
        $this->user = $user;

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
        return view('report::boxes.report_excel', [
            'boxes_report'=> $this->records,
            'company' => $this->company,
            'type_box'=> $this->type_box,
             'establishment'=>$this->establishment,
            'date_start'=> $this->date_start,
            'date_end'=> $this->date_end,
            'user'=> $this->user
        ]);
    }
}
