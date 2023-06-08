<?php

namespace Modules\Internet\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RegisterExport implements FromView, ShouldAutoSize
{
    use Exportable;
    protected $records;
    protected $company;
    protected $establishment;
    protected $category;

    public function records($records)
    {

        $this->records = $records;

        return $this;
    }
    public function category($category)
    {
        $this->category = $category;

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
        return view('internet::formats.report_excel', [
            'records' => $this->records,
            'category' => $this->category,
            'company' => $this->company,
            'establishment' => $this->establishment
        ]);
    }
}
