<?php

namespace App\Exports;

use App\Models\Tenant\SaleNote;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

class SaleNoteCreditCashExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    protected $records;
    protected $company;
    public function __construct($records)
    {
        $this->records = $records;
    }

    public function company($company)
    {
        $this->company = $company;
        return $this;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $event->sheet->mergeCells('A1:E1');
                $event->sheet->mergeCells('A2:E2');
                $event->sheet->mergeCells('A3:E3');
                
                $current_date = now()->format('Y-m-d');
                $event->sheet->setCellValue('A1', $this->company->trade_name);
                $event->sheet->setCellValue('A2', 'CRÉDITOS PENDIENTES');
                $event->sheet->setCellValue('A3', 'Fecha: ' . $current_date);
                
                // Estilo para el encabezado
                $event->sheet->getStyle('A1:E3')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center']
                ]);
                
                // Agregar espacio entre el header y los datos
                $event->sheet->insertNewRowBefore(4, 2);
            },
            AfterSheet::class => function(AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $totalRemain = $this->records->sum(function($record) {
                    return $record->total - $record->boxes->sum('amount');
                });
                
                // Agregar el total
                $event->sheet->setCellValue('A' . ($lastRow + 2), 'TOTAL SALDO:');
                $event->sheet->setCellValue('E' . ($lastRow + 2), number_format($totalRemain, 2));
                
                // Estilo para el total
                $event->sheet->getStyle('A'.($lastRow + 2).':E'.($lastRow + 2))->applyFromArray([
                    'font' => ['bold' => true]
                ]);
            }
        ];
    }

    public function collection()
    {
        return $this->records->map(function($record) {
            $payed = $record->boxes->sum('amount');
            $total = $record->total;
            $remain = $total - $payed;
            return [
                'Fecha' => $record->date_of_issue->format('Y-m-d'),
                'Cliente' => $record->customer->name,
                'Documento' => $record->series."-".$record->number,
                'Monto' => number_format($record->total, 2),
                'Saldo' => number_format($remain, 2)
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Cliente', 
            'Documento',
            'Monto',
            'Saldo'
        ];
    }


} 