<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CashCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {

        $from_cash = $request->from_cash;
        // Preload related data to avoid N+1 problem
        if (!$from_cash) {
            $this->collection->each->load(['user', 'user.establishment', 'boxes.salenote', 'boxes.document']);
        }

        $company = Company::first();
        $company_number = $company->number;
        return $this->collection->transform(function ($row) use ($from_cash,$company_number) {
            $final_cash = 0;
            $has_ticket = false;
            $has_a4 = false;
            $path_ticket_url = url('caja/worker/cash/print-report?cash_id='.$row->id);
            // $path_ticket = storage_path('app/public/report_resumen_pdf_pos_small_' . $row->id . '.pdf');
            $path_ticket = storage_path('app/public/report_resumen_pdf_pos_small_' . $row->id .'_'.$company_number.'.pdf');
            if (file_exists($path_ticket)||$row->state == 1) {
                $has_ticket = true;
            }
            $path_a4 = storage_path('app/public/report_resumen_pdf_pos_'.$row->id.'_'.$company_number.'.pdf');
            // $path_a4 = storage_path('app/public/report_resumen_pdf_pos_' . $row->id . '.pdf');
            if (file_exists($path_a4) || $row->state == 1) {
                $has_a4 = true;
            }
            if (!$from_cash) {
            
            

                $incomes = $row->boxes->where('expenses', 0)->where('incomes', 0)->sum(function ($box) {
                    $amount = $box->amount;
                    if ($box->salenote) {
                        if ($box->sale_note_payment_id) {
                            return $amount;
                        } else {
                            return min($box->salenote->total, $amount);
                        }
                    }
                    if ($box->document) {
                        return min($box->document->total, $amount);
                    }
                    return $amount;
                });

                $expense = $row->boxes->where('expenses', 1)->sum('amount');
                $incomes_s = $row->boxes->where('incomes', 1)->sum('amount');
                $final_cash = $row->beginning_balance + $incomes - $expense + $incomes_s;
            }

            $counter = collect($row->counter)->map(function ($total, $value) {
                return [
                    "value" => $value,
                    "total" => $total
                ];
            })->all();

            $user_cash = $row->user;
            $establishment = $user_cash->establishment;
            $tab_single = (bool)$establishment->tab_single;
    

            

            return [
                'is_loading_report' => (bool) $row->is_loading_report,
                'has_ticket' => $has_ticket,
                'has_a4' => $has_a4,
                'path_ticket_url' => $path_ticket_url,
                'from_cash' => (bool) $from_cash,
                'tab_single' => $tab_single,
                'pharmacy_info' => $row->pharmacy_info ? (array) $row->pharmacy_info : null,
                'principal' => (bool) $row->principal,
                'group_code' => $row->group_code,
                'bill_series' => $row->bill_series,
                'id' => $row->id,
                'user_id' => $row->user_id,
                'user' => $row->user->name,
                'date_opening' => $row->date_opening,
                'time_opening' => $row->time_opening,
                'opening' => "{$row->date_opening} {$row->time_opening}",
                'date_closed' => $row->date_closed,
                'time_closed' => $row->time_closed,
                'closed' => "{$row->date_closed} {$row->time_closed}",
                'beginning_balance' => $row->beginning_balance,
                'final_balance' => $final_cash,
                'income' => $row->income,
                'expense' => $row->expense,
                'filename' => $row->filename,
                'state' => (bool) $row->state,
                'state_description' => ($row->state) ? 'Aperturada' : 'Cerrada',
                'reference_number' => $row->reference_number,
                'counter' => $counter,
                'stock_file' => $row->stock_file,
                'active' => $row->active,
            ];
        });
    }
}
