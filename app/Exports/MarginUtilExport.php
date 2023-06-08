<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

class MarginUtilExport implements  FromView, ShouldAutoSize
{
    use Exportable;
    
    public function result($result) {
        $this->result = $result;
        
        return $this;
    }
    
    public function month($month) {
        $this->month = $month;
        
        return $this;
    }
    
    public function d_month_start($d_month_start) {
        $this->d_month_start = $d_month_start;
        
        return $this;
    }
    public function d_month_end($d_month_end) {
        $this->d_month_end = $d_month_end;
        return $this;
    }
    public function typeresult($typeresult) {
        $this->typeresult = $typeresult;
        
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
    public function company($company) {
        $this->company = $company;
        
        return $this;
    }
    public function margin_document_total($margin_document_total) {
        $this->margin_document_total = $margin_document_total;
        return $this;
    }
    public function margin_sales_total($margin_sales_total) {
        $this->margin_sales_total = $margin_sales_total;
        
        return $this;
    }
    public function establishment($establishment) {
        $this->establishment = $establishment;
        
        return $this;
    }
    public function view(): View {
        return view('report::documents.margin_excel', [
            'result'=> $this->result,
            'month' => $this->month,
            'd_month_start'=>$this->d_month_start,
            'd_month_end'=>$this->d_month_end,
            'typeresult'=> $this->typeresult,
            'date_start' => $this->date_start,
            'date_end'=>$this->date_end,
            'company'=> $this->company,
            'margin_document_total' => $this->margin_document_total,
            'margin_sales_total'=>$this->margin_sales_total,
  
            'establishment'=>$this->establishment
        ]);
    }
}
