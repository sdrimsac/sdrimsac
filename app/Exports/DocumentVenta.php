<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DocumentVenta implements  FromView, ShouldAutoSize
{
    use Exportable;
    protected $records;
    protected $columns;
    protected $company;
    protected $establishment;
    protected $d_end;
    protected $d_start;
    

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

    public function establishment($establishment) {
        $this->establishment = $establishment;
        
        return $this;
    }
    public function d_end($d_end) {
        $this->d_end = $d_end;
        
        return $this;
    }
    public function d_start($d_start) {
        $this->d_start = $d_start;
        
        return $this;
    }
    
    public function view(): View {
        return view('tenant.reports.ventas.report_excel', [
            'records'=> $this->records,
            'company' => $this->company,
            'columns' => $this->columns,
            'establishment'=>$this->establishment,
            'd_start'=>$this->d_start,
            'd_end' =>$this->d_end,
        ]);
    }
}
