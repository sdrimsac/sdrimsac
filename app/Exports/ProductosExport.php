<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;

class ProductosExport implements FromView, ShouldAutoSize
{
    use Exportable;

    protected $records;
    protected $company;
    protected $establishment;
    //no hay constructor por eso lo que  pusiste no funciona


    //hay metodos que setean las propiedades
    public function records($records)
    {
        $this->records = $records;

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
        dump($this->records);
        return view('tenant.productos.report_excel', [
            'records' => $this->records,
            'company' => $this->company,
            'establishment' => $this->establishment,
        ]);
    }
}

