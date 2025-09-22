<?php

namespace App\Exports;

use App\Models\Tenant\Catalogs\DetractionType;
use App\Models\Tenant\DetractionPayment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DocumentDetraccionExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading, WithCustomStartCell, WithStyles
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

    public function d_end($d_end)
    {
        $this->d_end = $d_end;
        return $this;
    }

    public function d_start($d_start)
    {
        $this->d_start = $d_start;
        return $this;
    }

    public function collection()
    {
        $data = collect();

        foreach ($this->records as $record) {
            $detraction = $record->detraction;
            $type = isset($detraction) ? $detraction->detraction_type_id : null;
            $percentage = isset($detraction) ? $detraction->percentage : null;
            $amount = isset($detraction) ? $detraction->amount : null;
            $detraction_type = $type ? DetractionType::find($type) : null;
            $detraction_description = $detraction_type ? $detraction_type->description : null;
            $sum_payments = DetractionPayment::where('document_id', $record->id)->sum('payment');
            $pending_payment = $amount !== null ? $amount - $sum_payments : null;

            $record->detraction_description = $detraction_description;
            $record->percentage = $percentage;
            $record->amount = $amount;
            $record->total = $sum_payments;
            $record->pending_payment = $pending_payment;
        }

        foreach ($this->records as $record) {
            $data->push([
                $record->number_full,
                $record->date_of_issue,
                $record->customer->name ?? null,
                $record->customer->number ?? null,
                $record->document_type_id ?? null,
                $record->currency_type_id ?? null,
                $record->detraction_description,
                $record->percentage !== null ? $record->percentage . '%' : null,
                $record->pending_payment ?? null,
                $record->amount,
                /* $record->total ?? null, */
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            /* 'Pendiente de Pago',
            'Pagado', */
            'Número Doc.',
            'Fecha de Emisión',
            'Cliente',
            'Nro Cliente',
            'Tipo Doc',
            'moneda',
            'Código dtracción',
            'Porcentaje detracción',
            'Total pagado',
            'Monto',
            /* 'total', */
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('E2:I2');
        $sheet->mergeCells('A3:E3');
        $sheet->mergeCells('F3:I3');

        $sheet->setCellValue('A1', 'Reporte de Detracciones');
        $sheet->setCellValue('A2', 'Empresa: ' . $this->company->name);
        $sheet->setCellValue('E2', 'Reporte desde ' . Carbon::parse($this->d_start)->format('d-m-Y') .
            ' hasta ' . Carbon::parse($this->d_end)->format('d-m-Y'));
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
