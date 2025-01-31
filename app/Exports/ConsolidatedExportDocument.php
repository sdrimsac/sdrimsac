<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ConsolidatedExportDocument implements FromView, ShouldAutoSize
{
    use Exportable;
    protected $records;
    protected $company;
    protected $detail = false;
    protected $consolidated_info = [];
    public function records($records)
    {
        $this->records = $records;

        return $this;
    }

    public function consolidatedInfo($consolidated_info)
    {
        $this->consolidated_info = $consolidated_info;
        return $this;
    }

    public function detail($value)
    {
        $this->detail = $value;
        return $this;
    }



    public function company($value)
    {
        $this->company = $value;
        return $this;
    }


    public function view(): View
    {

        $view = 'tenant.consolidated.report_excel_documents';
        if ($this->detail) {
            $view = 'tenant.consolidated.report_excel_documents_detail';
        }

        return view($view, [
            'records' => $this->records,
            'company' => $this->company,
            'consolidated_info' => $this->consolidated_info
        ]);
    }
}
