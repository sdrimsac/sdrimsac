<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportProductWarehouse implements  FromView, ShouldAutoSize
{
    use Exportable;
    protected $records;
    protected $establishment;
    protected $user;
    protected $company;
    protected $turn;

    public function records($records) {
        $this->records = $records;
        
        return $this;
    }
    
    public function company($company) {
        $this->company = $company;
        
        return $this;
    }

    public function user($user) {
        $this->user = $user;
        
        return $this;
    }

    public function turn($turn) {
        $this->turn = $turn;
        
        return $this;
    }

    public function establishment($establishment) {
        $this->establishment = $establishment;
        
        return $this;
    }
    
    /*public function establishment($establishment) {
        $this->establishment = $establishment;
        
        return $this;
    }*/
    
    public function view(): View {
        return view('tenant.reports.product_warehouse.report_excel', [
            'records'=> $this->records,
            'company' => $this->company,
            'user' => $this->user,
            'establishment'=>$this->establishment,
            'turn'=>$this->turn
        ]);
    }
}
