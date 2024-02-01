<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GlobalBoxExport implements  FromView, ShouldAutoSize
{
    use Exportable;
    protected $records;
    protected $columns;
    protected $company;

    public function records($records) {
        $this->records = $records;
        
        return $this;
    }
    public function columns($columns) {
        $this->columns = $columns;
        
        return $this;
    }
    public function company($company) {
        $this->company = $company;
        
        return $this;
    }


    
    /*public function establishment($establishment) {
        $this->establishment = $establishment;
        
        return $this;
    }*/
    
    public function view(): View {
        return view('tenant.reports.box_global.report_excel', [
            'records'=> $this->records,
            'company' => $this->company,
            'columns' => $this->columns,
            //'establishment'=>$this->establishment
        ]);
    }
}
