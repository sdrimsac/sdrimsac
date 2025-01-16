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
    protected $is_year;
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
    public function isYear ($is_year) {
        $this->is_year = $is_year;
        return $this;
    }
    
    public function view(): View {
        $view  = $this->is_year ? 'tenant.health_global.report_year_excel':'tenant.health_global.report_excel';
        return view($view, [
            'records'=> $this->records,
            'company' => $this->company,
            'month' => $this->month,
            'year' => $this->year
        ]);
    }
}
