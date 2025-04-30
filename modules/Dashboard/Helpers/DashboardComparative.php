<?php

namespace Modules\Dashboard\Helpers;

use App\Models\Tenant\Document;
use App\Models\Tenant\Purchase;
use App\Models\Tenant\SaleNote;
use Modules\Inventory\Models\ItemWarehouse;
use Modules\Dashboard\Http\Resources\DashboardStockCollection;

class DashboardComparative
{

    public function data($request)
    {
        return $this->Comparative($request);
    }

    /* private function Comparative($request)
    {
        $facturalo = Document::where('state_type_id', '01')
            ->where('date_of_issue', '>=', $request->start_date)
            ->where('date_of_issue', '<=', $request->end_date)
            ->where('establishment_id', auth()->user()->establishment_id)
            ->where('document_type_id', '!=', '01')
            ->selectRaw('sum(total) as total, month(date_of_issue) as month, year(date_of_issue) as year')
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $boleta = Document::where('state_type_id', '01')
            ->where('date_of_issue', '>=', $request->start_date)
            ->where('date_of_issue', '<=', $request->end_date)
            ->where('establishment_id', auth()->user()->establishment_id)
            ->where('document_type_id', '03')
            ->selectRaw('sum(total) as total, month(date_of_issue) as month, year(date_of_issue) as year')
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $sale_note = SaleNote::where('state_type_id', '01')
            ->where('date_of_issue', '>=', $request->start_date)
            ->where('date_of_issue', '<=', $request->end_date)
            ->where('establishment_id', auth()->user()->establishment_id)
            ->selectRaw('sum(total) as total, month(date_of_issue) as month, year(date_of_issue) as year')
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $purchase = Purchase::where('state_type_id', '01')
            ->where('date_of_issue', '>=', $request->start_date)
            ->where('date_of_issue', '<=', $request->end_date)
            ->where('establishment_id', auth()->user()->establishment_id)
            ->where('document_type_id', '!=', '07')
            ->selectRaw('sum(total) as total, month(date_of_issue) as month, year(date_of_issue) as year')
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return [
            'invoices' => [
                'monthly' => $facturalo,
                'total' => $facturalo->sum('total')
            ],
            'tickets' => [
                'monthly' => $boleta,
                'total' => $boleta->sum('total')
            ],
            'sale_notes' => [
                'monthly' => $sale_note,
                'total' => $sale_note->sum('total')
            ],
            'purchases' => [
                'monthly' => $purchase,
                'total' => $purchase->sum('total')
            ]
        ];
    } */

    private function Comparative($request)
    {
        $months = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [$month => 0];
        });

        $facturalo = Document::whereIn('state_type_id', ['01', '03', '05'])
            ->when($request->start_date, fn($q) => $q->where('date_of_issue', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->where('date_of_issue', '<=', $request->end_date))
            ->where('document_type_id', '01')
            ->selectRaw('sum(total) as total, MONTH(date_of_issue) as month')
            ->groupByRaw('MONTH(date_of_issue)')
            ->get()
            ->pluck('total', 'month')
            ->union($months)
            ->sortKeys();

        $boleta = Document::whereIn('state_type_id', ['01', '03', '05'])
            ->when($request->start_date, fn($q) => $q->where('date_of_issue', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->where('date_of_issue', '<=', $request->end_date))
            ->where('document_type_id', '03')
            ->selectRaw('sum(total) as total, MONTH(date_of_issue) as month')
            ->groupByRaw('MONTH(date_of_issue)')
            ->get()
            ->pluck('total', 'month')
            ->union($months)
            ->sortKeys();

        $sale_note = SaleNote::where('state_type_id', ['01', '03', '05'])
            ->when($request->start_date, fn($q) => $q->where('date_of_issue', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->where('date_of_issue', '<=', $request->end_date))
            ->selectRaw('SUM(total) as total, MONTH(date_of_issue) as month')
            ->groupByRaw('MONTH(date_of_issue)')
            ->get()
            ->pluck('total', 'month')
            ->union($months)
            ->sortKeys();

        $purchase = Purchase::where('state_type_id', '01')
            ->when($request->start_date, fn($q) => $q->where('date_of_issue', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->where('date_of_issue', '<=', $request->end_date))
            ->selectRaw('sum(total) as total, MONTH(date_of_issue) as month')
            ->groupByRaw('MONTH(date_of_issue)')
            ->get()
            ->pluck('total', 'month')
            ->union($months)
            ->sortKeys();

        $month_names = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        return [
            'invoices' => [
                'monthly' => $facturalo->map(fn($total, $month) => [
                    'month' => $month_names[$month],
                    'total' => $total
                ])->values(),
                'total' => $facturalo->sum()
            ],
            'tickets' => [
                'monthly' => $boleta->map(fn($total, $month) => [
                    'month' => $month_names[$month],
                    'total' => $total
                ])->values(),
                'total' => $boleta->sum()
            ],
            'sale_notes' => [
                'monthly' => $sale_note->map(fn($total, $month) => [
                    'month' => $month_names[$month],
                    'total' => $total
                ])->values(),
                'total' => $sale_note->sum()
            ],
            'purchases' => [
                'monthly' => $purchase->map(fn($total, $month) => [
                    'month' => $month_names[$month],
                    'total' => $total
                ])->values(),
                'total' => $purchase->sum()
            ]
        ];
    }
}
