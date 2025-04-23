<?php

namespace Modules\Report\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class ComisionReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading, WithCustomStartCell, WithStyles
{
    use Exportable;


    protected $company;
    protected $establishment;
    protected $date_start;
    protected $date_end;
    protected $records;
    protected $date;
    protected $food_id;


    protected $dateStart;

    public function date($date)
    {
        $this->date = $date;
        return $this;
    }

    public function food_id($food_id)
    {
        $this->food_id = $food_id;
        return $this;
    }

    /* public function dateStart($date_start)
    {
        $this->$date_start = $date_start;
        return $this;
    }

    public function dateEnd($date_end)
    {
        $this->$date_end = $date_end;
        return $this;
    } */

    public function records($records)
    {
        $this->records = $records;
        return $this;
    }

    public function date_end($date_end)
    {
        $this->date_end = $date_end;
        dump($this->date_end);

        return $this;
    }

    public function date_start($date_start)
    {
        $this->date_start = $date_start;
        dump($this->date_start);

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

    public function collection()
    {
        $export = collect();

        foreach ($this->records as $record) {
            $export->push([
                'description' => $record->description,
                'quantity' => (float)$record->quantity,
                'price' => (float)$record->price,
                'total' => (float)$record->total,
                'commission' => (float)$record->commission,
                'commission_total' => (float)$record->commission_total,
            ]);
        }

        return $export;
    }

    public function headings(): array
    {
        return [
            'Descripcion',
            'Cantidad',
            'Precio',
            'Total',
            'Comision',
            'Comision Total',
        ];
    }


    /* public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:C2');
        $sheet->mergeCells('D2:J2');
        $sheet->mergeCells('A3:B3');
        $sheet->mergeCells('C3:J3');

        $sheet->setCellValue('A1', 'Reporte De Productos Con Comision');
        $sheet->setCellValue('A2', 'Empresa: ' . $this->company->name);
        $sheet->setCellValue('E2', 'Reporte desde ' . Carbon::parse($this->date_start)->format('d-m-Y') .
            ' hasta ' . Carbon::parse($this->date_end)->format('d-m-Y'));
        $sheet->setCellValue('A3', 'Ruc: ' . $this->company->number);
        $sheet->setCellValue('C3', 'Establecimiento: ' . $this->establishment->address . ' - ' .
            $this->establishment->department->description . ' - ' .
            $this->establishment->district->description);

        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            2 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            3 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            4 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]]
        ];
    } */

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:C2');
        $sheet->mergeCells('D2:J2'); // Rango combinado
        $sheet->mergeCells('A3:B3');
        $sheet->mergeCells('C3:J3');

        $sheet->setCellValue('A1', 'Reporte De Productos Con Comision');
        $sheet->setCellValue('A2', 'Empresa: ' . $this->company->name);
        $sheet->setCellValue('D2', 'Reporte desde ' . Carbon::parse($this->date_start)->format('d-m-Y') .
            ' hasta ' . Carbon::parse($this->date_end)->format('d-m-Y')); // Cambiado a D2
        $sheet->setCellValue('A3', 'Ruc: ' . $this->company->number);
        $sheet->setCellValue('C3', 'Establecimiento: ' . $this->establishment->address . ' - ' .
            $this->establishment->department->description . ' - ' .
            $this->establishment->district->description);

        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            2 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            3 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            4 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]]
        ];
    }


    public function startCell(): string
    {
        return 'A4';
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function download($filename)
    {
        return Excel::download($this, $filename);
    }
}
