<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Note;
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
        $year = $request->year_start;
        $is_year = $year != null;
        
        $type = $request->type;
        $records = $this->getRecords($month, $year);
        if($is_year){
            $month = $year;
        }
        $company = Company::first();
        if ($type == 'excel') {
            $export = (new HealthGlobalExport)
                ->records($records)
                ->isYear($is_year)
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
            $view = $is_year ? 'tenant.health_global.report_year_pdf' : 'tenant.health_global.report_pdf';
            $pdf = PDF::loadView($view, compact("records", "company", "month"))->setPaper('a4', 'landscape');
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
    public function records(Request $request)
    {
        $records = $this->getRecords($request);

        return $records;
    }

    function getRecords($month, $year_dyas = null)
    {
        if ($year_dyas) {
            $year = $year_dyas;
            $month = null;
        } else {
            $explode_month = explode('-', $month);
            $month = $explode_month[1];
            $year = $explode_month[0];
        }
        

        $establishments = Establishment::all();

        $records = [];
        foreach ($establishments as $establishment) {
            $is_service = $establishment->is_service;
            $notes_ft = [];
            $notes_bv = [];
            $rejected_ft = [];
            $rejected_bv = [];
            $anulates_voided_ft = [];
            $anulates_voided_bv = [];
            $anulates_voided = VoidedDocument::whereHas('voided', function ($query) use ($month, $year) {
                if ($month == null) {
                    $query->whereYear('date_of_issue', $year);
                } else {
                    $query->whereMonth('date_of_issue', $month)
                        ->whereYear('date_of_issue', $year);
                }
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
            $ft_anulate = Document::select(['series', 'number'])->where('establishment_id', $establishment->id);
            if ($month == null) {
                $ft_anulate = $ft_anulate->whereYear('date_of_issue', $year);
            } else {
                $ft_anulate = $ft_anulate->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            }
               $ft_anulate = $ft_anulate->where('document_type_id', '01')
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
            $ft_rejected = Document::select(['series', 'number'])->where('establishment_id', $establishment->id);
            if ($month == null) {
                $ft_rejected = $ft_rejected->whereYear('date_of_issue', $year);
            } else {
                $ft_rejected = $ft_rejected->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            }
            $ft_rejected = $ft_rejected
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
            $fv_notes = Note::where('note_type', 'credit')->whereHas('affected_document', function ($query) use ($establishment, $month, $year) {
                
                $query->where('establishment_id', $establishment->id)
                    ->where('document_type_id', '01');
                if ($month == null) {
                    $query->whereYear('date_of_issue', $year);
                } else {
                    $query->whereMonth('date_of_issue', $month)
                        ->whereYear('date_of_issue', $year);
                }
            })->get();
            $fv_total = 0;

            foreach ($fv_notes as $note) {
                $series = $note->document->series;
                $number = $note->document->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $notes_ft)) {
                    $notes_ft[] = $document_full_number;
                }
                $fv_total += $note->document->total;
            }
            $bv_rejected = Document::select(['series', 'number'])->where('establishment_id', $establishment->id);
            if ($month == null) {
                $bv_rejected = $bv_rejected->whereYear('date_of_issue', $year);
            } else {
                $bv_rejected = $bv_rejected->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            }
            $bv_rejected = $bv_rejected
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
            $bv_notes = Note::where('note_type', 'credit')->whereHas('affected_document', function ($query) use ($establishment, $month, $year) {
                $query->where('establishment_id', $establishment->id)
                    ->where('document_type_id', '03');
                if ($month == null) {
                    $query->whereYear('date_of_issue', $year);
                } else {
                    $query->whereMonth('date_of_issue', $month)
                        ->whereYear('date_of_issue', $year);
                }
            })->get();
            $bc_total = 0;
            foreach ($bv_notes as $note) {
                $series = $note->document->series;
                $number = $note->document->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $notes_bv)) {
                    $notes_bv[] = $document_full_number;
                }
                $bc_total += $note->document->total;
            }


            $ft_total = Document::where('establishment_id', $establishment->id)
                ->where('state_type_id', '05')
                ->where('document_type_id', '01');
            if ($month == null) {
                $ft_total = $ft_total->whereYear('date_of_issue', $year);
            } else {
                $ft_total = $ft_total->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            }

            $ft_total = $ft_total->sum('total');
            
            $ft_total = $ft_total - $fv_total;
            $bv_anulate = Document::select(['series', 'number'])->where('establishment_id', $establishment->id)
                ->where('document_type_id', '03')
                ->where('state_type_id', '11');
            if ($month == null) {
                $bv_anulate = $bv_anulate->whereYear('date_of_issue', $year);
            } else {
                $bv_anulate = $bv_anulate->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            }
            $bv_anulate = $bv_anulate->get();
            foreach ($bv_anulate as $bv) {
                $series = $bv->series;
                $number = $bv->number;
                $document_full_number = $series . '-' . $number;
                if (!in_array($document_full_number, $anulates_voided_bv)) {
                    $anulates_voided_bv[] = $document_full_number;
                }
            }
            //
            $bv_total = Document::where('establishment_id', $establishment->id)
                ->whereIn('state_type_id', ['05', '03'])
                ->where('document_type_id', '03');
            if ($month == null) {
                $bv_total = $bv_total->whereYear('date_of_issue', $year);
            } else {
                $bv_total = $bv_total->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            }
            $bv_total = $bv_total->sum('total');
            $bv_total = $bv_total - $bc_total;

            $first_ft = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->where('document_type_id', '01');
            if ($month == null) {
                $first_ft = $first_ft->whereYear('date_of_issue', $year);
            } else {
                $first_ft = $first_ft->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            }
            $first_ft = $first_ft->orderBy('number')->first();

            $last_ft = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->where('document_type_id', '01');
            if ($month == null) {
                $last_ft = $last_ft->whereYear('date_of_issue', $year);
            } else {
                $last_ft = $last_ft->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            }
            $last_ft = $last_ft->orderBy('number', 'desc')->first();

            $first_bv = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->where('document_type_id', '03');
            if ($month == null) {
                $first_bv = $first_bv->whereYear('date_of_issue', $year);
            } else {
                $first_bv = $first_bv->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            }
            $first_bv = $first_bv->orderBy('number')->first();

            $last_bv = Document::select(['total', 'series', 'number', 'document_type_id'])
                ->where('establishment_id', $establishment->id)
                ->where('document_type_id', '03');
            if ($month == null) {
                $last_bv = $last_bv->whereYear('date_of_issue', $year);
            } else {
                $last_bv = $last_bv->whereMonth('date_of_issue', $month)
                    ->whereYear('date_of_issue', $year);
            }
            $last_bv = $last_bv->orderBy('number', 'desc') ->first();
            $has_bv_info = $first_bv || $last_bv || $bv_total || count($anulates_voided_bv) > 0;
            $has_ft_info = $first_ft || $last_ft || $ft_total || count($anulates_voided_ft) > 0;
            $records[] = [
                'notes_ft' => $notes_ft,
                'notes_bv' => $notes_bv,
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
