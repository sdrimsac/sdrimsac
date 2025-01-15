<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HealthGlobalExport implements  FromView, ShouldAutoSize
{
    use Exportable;
    protected $records;
    protected $month;
    protected $year;
    protected $company;
    public function records($records) {
        $this->records = $records;
        
        return $this;
    } 
    public function company($company) {
        $this->company = $company;
        
        return $this;
    }
    
    public function month($month) {
        $this->month = $month;
        
        return $this;
    }
    public function year ($year) {
        $this->year = $year;
        
        return $this;
    }
    
    public function view(): View {
        return view('tenant.health_global.report_excel', [
            'records'=> $this->records,
            'company' => $this->company,
            'month' => $this->month,
            'year' => $this->year
        ]);
    }
}
