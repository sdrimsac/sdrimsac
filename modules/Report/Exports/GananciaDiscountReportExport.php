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
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class GananciaDiscountReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading, WithCustomStartCell, WithStyles, WithEvents

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

    // Totales para reporte de ganancias
    protected $total_venta = 0;
    protected $total_compra = 0;
    protected $total_ganancia_igv = 0;
    protected $total_ganancia_igv_global = 0;
    protected $total_ganancia_no_igv = 0;
    protected $total_ganancia_no_igv_global = 0;
    protected $total_ganancia_exo = 0;
    protected $total_ganancia_exo_global = 0;
    protected $total_descuentos = 0;
    protected $total_descuentos_item = 0;
    protected $item_discount = 0;

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

    public function setTotalGananciaExo($total_ganancia_exo)
    {
        $this->total_ganancia_exo = $total_ganancia_exo;
        return $this;
    }

    public function setTotalGananciaExoGlobal($total_ganancia_exo_global)
    {
        $this->total_ganancia_exo_global = $total_ganancia_exo_global;
        return $this;
    }

    public function collection()
    {
        $export = collect();

        // LOG PARA VER DATOS DE sales_data
        Log::info('sales_data para exportación:', $this->sales_data);

        // Inicializar acumuladores de totales
        $totales = [
            'quantity' => 0.0,
            'unit_price' => 0.0,
            'total_sale' => 0.0,
            'purchase_unit_price' => 0.0,
            'total_purchase' => 0.0,
            'global_discount' => 0.0,
            'descuento_item_final' => 0.0,
            'ganancia_unidad_igv' => 0.0,
            'ganancia_global_igv' => 0.0,
            'ganancia_unidad_no_igv' => 0.0,
            'ganancia_global_no_igv' => 0.0,
            'ganancia_global_exo' => 0.0,
            'ganancia_unidad_exo' => 0.0,
            'porcentaje_igv' => [],
            'porcentaje_no_igv' => [],
        ];

    // Calcular totales globales para porcentajes
    $total_ganancia_global_igv = 0;
    $total_ganancia_global_no_igv = 0;
    $total_ganancia_global_exo = 0;
        foreach ($this->sales_data as $record) {
            foreach ($record['items'] as $item) {
                $isExonerado = isset($item['porcentaje_exo']) && self::cleanNumber($item['porcentaje_exo']) > 0;
                if ($isExonerado) {
                    $total_ganancia_global_exo += self::cleanNumber($item['ganancia_global_exo'] ?? 0);
                }
                if (isset($item['ganancia_global_igv']) && self::cleanNumber($item['ganancia_global_igv']) > 0) {
                    $total_ganancia_global_igv += self::cleanNumber($item['ganancia_global_igv']);
                }
                if (isset($item['ganancia_global_no_igv']) && self::cleanNumber($item['ganancia_global_no_igv']) > 0) {
                    $total_ganancia_global_no_igv += self::cleanNumber($item['ganancia_global_no_igv']);
                }
            }
        }

        foreach ($this->sales_data as $record) {
            foreach ($record['items'] as $item) {
                $isExonerado = isset($item['porcentaje_exo']) && self::cleanNumber($item['porcentaje_exo']) > 0;
                // Calcular porcentaje por tipo
                $porcentaje_igv = '';
                $porcentaje_no_igv = '';
                $porcentaje_exo = '';
                if (!$isExonerado && isset($item['ganancia_global_igv']) && self::cleanNumber($item['ganancia_global_igv']) > 0 && $total_ganancia_global_igv > 0) {
                    $porcentaje_igv = round((self::cleanNumber($item['ganancia_global_igv']) / $total_ganancia_global_igv) * 100, 2) . '%';
                }
                if (!$isExonerado && isset($item['ganancia_global_no_igv']) && $total_ganancia_global_no_igv > 0) {
                    $porcentaje_no_igv = round((self::cleanNumber($item['ganancia_global_no_igv']) / $total_ganancia_global_no_igv) * 100, 2) . '%';
                } else if (!$isExonerado && isset($item['ganancia_global_no_igv']) && $total_ganancia_global_no_igv == 0) {
                    $porcentaje_no_igv = '0%';
                } else {
                    $porcentaje_no_igv = '';
                }
                if ($isExonerado && isset($item['ganancia_global_exo']) && self::cleanNumber($item['ganancia_global_exo']) > 0 && $total_ganancia_global_exo > 0) {
                    $porcentaje_exo = round((self::cleanNumber($item['ganancia_global_exo']) / $total_ganancia_global_exo) * 100, 2) . '%';
                }
                $isNotaVenta = isset($record['document_type']) && (strtoupper($record['document_type']) === 'NOTA DE VENTA' || strtoupper($record['document_type']) === 'SALE_NOTE');
                $ganancia_unidad_igv = $isExonerado ? '' : ($isNotaVenta ? ($item['ganancia_unidad_no_igv'] ?? 0) : ($item['ganancia_unidad_igv'] ?? 0));
                $ganancia_global_igv = $isExonerado ? '' : ($isNotaVenta ? ($item['ganancia_global_no_igv'] ?? 0) : ($item['ganancia_global_igv'] ?? 0));
                $porcentaje_igv_final = $isExonerado ? '' : ($isNotaVenta ? $porcentaje_no_igv : $porcentaje_igv);
                $export->push([
                    $record['document_type'] ?? '',
                    $record['series_number'] ?? '',
                    $item['description'] ?? '',
                    $item['quantity'] ?? 0,
                    $item['unit_type'] ?? '',
                    // VENTA
                    $item['unit_price'] ?? 0,
                    $item['total_sale'] ?? 0,
                    // COMPRA
                    $item['purchase_unit_price'] ?? 0,
                    $item['total_purchase'] ?? 0,
                    // DESCUENTOS
                    $record['global_discount'] ?? 0,
                    $item['descuento_item_final'] ?? 0,
                    // GANANCIAS CON IGV (igual a SIN IGV si es nota de venta)
                    $ganancia_unidad_igv,
                    $ganancia_global_igv,
                    $porcentaje_igv_final,
                    // GANANCIAS SIN IGV
                    $isExonerado ? '' : ($item['ganancia_unidad_no_igv'] ?? 0),
                    $isExonerado ? '' : ($item['ganancia_global_no_igv'] ?? 0),
                    $isExonerado ? '' : $porcentaje_no_igv,
                    // GANANCIAS EXONERADOS
                    $item['ganancia_unidad_exo'] ?? 0,
                    $item['ganancia_global_exo'] ?? 0,
                    $porcentaje_exo,
                ]);

                // Limpiar y convertir correctamente los valores string a float antes de sumar
                $totales['quantity'] += self::cleanNumber($item['quantity'] ?? 0);
                $totales['unit_price'] += self::cleanNumber($item['unit_price'] ?? 0);
                $totales['total_sale'] += self::cleanNumber($item['total_sale'] ?? 0);
                $totales['purchase_unit_price'] += self::cleanNumber($item['purchase_unit_price'] ?? 0);
                $totales['total_purchase'] += self::cleanNumber($item['total_purchase'] ?? 0);
                $totales['global_discount'] += self::cleanNumber($record['global_discount'] ?? 0);
                $totales['descuento_item_final'] += self::cleanNumber($item['descuento_item_final'] ?? 0);
                $totales['ganancia_unidad_igv'] += self::cleanNumber($item['ganancia_unidad_igv'] ?? 0);
                $totales['ganancia_global_igv'] += self::cleanNumber($item['ganancia_global_igv'] ?? 0);
                $totales['ganancia_unidad_no_igv'] += self::cleanNumber($item['ganancia_unidad_no_igv'] ?? 0);
                $totales['ganancia_global_no_igv'] += self::cleanNumber($item['ganancia_global_no_igv'] ?? 0);
                $totales['ganancia_unidad_exo'] += self::cleanNumber($item['ganancia_unidad_exo'] ?? 0);
                $totales['ganancia_global_exo'] += self::cleanNumber($item['ganancia_global_exo'] ?? 0);
                // Guardar porcentajes para promediar después
                if (isset($item['porcentaje_igv'])) {
                    $totales['porcentaje_igv'][] = self::cleanNumber($item['porcentaje_igv']);
                }
                if (isset($item['porcentaje_no_igv'])) {
                    $totales['porcentaje_no_igv'][] = self::cleanNumber($item['porcentaje_no_igv']);
                }
            }
        }

        // Agregar fila de totales al final con 100% en cada columna de porcentaje
        $export->push([
            'TOTALES', '', '',
            $totales['quantity'], '',
            $totales['unit_price'],
            $totales['total_sale'],
            $totales['purchase_unit_price'],
            $totales['total_purchase'],
            $totales['global_discount'],
            $totales['descuento_item_final'],
            $totales['ganancia_unidad_igv'],
            $totales['ganancia_global_igv'],
            ($totales['ganancia_global_igv'] > 0 ? '100%' : ''),
            $totales['ganancia_unidad_no_igv'],
            $totales['ganancia_global_no_igv'],
            ($totales['ganancia_global_no_igv'] > 0 ? '100%' : ''),
            $totales['ganancia_unidad_exo'],
            $totales['ganancia_global_exo'],
            ($totales['ganancia_global_exo'] > 0 ? '100%' : ''),
        ]);

        return $export;
    }

    public function headings(): array
    {
        // Encabezados multinivel para simular el formato de la imagen
        return [
            [
                'Tipo de Documento',
                'Serie y Número',
                'Producto',
                'Cantidad',
                'Unidad de Medida',
                'VENTA',
                '',
                'COMPRA',
                '',
                'DESCUENTOS GLOBAL',
                'DESCUENTOS ITEM',
                'GANANCIAS CON IGV',
                '',
                '',
                'GANANCIAS SIN IGV',
                '',
                '',
                'GANANCIAS EXONERADOS',
                '',
                '',
            ],
            [
                '',
                '',
                '',
                '',
                '',
                'Precio Unit Venta',
                'Total Venta',
                'Precio Unit Compra',
                'Total Compra',
                '',
                '',
                'Ganancia por Unidad',
                'Ganancia Global',
                '%',
                'Ganancia por Unidad',
                'Ganancia Global',
                '%',
                'Ganancia por Unidad',
                'Ganancia Global',
                '%',
            ]
        ];
    }

    /**
     * Limpia y convierte un valor string a float para totales
     */
    private static function cleanNumber($value) {
        $value = trim($value);
        $value = str_replace(',', '.', $value);
        return is_numeric($value) ? floatval($value) : 0.0;
    }

    public function styles(Worksheet $sheet)
    {
        // Encabezados superiores
        $sheet->mergeCells('A1:S1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('F2:I2');
        $sheet->mergeCells('J2:K2');
        $sheet->mergeCells('L2:L3');
        $sheet->mergeCells('M2:M3');
        $sheet->mergeCells('N2:P2');
        $sheet->mergeCells('Q2:S2');

        $sheet->setCellValue('A1', 'Reporte De Ganacias con descuentos');
        $sheet->setCellValue('A2', 'Empresa: ' . $this->company->name);
        $sheet->setCellValue('F2', 'Reporte desde ' . Carbon::parse($this->date_start)->format('d-m-Y') .
            ' hasta ' . Carbon::parse($this->date_end)->format('d-m-Y'));
        $sheet->setCellValue('J2', 'Establecimiento: ' . $this->establishment->address . ' - ' .
            $this->establishment->department->description . ' - ' .
            $this->establishment->district->description);
        $sheet->setCellValue('A3', 'Ruc: ' . $this->company->number);

        // Encabezados de tabla
        $sheet->mergeCells('A4:A5');
        $sheet->mergeCells('B4:B5');
        $sheet->mergeCells('C4:C5');
        $sheet->mergeCells('D4:D5');
        $sheet->mergeCells('E4:E5');
        $sheet->mergeCells('F4:G4'); // VENTA
        $sheet->mergeCells('H4:I4'); // COMPRA
        $sheet->mergeCells('J4:J5'); // DESCUENTOS GLOBAL
        $sheet->mergeCells('K4:K5'); // DESCUENTOS ITEM
        $sheet->mergeCells('L4:N4'); // GANANCIAS CON IGV
        $sheet->mergeCells('O4:Q4'); // GANANCIAS SIN IGV
        $sheet->mergeCells('R4:T4'); // GANANCIAS EXONERADOS

        // Sombrear la fila de totales (última fila)
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A' . $highestRow . ':T' . $highestRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']],
            'alignment' => ['horizontal' => 'right']
        ]);

        // Estilos para encabezados
        return [
            1 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center']],
            2 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'left']],
            3 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'left']],
            4 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']], 'alignment' => ['horizontal' => 'center']],
            5 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']], 'alignment' => ['horizontal' => 'center']],
        ];
    }

    // Se elimina el evento AfterSheet para totales, ya que la suma de totales se realiza en collection() como autosuma de Excel.
    public function registerEvents(): array
    {
        return [];
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
