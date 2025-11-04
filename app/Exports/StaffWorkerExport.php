<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class StaffWorkerExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading, WithCustomStartCell, WithStyles
{
    use Exportable;
    protected $records;
    protected $person;
    protected $company;
    protected $establishment;
    protected $d_start;
    protected $d_end;

    public function records($records) {
        $this->records = $records;
        
        return $this;
    }
    
    public function company($company) {
        $this->company = $company;
        
        return $this;
    }

    public function person($person) {
        $this->person = $person;
        
        return $this;
    }

    public function establishment($establishment)
    {
        $this->establishment = $establishment;

        return $this;
    }

    public function dateRange($d_start, $d_end)
    {
        $this->d_start = $d_start;
        $this->d_end = $d_end;

        return $this;
    }
    
    public function collection()
    {
        // Espera que $this->records sea un array/colección con la estructura que indicaste
        // Cada registro tiene: person_name, date_daily, entrance, exit, horas_trabajadas, overtime, amount_extra, lack, date_end_daily, pairs
        $data = collect();

        foreach ($this->records as $record) {
            // Normalizar acceso tanto para arrays como para objetos
            $personName = isset($record->person_name) ? $record->person_name : ($record['person_name'] ?? '');
            $dateDaily = isset($record->date_daily) ? $record->date_daily : ($record['date_daily'] ?? '');
            $entrance = isset($record->entrance) ? $record->entrance : ($record['entrance'] ?? '');
            $exit = isset($record->exit) ? $record->exit : ($record['exit'] ?? '');
            $horas = isset($record->horas_trabajadas) ? $record->horas_trabajadas : ($record['horas_trabajadas'] ?? '');
            $overtime = isset($record->overtime) ? $record->overtime : ($record['overtime'] ?? '');
            $amountExtra = isset($record->amount_extra) ? $record->amount_extra : ($record['amount_extra'] ?? '');
            $lack = isset($record->lack) ? $record->lack : ($record['lack'] ?? '');
            $dateEnd = isset($record->date_end_daily) ? $record->date_end_daily : ($record['date_end_daily'] ?? '');

            // Pairs: concatenar entradas/salidas en una sola celda, p.ej. "18:40:09 - 03:02:22 (2025-10-01)"
            $pairsRaw = isset($record->pairs) ? $record->pairs : ($record['pairs'] ?? []);
            $pairsCollection = collect($pairsRaw)->map(function ($p) {
                $entr = isset($p->entrance) ? $p->entrance : ($p['entrance'] ?? '');
                $ext = isset($p->exit) ? $p->exit : ($p['exit'] ?? '');
                $date = isset($p->exit_date) ? $p->exit_date : ($p['exit_date'] ?? '');
                return trim("{$entr} - {$ext} ({$date})");
            })->filter()->values();

            $pairsString = $pairsCollection->isEmpty() ? '' : $pairsCollection->implode(' | ');

            $data->push([
                'person_name' => $personName,
                'date_daily' => $dateDaily,
                'entrance' => $entrance,
                'exit' => $exit,
                // Mantener valores numéricos como números para que Excel los trate correctamente
                'horas_trabajadas' => $horas !== '' ? round((float) $horas, 2) : null,
                'overtime' => $overtime !== '' ? round((float) $overtime, 2) : null,
                'amount_extra' => $amountExtra !== '' ? round((float) $amountExtra, 2) : null,
                'lack' => is_numeric($lack) ? (int) $lack : $lack,
                'date_end_daily' => $dateEnd,
                'pairs' => $pairsString,
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Fecha',
            'Entrada',
            'Salida',
            'Horas trabajadas',
            'Horas extras',
            'Importe extra',
            'Falta',
            'Fecha fin',
            'Pares (entradas - salidas)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Estilos para el título y la información de la empresa
        // Ajustado a 10 columnas (A..J)
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('F2:J2');
        $sheet->mergeCells('A3:E3');
        $sheet->mergeCells('F3:J3');

        // Información de la empresa y fechas
        $sheet->setCellValue('A1', 'Reporte de Personal');
        $sheet->setCellValue('A2', 'Empresa: ' . ($this->company->name ?? ''));
        $sheet->setCellValue('F2', 'Reporte desde ' . (isset($this->d_start) ? Carbon::parse($this->d_start)->format('d-m-Y') : '') .
                      ' hasta ' . (isset($this->d_end) ? Carbon::parse($this->d_end)->format('d-m-Y') : ''));
        $sheet->setCellValue('A3', 'Ruc: ' . ($this->company->number ?? ''));
        $sheet->setCellValue('F3', '');

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
