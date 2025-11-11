<?php

namespace Modules\Report\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Carbon\Carbon;

class ItemClientProductExport implements FromArray, WithHeadings, ShouldAutoSize, WithChunkReading, WithCustomStartCell, WithStyles
{
    use Exportable;

    protected $items;
    protected $date_start;
    protected $date_end;
    protected $establishment;
    protected $company;


    public function items($items)
    {
        $this->items = $items;
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

    public function array(): array
    {
        $data = [];
        $total_global = 0;
        $unidades_global = 0;

        // Convertir a array si es colección
        $items = is_array($this->items) ? $this->items : $this->items->toArray();
        // Agrupar por nombre de cliente
        $grouped = collect($items)->groupBy('customer_name');

        $row_number = 1;
        foreach ($grouped as $cliente => $productos) {
            $data[] = [$row_number++, '', $cliente];
            $subtotal = 0;
            $unidad_total = 0;

            foreach ($productos as $producto) {
                $data[] = [
                    '',
                    $producto['total_quantity'] ?? '',
                    /* $producto['item_description'] ?? '', */
                    ($producto['item_description'] ?? '') .
                        (
                            (!empty($producto['selectedGrosor']) || !empty($producto['selectedAncho']) || !empty($producto['selectedLargo']))
                            ? ' - ' .
                            (!empty($producto['selectedGrosor']) ? $producto['selectedGrosor'] : '') .
                            (!empty($producto['selectedAncho']) ? 'x' . $producto['selectedAncho'] : '') .
                            (!empty($producto['selectedLargo']) ? 'x' . $producto['selectedLargo'] : '')
                            : ''
                        ),

                    ($producto['series'] ?? '') . '-' . ($producto['number'] ?? ''),
                    isset($producto['date_of_issue']) ? \Carbon\Carbon::parse($producto['date_of_issue'])->format('Y-m-d') : '',
                    $producto['total'] ?? '',
                    $producto['unit'] ?? '',
                ];
                $subtotal += isset($producto['total']) ? (float)$producto['total'] : 0;
                $unidad_total += isset($producto['total_quantity']) ? (float)$producto['total_quantity'] : 0;
            }

            $data[] = ['', '', '', '', '', $subtotal, $unidad_total];
            $data[] = [];

            $total_global += $subtotal;
            $unidades_global += $unidad_total;
        }

        $data[] = ['', '', '', '', '', 'TOTAL GENERAL', $total_global, 'UNIDADES TOTALES', $unidades_global];

        return $data;
    }

    public function headings(): array
    {
        return ['#', 'Cantidad', 'Producto', 'Documento', 'Fecha', 'Total', 'Unidad'];
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:B2');
        $sheet->mergeCells('C2:H2');
        $sheet->mergeCells('A3:B3');
        $sheet->mergeCells('C3:H3');

    $sheet->setCellValue('A1', 'Reporte de productos por cliente');

    // Safe access to company and establishment to avoid "property of non-object" errors
    $companyName = (isset($this->company) && is_object($this->company)) ? ($this->company->name ?? '') : '';
    $companyNumber = (isset($this->company) && is_object($this->company)) ? ($this->company->number ?? '') : '';

    $sheet->setCellValue('A2', 'Empresa: "' . $companyName . '"');

    $startDate = $this->date_start ? Carbon::parse($this->date_start)->format('d-m-y') : '';
    $endDate = $this->date_end ? Carbon::parse($this->date_end)->format('d-m-y') : '';
    $sheet->setCellValue('C2', 'Fechas:' . $startDate . ' - ' . $endDate);

    $sheet->setCellValue('A3', 'Ruc:' . $companyNumber);

    $est = (isset($this->establishment) && is_object($this->establishment)) ? $this->establishment : null;
    $estAddress = ($est && isset($est->address)) ? $est->address : '';
    $deptDesc = ($est && isset($est->department) && is_object($est->department)) ? ($est->department->description ?? '') : '';
    $distDesc = ($est && isset($est->district) && is_object($est->district)) ? ($est->district->description ?? '') : '';

    $estParts = array_filter([$estAddress, $deptDesc, $distDesc]);
    $estText = implode(' - ', $estParts);
    $sheet->setCellValue('C3', 'Establecimiento:' . $estText);

        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            2 => ['font' => ['bold' => true]],
            3 => ['font' => ['bold' => true]],
            4 => ['font' => ['bold' => true]],
        ];
    }

    function format_unit($row, $uit)
    {
        $max_quantity_item = $row['max_quantity_item'];
        $unit_type = $row['unit_type'];
        $unit_item = $row['unit_item'];
        $count = $uit['count'] * $uit['factor'];
        $full = intdiv($count, $max_quantity_item);
        $rest = $count % $max_quantity_item;
        echo '(' . number_format($uit['count'], 2) . ')' . ' ' . ($full == 0 ? '' : $full . ' ' . $unit_item) . ' ' . ($rest == 0 ? '' : $rest . ' ' . $unit_type);
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
