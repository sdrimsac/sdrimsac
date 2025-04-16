<?php

namespace Modules\Restaurant\Events;

use Illuminate\Broadcasting\Channel;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Report\Exports\GananciaReportExport;


use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Item;
use Carbon\Carbon;
use Hyn\Tenancy\Environment;

class GenerateExcelReportJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $params;
    protected $user_id;

    public function __construct($params, $user_id)
    {
        $this->params = $params;
        $this->user_id = $user_id;
    }

    public function handle()
    {
        ini_set('max_execution_time', "3000");
        ini_set('memory_limit', '2048M');

        $sales_data = [];
        $total_utility = 0;
        $total_net_utility = 0;

        $date_start = $this->params['date_start'];
        $date_end = $this->params['date_end'];

        // Procesar documentos en chunks
        Document::whereNotIn('state_type_id', ['09', '11'])
            ->when($this->params['date_start'], function ($query) {
                return $this->params['date_end']
                    ? $query->whereBetween('date_of_issue', [$this->params['date_start'], $this->params['date_end']])
                    : $query->whereDate('date_of_issue', $this->params['date_start']);
            })
            ->when($this->params['establishment_id'], function ($query) {
                return $query->where('establishment_id', $this->params['establishment_id']);
            })
            ->chunk(100, function ($documents) use (&$sales_data, &$total_utility, &$total_net_utility) {
                foreach ($documents as $document) {
                    $this->processDocument($document, $sales_data, $total_utility, $total_net_utility);
                }
            });

        // Procesar notas de venta en chunks
        SaleNote::where('state_type_id', '<>', '11')
            ->when($this->params['date_start'], function ($query) {
                return $this->params['date_end']
                    ? $query->whereBetween('date_of_issue', [$this->params['date_start'], $this->params['date_end']])
                    : $query->whereDate('date_of_issue', $this->params['date_start']);
            })
            ->when($this->params['establishment_id'], function ($query) {
                return $query->where('establishment_id', $this->params['establishment_id']);
            })
            ->chunk(100, function ($sale_notes) use (&$sales_data, &$total_utility, &$total_net_utility) {
                foreach ($sale_notes as $sale_note) {
                    $this->processSaleNote($sale_note, $sales_data, $total_utility, $total_net_utility);
                }
            });

        $is_service = false;
        if ($this->params['item_id'] !== null) {
            $item = Item::findOrFail($this->params['item_id']);
            $is_service = $item->unit_type_id == "ZZ";
        }


        $export = new GananciaReportExport();
        $export->salesData($sales_data)
            ->company($this->params['company'])
            ->establishment($this->params['establishment'])
            ->dateStart($this->params['date_start'])
            ->dateEnd($this->params['date_end'])
            ->date_start($date_start)
            ->date_end($date_end)
            ->isService($is_service)
            ->totalUtility($total_utility)
            ->totalNetUtility($total_net_utility);


        $website = app(Environment::class)->tenant();
        $tenant_uuid = $website->uuid;

        $filename = $this->params['filename'];
        $tenant_path = "tenancy/tenants/{$tenant_uuid}/reports/gains";
        $full_path = "{$tenant_path}/{$filename}";

        Storage::makeDirectory($tenant_path);

        Storage::put($full_path, Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX));
    }

    private function processDocument($document, &$sales_data, &$total_utility, &$total_net_utility)
    {
        $items_data = [];
        $document_total_utility = 0;
        $document_total_net_utility = 0;

        foreach ($document->items as $item) {
            $unit_price = $item->unit_price;
            $quantity = $item->quantity;
            $purchase_unit_price = $item->relation_item->purchase_unit_price ?? 0;

            if ($item->affectation_igv_type_id == '10') {
                $unit_price = $unit_price / 1.18;
                $purchase_unit_price = $purchase_unit_price / 1.18;
            }

            $total_purchase = $purchase_unit_price * $quantity;
            $total_sale = $unit_price * $quantity;
            $utility = $total_sale - $total_purchase;

            $net_utility = $utility;
            if ($item->affectation_igv_type_id == '10') {
                $net_utility = $utility / 1.18;
            }

            $items_data[] = [
                'description' => $item->item->description,
                'quantity' => $quantity,
                'unit_type' => $item->item->unit_type_id,
                'purchase_unit_price' => number_format($purchase_unit_price, 2),
                'total_purchase' => number_format($total_purchase, 2),
                'unit_price' => number_format($unit_price, 2),
                'total_sale' => number_format($total_sale, 2),
                'utility' => number_format($utility, 2),
                'net_utility' => number_format($net_utility, 2)
            ];

            $document_total_utility += $utility;
            $document_total_net_utility += $net_utility;
        }

        $sales_data[] = [
            'document_type' => $document->document_type->description,
            'series_number' => $document->series . '-' . $document->number,
            'customer' => $document->customer->name,
            'date' => Carbon::parse($document->date_of_issue)->format('d/m/Y'),
            'items' => $items_data,
            'total_utility' => number_format($document_total_utility, 2),
            'total_net_utility' => number_format($document_total_net_utility, 2)
        ];

        $total_utility += $document_total_utility;
        $total_net_utility += $document_total_net_utility;
    }

    private function processSaleNote($sale_note, &$sales_data, &$total_utility, &$total_net_utility)
    {
        $items_data = [];
        $document_total_utility = 0;
        $document_total_net_utility = 0;

        foreach ($sale_note->items as $item) {
            $unit_price = $item->unit_price;
            $quantity = $item->quantity;
            $purchase_unit_price = $item->relation_item->purchase_unit_price ?? 0;

            $total_purchase = $purchase_unit_price * $quantity;
            $total_sale = $unit_price * $quantity;
            $utility = $total_sale - $total_purchase;
            $net_utility = $utility;

            $items_data[] = [
                'description' => $item->item->description,
                'quantity' => $quantity,
                'unit_type' => $item->item->unit_type_id,
                'purchase_unit_price' => number_format($purchase_unit_price, 2),
                'total_purchase' => number_format($total_purchase, 2),
                'unit_price' => number_format($unit_price, 2),
                'total_sale' => number_format($total_sale, 2),
                'utility' => number_format($utility, 2),
                'net_utility' => number_format($net_utility, 2)
            ];

            $document_total_utility += $utility;
            $document_total_net_utility += $net_utility;
        }

        $sales_data[] = [
            'document_type' => 'NOTA DE VENTA',
            'series_number' => $sale_note->series . '-' . $sale_note->number,
            'customer' => $sale_note->customer->name,
            //'date' => $sale_note->date_of_issue->format('d/m/Y'),
            'date' => \Carbon\Carbon::parse($sale_note->date_of_issue)->format('d/m/Y'),
            'items' => $items_data,
            'total_utility' => number_format($document_total_utility, 2),
            'total_net_utility' => number_format($document_total_net_utility, 2)
        ];

        $total_utility += $document_total_utility;
        $total_net_utility += $document_total_net_utility;
    }
}
