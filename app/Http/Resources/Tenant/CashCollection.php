<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;
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
        return $this->collection->transform(function ($row, $key) {
            // $final_cash = $row->beginning_balance + $row->income - $row->expense;
            // $income = Box::where('cash_id', $row->id)->where('expenses', 0)->sum('amount');
            $incomes = 0;
            Box::where('cash_id', $row->id)->where('expenses', 0)->where('incomes', 0)->chunk(50, function ($rows) use (&$incomes) {
                foreach ($rows as $row) {
                    $amount = $row->amount;
                    if ($row->salenote) {
                        $total = $row->salenote->total;
                        if ($total > $amount) {
                            $incomes += $amount;
                        } else {
                            $incomes += $total;
                        }
                    }
                    if ($row->document) {
                        $total = $row->document->total;
                        if ($total > $amount) {
                            $incomes += $amount;
                        } else {
                            $incomes += $total;
                        }
                    }
                    if (!$row->salenote && !$row->document) {
                        $incomes += $amount;
                    }
                }
            });


            $expense = Box::where('cash_id', $row->id)->where('expenses', 1)->sum('amount');
            $final_cash = $row->beginning_balance + $incomes - $expense;

            // $total_cierre = $transfer + $digital + $sales_detail['cash']['sum'] + $cash->beginning_balance + $incomes_expenses_cash['incomes']['amount'] - $incomes_expenses_cash['expenses']['amount'];
            $counter = [];
            if ($row->counter != null) {
                foreach ($row->counter as $value => $total) {

                    $counter[] = [
                        "value" => $value,
                        "total" => $total
                    ];
                }
            }
            return [
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
                // 'final_cash' => $final_cash,

            ];
        });
    }
}
