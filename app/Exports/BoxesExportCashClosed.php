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

class BoxesExportCashClosed implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading, WithCustomStartCell, WithStyles
{
    protected $boxes_report;
    protected $company;
    protected $establishment;
    protected $type_box;
    protected $date_end;
    protected $date_start;
    protected $user;

    public function boxes_report($boxes_report) {

        $this->boxes_report = $boxes_report;

        return $this;
    }
    public function date_start($date_start) {

        $this->date_start = $date_start;

        return $this;
    }
    
    public function date_end($date_end) {

        $this->date_end = $date_end;

        return $this;
    }
    
    public function establishment($establishment) {

        $this->establishment = $establishment;

        return $this;
    }
    
    public function company($company) {
        $this->company = $company;

        return $this;
    }
    public function type_box($type_box) {
        $this->type_box = $type_box;
        return $this;
    }

  
    public function user($user) {
        $this->user = $user;
        return $this;
    }

    public function collection()
    {
        $rows = collect();

        $ingresos = 0.0;
        $egresos = 0.0;
        $depositos = 0.0;
        $transferencia = 0.0;

        $index = 0;
        foreach (collect($this->boxes_report ?? []) as $row) {
            $index++;

            $amount = (float) data_get($row, 'amount', 0);
            $payment_condition = '';
            $date = data_get($row, 'date');

            // Prefer embedded relations; fall back to DB only if needed
            $document = data_get($row, 'document');
            if (!$document && data_get($row, 'document_id')) {
                $document = \App\Models\Tenant\Document::find(data_get($row, 'document_id'));
            }
            if ($document) {
                $total = (float) data_get($document, 'total', $amount);
                $payment_condition = data_get($document, 'payment_condition_id') === '01' ? 'Contado' : 'Crédito';
                if ($total < $amount) {
                    $amount = $total;
                }
                $date = trim((string) data_get($document, 'date_of_issue')) . ' ' . trim((string) data_get($document, 'time_of_issue'));
            }

            $saleNote = data_get($row, 'salenote') ?? data_get($row, 'sale_note');
            if (!$saleNote && data_get($row, 'sale_note_id')) {
                $saleNote = \App\Models\Tenant\SaleNote::find(data_get($row, 'sale_note_id'));
            }
            if ($saleNote) {
                $payment_condition = ((int) data_get($saleNote, 'credit_cash') !== 1) ? 'Contado' : 'Crédito';
                $total = (float) data_get($saleNote, 'total', $amount);
                if ($total < $amount) {
                    $amount = $total;
                }
                $dateIssue = data_get($saleNote, 'date_of_issue');
                $timeIssue = data_get($saleNote, 'time_of_issue');
                if ($dateIssue instanceof \Carbon\Carbon) {
                    $dateIssue = $dateIssue->format('Y-m-d');
                }
                $date = trim((string) $dateIssue) . ' ' . trim((string) $timeIssue);
            }

            // Tally by type/method
            $type = (string) data_get($row, 'type');
            $method = (string) data_get($row, 'method');
            if ($type === '1') {
                if ($method === 'Efectivo') $ingresos += $amount;
                if ($method === 'Depositos') $depositos += $amount;
                if ($method === 'Transferencia') $transferencia += $amount;
            }
            if ($type === '2') {
                $egresos += $amount;
            }

            // Format date and append created_at time
            $dateStr = $date ? Carbon::parse($date)->format('d-m-Y') : '';
            $createdAt = data_get($row, 'created_at');
            if ($createdAt) {
                $dateStr .= ' ' . Carbon::parse($createdAt)->format('H:i:s');
            }

            // Establishment description (prefer embedded relation)
            $establishmentDescription = data_get($row, 'establishment.description');
            if (!$establishmentDescription) {
                $establishmentId = data_get($row, 'establishment_id');
                if ($establishmentId) {
                    $establishmentModel = \App\Models\Tenant\Establishment::find($establishmentId);
                    $establishmentDescription = $establishmentModel ? $establishmentModel->description : '';
                } else {
                    $establishmentDescription = '';
                }
            }

            // Columns according to Blade conditions
            $colOperacion = '';
            if ($type === '1' && $method) {
                $colOperacion = $method;
            } elseif ($type === '2' && $method === 'Efectivo') {
                $colOperacion = $method;
            }

            $colRef = data_get($row, 'cash.reference_number', data_get($row, 'reference', '-'));

            $colEstablecimiento = '';
            $colCliente = '';
            $colNumeroIdent = '';

            if ($type === '2' && $method === 'Efectivo') {
                $colEstablecimiento = (string) data_get($row, 'subcategories.subcategory', '-');
            } else {
                if ($type === '1' && !data_get($row, 'sale_note_id') && !data_get($row, 'document_id')) {
                    $colEstablecimiento = (string) data_get($row, 'subcategories.subcategory', '-');
                } else {
                    $colEstablecimiento = $establishmentDescription;
                    if (data_get($row, 'sale_note_id') && !data_get($row, 'document_id')) {
                        // Prefer loaded sale note variable if available
                        $colCliente = (string) data_get($saleNote, 'customer.name', data_get($row, 'salenote.customer.name', data_get($row, 'sale_note.customer.name', '-')));
                        $colNumeroIdent = (string) data_get($saleNote, 'customer.number', data_get($row, 'salenote.customer.number', data_get($row, 'sale_note.customer.number', '-')));
                    } elseif (data_get($row, 'sale_note_id') && data_get($row, 'document_id')) {
                        $colCliente = (string) data_get($saleNote, 'customer.name', data_get($row, 'salenote.customer.name', data_get($row, 'sale_note.customer.name', '-')));
                        $colNumeroIdent = (string) data_get($saleNote, 'customer.number', data_get($row, 'salenote.customer.number', data_get($row, 'sale_note.customer.number', '-')));
                    } elseif (data_get($row, 'document_id') && !data_get($row, 'sale_note_id')) {
                        // Use local $document to avoid relying on unloaded relation
                        $colCliente = (string) data_get($document, 'customer.name', data_get($row, 'document.customer.name', '-'));
                        $colNumeroIdent = (string) data_get($document, 'customer.number', data_get($row, 'document.customer.number', '-'));
                    }
                }
            }

            $rows->push([
                // #
                $index,
                // Fecha
                $dateStr,
                // Operacion
                $colOperacion,
                // Ref
                $colRef,
                // Establecimiento
                $colEstablecimiento,
                // Cliente
                $colCliente,
                // N° Identificacion
                $colNumeroIdent,
                // Concepto
                (string) data_get($row, 'description', ''),
                // Monto
                number_format($amount, 2, '.', ''),
                // Usuario
                (string) data_get($row, 'user.name', data_get($row, 'user', '-')),
                // Condicion de Pago
                $payment_condition ?: '-',
            ]);
        }

        // Append summary rows (11 columns, first 10 empty as in Blade)
        $empty10 = ['', '', '', '', '', '', '', '', '', ''];
        if ($rows->count() > 0) {
            $rows->push(array_merge($empty10, ['RESUMEN DE ARQUEO'])) ;
            $rows->push(array_merge($empty10, ['Ingresos - Venta : S/. ' . number_format(round($ingresos * 10) / 10, 2)]));
            $rows->push(array_merge($empty10, ['Egresos : S/. ' . number_format(round($egresos * 10) / 10, 2)]));

            if ((string) $this->type_box === '2') {
                $rows->push(array_merge($empty10, ['Gastos - Egresos : S/. ' . number_format(round($egresos * 10) / 10, 2)]));
            }
            if ($depositos > 0.0 || $transferencia > 0.0) {
                $rows->push(array_merge($empty10, ['Depositos - Transferencia : S/. ' . number_format(round(($depositos + $transferencia) * 10) / 10, 2)]));
            }
            if ((string) $this->type_box === '1') {
                $rows->push(array_merge($empty10, ['Totales : S/. ' . number_format(($ingresos - $egresos + $depositos + $transferencia), 2)]));
                // The Blade has an unreachable nested check for type_box == '2' here; omitted intentionally
                $rows->push(array_merge($empty10, ['Efectivo : S/. ' . number_format(round(($egresos + $ingresos) * 10) / 10, 2)]));
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            '#',
            'Fecha',
            'Operacion',
            'Ref',
            'Establecimiento',
            'Cliente',
            'N° Identificacion',
            'Concepto',
            'Monto',
            'Usuario',
            'Condicion de Pago',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Estilos para el título y la información de la empresa
    $sheet->mergeCells('A1:K1');
    $sheet->mergeCells('A2:F2');
    $sheet->mergeCells('G2:K2');
    $sheet->mergeCells('A3:F3');
    $sheet->mergeCells('G3:K3');

        // Información de la empresa y fechas
        $sheet->setCellValue('A1', 'Reporte De Venta Por Usuarios');
        $sheet->setCellValue('A2', 'Empresa: ' . data_get($this->company, 'name', ''));
    $sheet->setCellValue('G2', 'Reporte desde ' . Carbon::parse($this->date_start)->format('d-m-Y') .
            ' hasta ' . Carbon::parse($this->date_end)->format('d-m-Y'));
        $sheet->setCellValue('A3', 'Ruc: ' . data_get($this->company, 'number', ''));
    $sheet->setCellValue('G3', 'Establecimiento: ' . data_get($this->establishment, 'address', '') . ' - ' .
            data_get($this->establishment, 'department.description', '') . ' - ' .
            data_get($this->establishment, 'district.description', ''));

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
