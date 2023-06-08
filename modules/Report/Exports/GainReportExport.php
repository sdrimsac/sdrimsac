<?php

namespace Modules\Report\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GainReportExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function items($items)
    {
        $this->items = $items;
        return $this;
    }

    public function date_end($date_end)
    {
        $this->date_end = $date_end;

        return $this;
    }



    public function date_start($date_start)
    {
        $this->date_start = $date_start;

        return $this;
    }



    public function establishment($establishment)
    {
        $this->establishment = $establishment;

        return $this;
    }


    public function company($company)
    {
        $this->company = $company;

        return $this;
    }


    public function total($total)
    {
        $this->total = $total;

        return $this;
    }



    public function view(): View
    {
        return view('report::cash.report_excel_cash', [
            "establishment" => $this->establishment,
            "total" => $this->total,
            "company" => $this->company,
            "items" => $this->items,
            "date_start" => $this->date_start,
            "date_end" => $this->date_end,
        ]);
    }
}
