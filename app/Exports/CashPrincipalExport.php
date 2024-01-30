<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CashPrincipalExport implements  FromView, ShouldAutoSize
{
    use Exportable;

    protected $records;
    protected $company;
    public function records($records) {

        $this->records = $records;

        return $this;
    }

    public function company($company) {
        $this->company = $company;

        return $this;
    }
    public function type_box($type_box) {
        $this->type_box = $type_box;
        return $this;
    }


    public function view(): View {
        return view('tenant.cash.report_excel_principal', [
            'records'=> $this->records,
            'company' => $this->company,

        ]);
    }
}
