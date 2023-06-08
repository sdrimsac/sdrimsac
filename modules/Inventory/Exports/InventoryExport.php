<?php

namespace Modules\Inventory\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InventoryExport implements  FromView, ShouldAutoSize
{
    use Exportable;
    
    public function records($records) {
        $this->records = $records;
        return $this;
    }
    public function warehouse_id($warehouse_id) {
        $this->warehouse_id = $warehouse_id;
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
    public function typeresult($typeresult) {
        $this->typeresult = $typeresult;
        
        return $this;
    }
    
    public function view(): View {
     
        return view('inventory::reports.inventory.report_excel', [
            'records'=> $this->records,
            'company' => $this->company,
            'establishment'=>$this->establishment,
            'typeresult'=>$this->typeresult,
            'warehouse_id'=>$this->warehouse_id
        ]);
    }
}
