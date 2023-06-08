<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

class DocumentExport implements  FromView, ShouldAutoSize
{
    use Exportable;
    //->date_start($date_start)
   // ->date_end($date_end)
    public function sales_records($sales_records) {
        $this->sales_records = $sales_records;
        
        return $this;
    }
    public function record_documents($record_documents) {
        $this->record_documents = $record_documents;
        
        return $this;
    }
    
    public function records($records) {
        $this->records = $records;
        
        return $this;
    }
    public function status($status) {
        $this->status = $status;
        
        return $this;
    }
    public function company($company) {
        $this->company = $company;
        
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
    
    public function view(): View {
        
        return view('report::documents.report_excel', [
            'record_documents'=> $this->record_documents,
            'sales_records'=> $this->sales_records,
            'records'=> $this->records,
            'company' => $this->company,
            'status' => $this->status,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'establishment'=>$this->establishment
        ]);
    }
}
