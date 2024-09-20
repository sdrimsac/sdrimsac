<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\Documents;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

class ConsolidatedExport implements  FromView, ShouldAutoSize
{
    use Exportable;
    protected $records;
    protected $company;
    protected $consolidated;
    public function records($records) {
        $this->records = $records;
        
        return $this;
    }

    public function company($value) {
        $this->company = $value;
        return $this;
    }

    public function consolidated($value) {
        $this->consolidated = $value;
        return $this;
    }

    public function view(): View {
        return view('tenant.consolidated.report_excel', [
            'records'=> $this->records,
            'company'=> $this->company,
            'consolidated'=> $this->consolidated,

        ]);
    }


}
