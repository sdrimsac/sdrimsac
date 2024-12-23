<?php

namespace Modules\Report\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportPromotionDocumentExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{
    use Exportable;

    public $company;
    public $records;

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

    public function collection()
    {
        $data = collect();

        foreach ($this->records as $record) {
            $data->push([
                'Cliente' => $record->customer_name,
                'Promoción' => $record->promotion_name,
                'Puntos/Monto' => $record->points,
                'Canjes' => $record->change_count,
                'Producto' => '',
                'Cantidad' => '',
                'Fecha' => '',
                'Hora' => '',
                'Vendedor' => '',
                'Puntos' => '',
            ]);

            foreach ($record->receiveds as $received) {
                $data->push([
                    'Cliente' => '',
                    'Promoción' => '',
                    'Puntos/Monto' => '',
                    'Canjes' => '',
                    'Producto' => $received['product'],
                    'Cantidad' => $received['quantity'],
                    'Fecha' => $received['date'],
                    'Hora' => $received['time'],
                    'Vendedor' => $received['seller'],
                    'Puntos' => $received['points'],
                ]);
            }

            // Agregar una fila vacía para separar los registros
            $data->push([
                'Cliente' => '',
                'Promoción' => '',
                'Puntos/Monto' => '',
                'Canjes' => '',
                'Producto' => '',
                'Cantidad' => '',
                'Fecha' => '',
                'Hora' => '',
                'Vendedor' => '',
                'Puntos' => '',
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'Promoción',
            'Puntos/Monto',
            'Canjes',
            'Producto',
            'Cantidad',
            'Fecha',
            'Hora',
            'Vendedor',
            'Puntos',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para el encabezado
            1 => ['font' => ['bold' => true]],
        ];
    }
}
