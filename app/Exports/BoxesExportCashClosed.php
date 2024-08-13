<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class BoxesExportCashClosed implements  FromView, ShouldAutoSize
{
    protected $boxes_report;
    protected $company;
    protected $establishment;
    protected $type_box;
    protected $date_end;
    protected $date_start;
    protected $user;
    use Exportable;

    public function boxes_report($boxes_report) {

        $this->boxes_report = $boxes_report;

        return $this;
    }
    public function date_start($date_start) {

        $this->date_start = $date_start;

        return $this;
    }
    
    public function date_end($date_end) {

        $this->date_end = $date_end;

        return $this;
    }
    
    public function establishment($establishment) {

        $this->establishment = $establishment;

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

  
    public function user($user) {
        $this->user = $user;
        return $this;
    }

    public function view(): View {
        return view('report::boxes.report_excel', [
            'boxes_report'=> $this->boxes_report,
            'company' => $this->company,
            'type_box'=>$this->type_box,
            'user' =>$this->user,
            'establishment' =>$this->establishment,
            'date_start' =>$this->date_start,
            'date_end' =>$this->date_end,
        ]);
    }
}
