<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\VoidedDocument;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Report\Exports\HealthGlobalExport;
use Barryvdh\DomPDF\Facade as PDF;

class HealthGlobalController
{
    public function index()
    {
        return view('tenant.health_global.index');
    }

    public function report(Request $request)
    {

        $month = $request->month_start;
        $type = $request->type;
        $records = $this->getRecords($month);
        $company = Company::first();
        if ($type == 'excel') {
            $export = (new HealthGlobalExport)
                ->records($records)
                ->company($company)
                ->month($month);
            //remove all files in the folder
            $files = glob(storage_path('app/public/global_reports/*'));
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            $filename = 'Reporte_Global_Salud_' . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';
            $export->store('global_reports/' . $filename, 'public');


            //get the url and returnet to the frontend
            $url = asset('storage/global_reports/' . $filename);
            return [
                'success' => true,
                'data' => $url,
            ];
        } else {
            $pdf = PDF::loadView('tenant.health_global.report_excel', compact("records", "company", "month"))->setPaper('a4', 'landscape');
            //  $pdf->stream('Listado_Clientes' . date('YmdHis') . '.pdf');
            //save the pdf in the storage
            //remove all files in the folder
            $files = glob(storage_path('app/public/global_reports/*'));
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }

            $filename = 'Reporte_Global_Salud_' . Carbon::now()->format('Y_m_d_H_i_s') . '.pdf';
            $pdf->save(storage_path('app/public/global_reports/' . $filename));
            //get the url and returnet to the frontend
            $url = asset('storage/global_reports/' . $filename);
            return [
                'success' => true,
                'data' => $url,
            ];
        }
        // return [
        //     'success' => true,
        //     'data' => $records,
        // ];
    }

    function getRecords($month)
    {
        $explode_month = explode('-', $month);
        $month = $explode_month[1];
        $year = $explode_month[0];

        $establishments = Establishment::all();

        $records = [];

        foreach ($establishments as $establishment) {
            $is_service = $establishment->is_service;
            $rejected_ft = [];
            $rejected_bv = [];
            $anulates_voided_ft = [];
            $anulates_voided_bv = [];
            $anulates_voided = VoidedDocument::whereHas('voided', function ($query) use ($month, $year) {
                $query->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            })
                ->whereHas('document', function ($query) use ($establishment) {
                    $query->where('establishment_id', $establishment->id);
                })
                ->get();
            foreach ($anulates_voided as $anulate_voided) {
                $series = $anulate_voided->document->series;
                $number = $anulate_voided->document->number;
                $document_full_number = $series . '-' . $number;
                if ($anulate_voided->document->document_type_id == '01')
                    $anulates_voided_ft[] = $document_full_number;
                if ($anulate_voided->document->document_type_id == '03')
                    $anulates_voided_bv[] = $document_full_number;
            }
            $ft_anulate = Document::select(['series', 'number'])->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '01')
                ->where('state_type_id', '11')
                ->get();

            foreach ($ft_anulate as $ft) {
                $series = $ft->series;
                $number = $ft->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $anulates_voided_ft)) {
                    $anulates_voided_ft[] = $document_full_number;
                }
            }
            $ft_rejected = Document::select(['series', 'number'])->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '01')
                ->where('state_type_id', '09')
                ->get();
            foreach ($ft_rejected as $ft) {
                $series = $ft->series;
                $number = $ft->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $rejected_ft)) {
                    $rejected_ft[] = $document_full_number;
                }
            }
            $bv_rejected = Document::select(['series', 'number'])->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '03')
                ->where('state_type_id', '09')
                ->get();
            foreach ($bv_rejected as $bv) {
                $series = $bv->series;
                $number = $bv->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $rejected_bv)) {
                    $rejected_bv[] = $document_full_number;
                }
            }

            $ft_total = Document::where('establishment_id', $establishment->id)
                ->where('state_type_id', '05')
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '01')
                ->sum('total');
            $bv_anulate = Document::select(['series', 'number'])->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '03')
                ->where('state_type_id', '11')
                ->get();
            foreach ($bv_anulate as $bv) {
                $series = $bv->series;
                $number = $bv->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $anulates_voided_bv)) {
                    $anulates_voided_bv[] = $document_full_number;
                }
            }
            $bv_total = Document::where('establishment_id', $establishment->id)
                ->where('state_type_id', '05')
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '03')
                ->sum('total');

            $first_ft = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '01')
                ->first();

            $last_ft = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '01')
                ->latest()
                ->first();

            $first_bv = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '03')
                ->first();

            $last_bv = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->whereMonth('date_of_issue', $month)
                ->whereYear('date_of_issue', $year)
                ->where('document_type_id', '03')
                ->latest()
                ->first();
            $has_bv_info = $first_bv || $last_bv || $bv_total || count($anulates_voided_bv) > 0;
            $has_ft_info = $first_ft || $last_ft || $ft_total || count($anulates_voided_ft) > 0;
            $records[] = [
                'rejected_ft' => $rejected_ft,
                'rejected_bv' => $rejected_bv,
                'has_bv_info' => $has_bv_info,
                'has_ft_info' => $has_ft_info,
                'establishment_id' => $establishment->id,
                'establishment' => $establishment->description,
                'is_service' => $is_service,
                'ft_total' => $ft_total,
                'bv_total' => $bv_total,
                'first_ft' => $first_ft,
                'last_ft' => $last_ft,
                'first_bv' => $first_bv,
                'last_bv' => $last_bv,
                'anulates_voided_ft' => $anulates_voided_ft,
                'anulates_voided_bv' => $anulates_voided_bv,
            ];
        }

        //order records first is_service and then by establishment_id
        $filteredRecords = array_filter($records, function ($record) {
            return $record['is_service'] == 1;
        });

        usort($filteredRecords, function ($a, $b) {
            return $a['establishment_id'] <=> $b['establishment_id'];
        });

        return $records;
    }
}
