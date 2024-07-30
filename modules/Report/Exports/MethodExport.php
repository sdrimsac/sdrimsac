<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

class MethodExport implements  FromView, ShouldAutoSize
{
    use Exportable;
    public function dateStart($dateStart) {

        $this->dateStart = $dateStart;

        return $this;
    }
    
    public function dateEnd($dateEnd) {

        $this->dateEnd = $dateEnd;

        return $this;
    }
    public function records($records) {

        $this->records = $records;

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

    public function view(): View {
        return view('report::methods.excel', [
            'records'=> $this->records,
            'company' => $this->company,
             'establishment'=>$this->establishment,
            'dateStart' => $this->dateStart,
            'dateEnd' => $this->dateEnd
        ]);
    }
}
