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

class DocumentVenta implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading, WithCustomStartCell, WithStyles
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
        
        foreach ($this->records as $record) {
            foreach ($record->items as $item) {
                $data->push([
                    'number_full' => $record->number_full,
                    'date_of_issue' => $record->date_of_issue,
                    'establishment' => optional($record->establishment)->description,
                    'customer_name' => $record->customer->name,
                    'customer_number' => $record->customer->number,
                    'internal_id' => $item->item->internal_id,
                    'description' => $item->item->description,
                    'quantity' => number_format($item->quantity, 2),
                    'unit_value' => number_format($item->unit_value, 2),
                    'total' => number_format($item->total, 2),
                ]);
            }
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Número',
            'Fecha emisión',
            'Establecimiento',
            'Cliente',
            'Documento',
            'Código Interno',
            'Producto',
            'Cantidad',
            'Precio',
            'Total'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Estilos para el título y la información de la empresa
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('E2:J2');
        $sheet->mergeCells('A3:E3');
        $sheet->mergeCells('F3:J3');

        // Información de la empresa y fechas
        $sheet->setCellValue('A1', 'Reporte De Productos vendidos');
        $sheet->setCellValue('A2', 'Empresa: ' . $this->company->name);
        $sheet->setCellValue('E2', 'Reporte desde ' . Carbon::parse($this->d_start)->format('d-m-Y') . 
                                  ' hasta ' . Carbon::parse($this->d_end)->format('d-m-Y'));
        $sheet->setCellValue('A3', 'Ruc: ' . $this->company->number);
        $sheet->setCellValue('F3', 'Establecimiento: ' . $this->establishment->address . ' - ' . 
                                   $this->establishment->department->description . ' - ' . 
                                   $this->establishment->district->description);

        // Estilos generales
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
