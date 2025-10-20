<?php

namespace Modules\Restaurant\Exports;

use App\Models\Tenant\Company;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HotelRentReportExport implements  FromView, ShouldAutoSize
{
    use Exportable;
    protected $records;
    protected $filter_type;
    protected $date_start;
    protected $date_end;
    public function records($records) {
        $this->records = $records;
        
        return $this;
    }

    public function filter_type($value) {
        $this->filter_type = $value;
        return $this;
    }

    public function date_start($value) {
        $this->date_start = $value;
        return $this;
    }

    public function date_end($value) {
        $this->date_end = $value;
        return $this;
    }


    public function view(): View {
        $company = Company::active();
        return view('restaurant::report.template_export', [
            'records'=> $this->records,
            'date_start'=> $this->date_start,
            'date_end'=> $this->date_end,
            'filter_type'=> $this->filter_type,
            'company' => $company

        ]);
    }


}
