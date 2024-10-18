<?php

namespace App\Exports;

use App\Models\Tenant\Company;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Receipt;
use App\Models\Tenant\SaleNoteItem;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class SheetExport implements FromCollection, WithEvents, ShouldAutoSize, WithTitle, WithCustomStartCell
{
    protected $credit_info;
    protected $payments;
    protected $receipts;
    protected $items;

    public function __construct()
    {
        // $this->credit_info = null;
        $this->payments = [];
        $this->receipts = [];
    }

    public function credit_info($credit_info)
    {
        $this->credit_info = $credit_info;
        $this->getData($credit_info->id);
        return $this;
    }

    function getData($id)
    {
        $payments = Payment::where('sale_note_id', $id)->get();
        $receipts = Receipt::where('sale_note_id', $id)->get();
        $items = SaleNoteItem::where('sale_note_id', $id)->get()
            ->transform(function ($row) {
                return  (object)[
                    'internal_id' => $row->item->internal_id,
                    'description' => $row->item->description,
                    'quantity' => $row->quantity,
                    'unit_price' => $row->unit_price,
                ];
            });
        $this->payments = $payments;
        $this->receipts = $receipts;
        $this->items = $items;
    }

    public function title(): string
    {
        $title = "Crédito " . $this->credit_info->series . '-' . $this->credit_info->number;
        return $title;
    }
    public function startCell(): string
    {
        return 'A4'; // Comenzar los datos en la fila 4 para dejar espacio para la cabecera
    }
    public function collection()
    {
        // Preparar los datos de recibos
        $receiptData = collect([
            ['Recibo', 'Fecha de pago', 'Monto', 'Penalidad']
        ]);

        foreach ($this->receipts as $receipt) {
            $receiptData->push([
                $receipt->number,
                $receipt->date_of_issue,
                $receipt->amount,
                $receipt->penalty_paid
            ]);
        }

        // Preparar los datos de items
        $itemData = collect([
            ['Código interno', 'Descripción', 'Cantidad']
        ]);

        foreach ($this->items as $item) {
            $itemData->push([
                $item->internal_id,
                $item->description,
                $item->quantity
            ]);
        }

        // Combinar los datos horizontalmente
        $combinedData = collect();
        $maxRows = max($receiptData->count(), $itemData->count());

        for ($i = 0; $i < $maxRows; $i++) {
            $row = [];

            // Agregar datos de recibos
            if (isset($receiptData[$i])) {
                $row = array_merge($row, $receiptData[$i]);
            } else {
                if ($i === 0)
                    $row = array_merge($row, ['No hay recibos', '', '', '']);
                else
                    $row = array_merge($row, ['', '', '', '']);
                // $row = array_merge($row, ['', '', '', '']);
            }

            // Agregar un espacio entre tablas
            $row[] = '';

            // Agregar datos de items
            if (isset($itemData[$i])) {
                $row = array_merge($row, $itemData[$i]);
            }

            $combinedData->push($row);
        }

        return $combinedData;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet->mergeCells('A1:B1');
                $event->sheet->mergeCells('C1:D1');
                $event->sheet->mergeCells('A2:B2');
                $event->sheet->mergeCells('C2:D2');
                $event->sheet->mergeCells('G1:I1');
                // $event->sheet->mergeCells('A1:H1');
                // $event->sheet->mergeCells('A2:H2');

                $event->sheet->setCellValue('A1', 'FECHA DE EMISIÓN');
                $event->sheet->setCellValue('C1', $this->credit_info->date_of_issue->format('d/m/Y'));
                $event->sheet->setCellValue('A2', 'ESTADO DE CRÉDITO');
                $event->sheet->setCellValue('C2', $this->credit_info->returnStatus());
                // $event->sheet->setCellValue('A1', 'EMPRESA XYZ S.A.C.');
                // $event->sheet->setCellValue('A2', 'xdd');
                $anulate_reason = null;
                if($this->credit_info->status == 'R'){
                    $sale_note_credit = $this->credit_info->sale_note_credit;
                    if($sale_note_credit){
                        $anulate_reason = $sale_note_credit->reason_to_anulate_credit;
                    }
                }
                if($anulate_reason){
                    $event->sheet->setCellValue('F1', 'MOTIVO DE ANULACIÓN:');
                    $event->sheet->setCellValue('G1', $anulate_reason);
                    $event->sheet->getStyle('F1')
                        ->applyFromArray([
                            'font' => ['bold' => true],
                        ]);
                }
                $status_color = [
                    //A is green, P is orange, C is red, all with white text
                    'A' => '008000',
                    'P' => 'FFA500',
                    'R' => 'FF0000',
                ];
                $event->sheet->getStyle('C2:D2')
                    ->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => $status_color[$this->credit_info->status]],
                        ],
                        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],

                    ]);
                // $event->sheet->getStyle('A1:H2')->applyFromArray([
                //     'font' => [
                //         'bold' => true,
                //         'size' => 14
                //     ],
                //     'alignment' => [
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                //         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                //     ],
                // ]);

                // $event->sheet->getRowDimension(1)->setRowHeight(30);
                // $event->sheet->getRowDimension(2)->setRowHeight(25);
            },
            AfterSheet::class => function (AfterSheet $event) {
                // Ajustar el estilo para los encabezados de las tablas (ahora empiezan en fila 4)
                $event->sheet->getStyle('A4:D4')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E4E4E4']
                    ]
                ]);

                $event->sheet->getStyle('F4:H4')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E4E4E4']
                    ]
                ]);

                // Ajustar los bordes (sumando 3 a las filas para compensar la cabecera)
                $lastRow = count($this->receipts) + 4;
                $event->sheet->getStyle('A4:D' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $lastRowItems = count($this->items) + 4;
                $event->sheet->getStyle('F4:H' . $lastRowItems)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Configurar la impresión para repetir la cabecera
                $event->sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 2);
            },
        ];
    }


    // public function view(): View
    // {
    //     $company = Company::first();
    //     $view = 'tenant.sale_notes.all_credit';
    //     return view($view, [
    //         'credit_info' => $this->credit_info,
    //         'payments' => $this->payments,
    //         'receipts' => $this->receipts,
    //         'items' => $this->items,
    //         'company' => $company

    //     ]);
    // }
}

class CreditByClientExport implements ShouldAutoSize, WithMultipleSheets
{
    use Exportable;
    protected $records;

    public function records($records)
    {
        $this->records = $records;

        return $this;
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->records as $record) {
            $sheets[] = (new SheetExport())
                ->credit_info($record);
        }
        return $sheets;
    }
}
