<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

class BoxesResumenExportPos implements FromView, ShouldAutoSize
{
    use Exportable;

    public function records($records)
    {

        $this->records = $records;

        return $this;
    }
    public function records2($records2)
    {

        $this->records2 = $records2;

        return $this;
    }
    public function user($user)
    {

        $this->user = $user;

        return $this;
    }
    public function records3($records3)
    {

        $this->records3 = $records3;

        return $this;
    }
    public function records4($records4)
    {

        $this->records4 = $records4;

        return $this;
    }

    public function company($company)
    {
        $this->company = $company;

        return $this;
    }

    public function establishment($establishment)
    {
        $this->establishment = $establishment;

        return $this;
    }

    public function view(): View
    {
        return view('report::boxes.report_resumen_excel_pos', [
            'records' => $this->records,
            'records2' => $this->records2,
            'records3' => $this->records3,
            'records4' => $this->records4,
            'user' => $this->user,
            'company' => $this->company,
            'establishment' => $this->establishment
        ]);
    }
}
