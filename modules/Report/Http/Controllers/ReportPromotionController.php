<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Modules\Report\Traits\ReportTrait;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\User;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Person;
use App\Models\Tenant\PromotionDocument;
use App\Models\Tenant\PromotionDocumentCustomer;
use App\Models\Tenant\PromotionReceived;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\SaleNoteItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\Report\Exports\ReportCreditDailyExport;
use Modules\Report\Exports\ReportCreditExport;
use Modules\Report\Exports\ReportCreditTypeCashExport;
use Modules\Report\Exports\ReportCreditTypeProductExport;
use Modules\Report\Exports\ReportPromotionDocumentExport;
use Modules\Report\Http\Resources\ReportCreditCollection;
use Modules\Report\Http\Resources\ReportCreditDailyCollection;
use Modules\Report\Http\Resources\ReportPromotionDocumentCollection;

class ReportPromotionController extends Controller
{
    use ReportTrait;


    public function filter()
    {

        $users = User::whereType('seller')
            ->where('active', true)
            ->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'name' => $row->name
                ];
            });
        $establishments = Establishment::all()->transform(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->description
            ];
        });
        $sellers = $this->getSellers();
        $persons = $this->getPersons('customers');

        return compact('establishments', 'sellers', 'persons', 'users');
    }


    public function index()
    {
        $configuration = Configuration::first();
        return view('report::promotions.index', compact('configuration'));
    }


    public function detail($document_customer_id)
    {
        $document_customer = PromotionDocumentCustomer::findOrFail($document_customer_id);
        $document_promotion = PromotionDocument::find($document_customer->promotion_document_id);
        /* $receiveds = PromotionReceived::where('promotion_document_customer_id', $document_customer_id)->get()->transform(function ($row) use ($document_promotion) {
            $item = $document_promotion->items->where('item_id', $row->item_id)->first();
            $points = $item->points_value;
            return [
                'id' => $row->id,
                'product' => $row->item->description,
                'quantity' => $row->quantity,
                'image' => $row->item->image,
                'image_url' => ($row->item->image !== 'imagen-no-disponible.jpg') ? asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'items' . DIRECTORY_SEPARATOR . $row->item->image) : asset("/logo/{$row->item->image}"),
                'date' => $row->created_at->format('d/m/Y'),
                'time' => $row->created_at->format('H:i:s'),
                'seller' => isset($row->user) ? $row->user->name : '-',
                'points' => $points
            ];
        }); */

        $receiveds = PromotionReceived::where(
            'promotion_document_customer_id',
            $document_customer_id
        )->get()->transform(function ($row) use ($document_promotion) {

            $item = $document_promotion->items
                ->where('item_id', $row->item_id)
                ->first();

            $unit_points = (float) $item->points_value;
            $total_points_used = $unit_points * $row->quantity;

            return [
                'id' => $row->id,
                'product' => $row->item->description,
                'quantity' => $row->quantity,
                'unit_points' => $unit_points,          // 🔹 NUEVO
                'total_points' => $total_points_used,   // 🔹 NUEVO
                'image' => $row->item->image,
                'image_url' => ($row->item->image !== 'imagen-no-disponible.jpg')
                    ? asset('storage/uploads/items/' . $row->item->image)
                    : asset("/logo/{$row->item->image}"),
                'date' => $row->created_at->format('d/m/Y'),
                'time' => $row->created_at->format('H:i:s'),
                'seller' => isset($row->user) ? $row->user->name : '-',
            ];
        });


        return [
            'success' => true,
            'document_customer' => $document_customer,
            'receiveds' => $receiveds
        ];
    }

    /* public function reportItems($document_customer_id)
    {
        $details = $this->detail($document_customer_id);
        // generate PDF
        $company = Company::first();
        $establishment = Establishment::first();
        $pdf = PDF::loadView('report::promotions.report_items_points_pdf', compact("document_customer", "receiveds", "company", "establishment"))
            ->setPaper('a4', 'landscape');
    } */

    public function reportItems($document_customer_id)
    {
        $customer = Person::find($document_customer_id);
        $details = $this->detail($document_customer_id);
        $document_customer = $details['document_customer'] ?? null;
        $receiveds = $details['receiveds'] ?? collect();

        $company = Company::first();
        $establishment = Establishment::first();

        $pdf = PDF::loadView(
            'report::promotions.report_items_points',
            compact("document_customer", "receiveds", "company", "establishment", "customer")
        )->setPaper('a4',);
        // Guardar PDF
        //$path = storage_path("app/public/reports/report_items_points_{$document_customer_id}.pdf");
        //$pdf->save($path);

        // Retornar PDF al navegador
        return $pdf->stream("report_items_points_{$document_customer_id}.pdf");
    }



    public function records(Request $request)
    {
        $records = $this->getRecords($request);
        return new ReportPromotionDocumentCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function getRecords(Request $request)
    {
        // Log de los valores recibidos
        $configuration = Configuration::first();
        $records = PromotionDocumentCustomer::query();
        $records = $records->whereHas('promotion_document', function ($query) use ($configuration) {
            $query->where('is_points', $configuration->promotions_by_points);
        })->whereHas('customer', function ($query) {
            $query->where('name', 'not like', '%clientes varios%');
        });

        // Filtro por isFromAdmin y meses
        $isFromAdmin = $request->input('isFromAdmin');
        $month_start = $request->input('month_start');
        $month_end = $request->input('month_end');

        if ($isFromAdmin) {
            if ($month_start && $month_end) {
                // Si ambos meses vienen, filtra entre ambos
                $startDate = Carbon::parse($month_start . '-01')->startOfMonth();
                $endDate = Carbon::parse($month_end . '-01')->endOfMonth();
                $records = $records->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($month_start) {
                // Si solo viene month_start, filtra solo ese mes
                $startDate = Carbon::parse($month_start . '-01')->startOfMonth();
                $endDate = Carbon::parse($month_start . '-01')->endOfMonth();
                $records = $records->whereBetween('created_at', [$startDate, $endDate]);
            }
        } else {
            // Filtro normal por fechas
            $period = $this->getDatesOfPeriod($request);
            if ($period['d_start'] && $period['d_end']) {
                $d_start = Carbon::parse($period['d_start'])->startOfDay();
                $d_end = Carbon::parse($period['d_end'])->endOfDay();
                $records = $records->whereBetween('created_at', [$d_start, $d_end]);
            }
        }

        $person_id = $request->person_id;
        if ($person_id) {
            $records = $records->where('customer_id', $person_id);
        }

        return $records;
    }


    public function pdf(Request $request)
    {
        $configuration = Configuration::first();
        $company = Company::first();
        $records = $this->getRecords($request)->get()->transform(function ($row) {
            $changeInfo = $this->checkLimit($row->promotion_document_id, $row->customer_id);
            $receiveds = PromotionReceived::where('promotion_document_customer_id', $row->id)->get()->transform(function ($received) {
                $item = $received->promotion_document_customer->promotion_document->items->where('item_id', $received->item_id)->first();
                $points = $item->points_value;
                return [
                    'product' => $received->item->description,
                    'quantity' => $received->quantity,
                    'date' => $received->created_at->format('d/m/Y'),
                    'time' => $received->created_at->format('H:i:s'),
                    'seller' => isset($received->user) ? $received->user->name : '-',
                    'points' => $points
                ];
            });

            return (object) [
                'id' => $row->id,
                'customer_name' => $row->customer->name,
                'promotion_name' => $row->promotion_document->description,
                'points' => $row->points,
                'acc_total' => $row->acc_total,
                'receiveds' => $receiveds,
                'change_count' => $changeInfo['change_count']
            ];
        });

        $establishment = Establishment::first();
        $pdf = PDF::loadView('report::promotions.report_pdf', compact("records", "company", "establishment"))
            ->setPaper('a4', 'landscape');

        $filename = 'Reporte_Promociones_' . date('YmdHis');

        return $pdf->stream($filename . '.pdf');
    }

    public function checkLimit($promotion_id, $customer_id)
    {
        $configuration = Configuration::first();
        if (!$configuration->promotions_by_points) return true;
        $promotion_document = PromotionDocument::find($promotion_id);
        $limit_changes = $promotion_document->limit_changes;
        $changes = PromotionReceived::whereHas('promotion_document_customer', function ($query) use ($promotion_id, $customer_id) {
            $query->where('promotion_document_id', $promotion_id)
                ->where('customer_id', $customer_id);
        });

        if ($configuration->promotions_by_points) {
            $changes = $changes->groupBy('item_id')
                ->selectRaw('item_id, count(*) as total')
                ->get()
                ->count();
        } else {
            $changes = $changes->distinct('promotion_document_customer_id')
                ->count('promotion_document_customer_id');
        }

        return [
            'within_limit' => $changes <= $limit_changes,
            'change_count' => $changes
        ];
    }

    public function excel(Request $request)
    {
        $records = $this->getRecords($request)->get()->transform(function ($row) {
            $changeInfo = $this->checkLimit($row->promotion_document_id, $row->customer_id);
            $receiveds = PromotionReceived::where('promotion_document_customer_id', $row->id)->get()->transform(function ($received) {
                $item = $received->promotion_document_customer->promotion_document->items->where('item_id', $received->item_id)->first();
                $points = $item->points_value;
                return [
                    'product' => $received->item->description,
                    'quantity' => $received->quantity,
                    'date' => $received->created_at->format('d/m/Y'),
                    'time' => $received->created_at->format('H:i:s'),
                    'seller' => isset($received->user) ? $received->user->name : '-',
                    'points' => $points
                ];
            });

            return (object) [
                'id' => $row->id,
                'customer_name' => $row->customer->name,
                'promotion_name' => $row->promotion_document->description,
                'points' => $row->points,
                'acc_total' => $row->acc_total,
                'receiveds' => $receiveds,
                'change_count' => $changeInfo['change_count']
            ];
        });

        $company = Company::first();

        return (new ReportPromotionDocumentExport)
            ->records($records)
            ->company($company)
            ->download('Reporte_Promociones_' . Carbon::now() . '.xlsx');
    }
}
