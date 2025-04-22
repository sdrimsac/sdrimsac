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

class GananciaReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading, WithCustomStartCell, WithStyles, WithEvents
{
    use Exportable;

    protected $sales_data;
    protected $company;
    protected $establishment;
    protected $date_start;
    protected $date_end;
    protected $is_service;
    protected $total;
    protected $document_type;
    protected $total_utility;
    protected $total_net_utility;
    protected $dateStart;


    public function totalUtility($total_utility)
    {
        $this->total_utility = $total_utility;
        return $this;
    }

    public function totalNetUtility($total_net_utility)
    {
        $this->total_net_utility = $total_net_utility;
        return $this;
    }
    public function dateStart($date_start)
    {
        $this->$date_start = $date_start;
        return $this;
    }

    public function dateEnd($date_end)
    {
        $this->$date_end = $date_end;
        return $this;
    }

    public function salesData($sales_data)
    {
        $this->sales_data = $sales_data;
        return $this;
    }

    public function isService($is_service)
    {
        $this->is_service = $is_service;
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

    public function collection()
    {
        $export = collect();

        $this->total = 0;
        $this->total_utility = 0;
        $this->total_net_utility = 0;

        foreach ($this->sales_data as $record) {
            foreach ($record['items'] as $item) {

                $total_sale = (float)($item['total_sale'] ?? 0);
                $utility = (float)($item['utility'] ?? 0);
                $net_utility = (float)($item['net_utility'] ?? 0);

                $this->total += $total_sale;
                $this->total_utility += $utility;
                $this->total_net_utility += $net_utility;

                $export->push([
                    'document_type' => $record['document_type'] ?? '',
                    'series_number' => $record['series_number'] ?? '',
                    'description' => $item['description'] ?? '',
                    'quantity' => $item['quantity'] ?? 0,
                    'unit_type' => $item['unit_type'] ?? '',
                    'purchase_unit_price' => $item['purchase_unit_price'] ?? 0,
                    'total_purchase' => $item['total_purchase'] ?? 0,
                    'unit_price' => $item['unit_price'] ?? 0,
                    'total_sale' => $item['total_sale'] ?? 0,
                    'utility' => $item['utility'] ?? 0,
                    'net_utility' =>$item['net_utility'] ?? 0,
                ]);
            }
        }

        return $export;
    }

    public function headings(): array
    {
        return [
            'Tipo de Documento',
            'Serie y Número',
            'Producto',
            'Cantidad',
            'Unidad de Medida',
            'Precio de Compra',
            'Total Compra',
            'Precio de Venta',
            'Total Venta',
            'Utilidad Bruta',
            'Utilidad Neta'
        ];
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('E2:J2');
        $sheet->mergeCells('A3:E3');
        $sheet->mergeCells('F3:J3');

        $sheet->setCellValue('A1', 'Reporte De Ganacias');
        $sheet->setCellValue('A2', 'Empresa: ' . $this->company->name);
        $sheet->setCellValue('E2', 'Reporte desde ' . Carbon::parse($this->date_start)->format('d-m-Y') .
            ' hasta ' . Carbon::parse($this->date_end)->format('d-m-Y'));
        $sheet->setCellValue('A3', 'Ruc: ' . $this->company->number);
        $sheet->setCellValue('F3', 'Establecimiento: ' . $this->establishment->address . ' - ' .
            $this->establishment->department->description . ' - ' .
            $this->establishment->district->description);

        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            2 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            3 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            4 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $lastRow = max(5, $sheet->getHighestRow());
                $totalRow = $lastRow + 1;

                $sheet->mergeCells("A{$totalRow}:H{$totalRow}");
                $sheet->setCellValue("A{$totalRow}", 'TOTALES');
                $sheet->setCellValue("I{$totalRow}", number_format((float)($this->total ?? 0), 2));
                $sheet->setCellValue("J{$totalRow}", number_format((float)($this->total_utility ?? 0), 2));
                $sheet->setCellValue("K{$totalRow}", number_format((float)($this->total_net_utility ?? 0), 2));

                $sheet->getStyle("A{$totalRow}:K{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']],
                    'alignment' => ['horizontal' => 'right']
                ]);
            },
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
