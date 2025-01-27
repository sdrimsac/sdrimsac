<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseShoppingExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading, WithCustomStartCell, WithStyles
{
    protected $records;
    protected $company;
    protected $establishment;
    protected $d_end;
    protected $d_start;

    public function __construct()
    {
        $this->records = collect();
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

    public function d_end($d_end) {
        $this->d_end = $d_end;
        return $this;
    }

    public function d_start($d_start) {
        $this->d_start = $d_start;
        return $this;
    }

    public function collection()
    {
        $data = collect();
        $total_quantity = 0;
        $total_amount = 0;
        
        foreach ($this->records as $record) {
            foreach ($record->items as $item) {
                $quantity = floatval($item->quantity);
                $total_quantity += $quantity;
                $total_amount += $item->total;
                
                $data->push([
                    'number' => $record->number,
                    'date_of_issue' => Carbon::parse($record->date_of_issue)->format('d/m/Y H:i:s'),
                    'establishment' => optional($record->establishment)->description,
                    'internal_id' => $item->item->internal_id,
                    'description' => $item->item->description,
                    'quantity' => number_format($quantity, 2),
                    'unit_price' => number_format($item->unit_price, 2),
                    'total' => number_format($item->total, 2),
                ]);
            }
        }

        // Add total row
        $data->push([
            'number' => '',
            'date_of_issue' => '',
            'establishment' => '',
            'internal_id' => '',
            'description' => 'TOTAL',
            'quantity' => number_format($total_quantity, 2),
            'unit_price' => '',
            'total' => number_format($total_amount, 2),
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            'Número',
            'Fecha emisión',
            'Establecimiento',
            'Código Interno',
            'Producto',
            'Cantidad',
            'Precio',
            'Total'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Previous styles remain the same
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('E2:J2');
        $sheet->mergeCells('A3:D3');
        $sheet->mergeCells('E3:H3');

        $sheet->setCellValue('A1', 'Reporte De Productos Productos Comprados');
        $sheet->setCellValue('A2', 'Empresa: ' . $this->company->name);
        $sheet->setCellValue('E2', 'Reporte desde ' . Carbon::parse($this->d_start)->format('d-m-Y') . 
                                  ' hasta ' . Carbon::parse($this->d_end)->format('d-m-Y'));
        $sheet->setCellValue('A3', 'Ruc: ' . $this->company->number);
        $sheet->setCellValue('E3', 'Establecimiento: ' . $this->establishment->address . ' - ' . 
                                   $this->establishment->department->description . ' - ' . 
                                   $this->establishment->district->description);

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Add style for the total row
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A'.$lastRow.':H'.$lastRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]
        ]);

        // Add borders to all cells
        $sheet->getStyle('A1:H'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        return [
            1 => ['font' => ['bold' => true], 
                 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']],
                 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
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

