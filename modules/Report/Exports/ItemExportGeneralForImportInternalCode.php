<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ItemExportGeneralForImportInternalCode implements  FromView, ShouldAutoSize
{
    use Exportable;
    protected $records;
    protected $company;
    protected $establishment;
    protected $warehouse_id;
    public function records($records) {
        $this->records = $records;
        
        return $this;
    }
    



    
    public function view(): View {
        return view('report::items.report_excel_general_for_import_internal_code', [
            'records'=> $this->records,
            'company' => $this->company,
            'establishment'=>$this->establishment,
            'warehouse_id'=>$this->warehouse_id
        ]);
    }
}
