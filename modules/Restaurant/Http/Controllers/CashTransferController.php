<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Events\InsertCashEvent;
use App\Http\Controllers\Tenant\WhatsappController;
use App\Http\Resources\Tenant\CashTransferCollection;
use App\Http\Resources\Tenant\CashTransferCollectionReport;
use App\Http\Resources\Tenant\CashTransferResource;
use App\Models\Tenant\Box;
use App\Models\Tenant\Cash;
use App\Models\Tenant\CashTransfer;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Report\Exports\CashTransferExport;

class CashTransferController extends Controller
{



    public function index()
    {
        $configuration = Configuration::first();
        return view('restaurant::cash_transfer.index', compact('configuration'));
    }
    public function index_report()
    {
        $configuration = Configuration::first();
        return view('restaurant::cash_transfer.index_report', compact('configuration'));
    }
    public function columns_report()
    {
        return [
            'date_of_issue' => 'Fecha',
            'amount' => 'Monto',
        ];
    }
    public function columns()
    {
        return [
            'date_of_issue' => 'Fecha',
            'amount' => 'Monto',
        ];
    }
    public function cashes_principal()
    {
        $cashes = Cash::where('principal', 1)->get()
            ->transform(function ($cash) {
                return [
                    'id' => $cash->id,
                    'description' => $cash->reference_number,
                    'user_name' => $cash->user->name,
                ];
            });

        return compact('cashes');
    }
    public function cashes()
    {
        $cashes = Cash::where('state', 1)->where('principal', 0)->get()
            ->transform(function ($cash) {
                return [
                    'id' => $cash->id,
                    'description' => $cash->reference_number,
                    'user_name' => $cash->user->name,
                ];
            });

        return compact('cashes');
    }
    function get_records_report(Request $request)
    {

        $cash_id = $request->cash_id;
        $column = $request->column;
        $value = $request->value;
        $end_date = $request->end_date;
        $boxes = Box::where(function ($query) use ($cash_id) {
            $query->whereHas('cash_transfer', function ($query) use ($cash_id) {
                $query->where('cash_principal_id', $cash_id);
            });
            // $query->where('cash_id', $cash_id)
            //     ->orWhereHas('cash_transfer', function ($query) use ($cash_id) {
            //         $query->where('cash_principal_id', $cash_id);
            //     });
        });
        if ($column && $value) {
            if ($column == 'date_of_issue') {
                if ($end_date) {
                    $boxes = $boxes->where('date', '>=', $value)->where('date', '<=', $end_date);
                }else{
                    $boxes = $boxes->where('date', $value);
                }

            }else{
                $boxes = $boxes->where($column, 'like', "%{$value}%");
            }
        }
        
        $boxes  = $boxes  ->get()
            ->transform(function ($box) {
                $income = $box->incomes ? $box->amount : 0;
                $expense = $box->expenses ? $box->amount : 0;
                $description = $box->description;
                $user_name = $box->user->name;

                if ($income > 0 && $box->cash_transfer_id) {
                    $income = 0;
                    $expense = $box->amount;
                    $cash_destination = $box->cash;
                    $user_destination = $cash_destination->user->name;
                    $description = "Transferencia a caja $user_destination";
                }
                $is_from_other_cash = strpos($description, 'Ingreso de la caja') !== false;
                if ($is_from_other_cash && $income > 0) {
                    preg_match('/usuario\s(.*?)\s-/', $description, $matches);
                    $user_name = $matches[1];
                    $description = "Cierre de caja";
                }
                return [
                    'id' => $box->id,
                    'date_of_issue' => $box->created_at->format('Y-m-d H:i:s'),
                    'income' => $income,
                    'expense' => $expense,
                    'type' => $description,
                    'user_name' => $user_name
                ];
            });
        return $boxes;
    }
    public function export_report(Request $request){
        $boxes = $this->get_records_report($request);
        $company = Company::first();
        return (new CashTransferExport)
                ->records($boxes)
                ->company($company)
                ->download('Reporte_de_transferencias_' . Carbon::now() . '.xlsx');
    }
    public function records_report(Request $request)
    {
        $boxes = $this->get_records_report($request);
        return [
            'success' => true,
            'data' => $boxes,
        ];
    }
    public function records(Request $request)
    {
        $column = $request->column;
        $value = $request->value;
        if ($column && $value) {
            if ($column == 'date_of_issue') {
                $end_date = $request->end_date;
                if ($end_date) {
                    $boxes = CashTransfer::where($column, '>=', $value)->where($column, '<=', $end_date);
                }
            }
            $boxes = CashTransfer::where($column, 'like', "%{$value}%");
        } else {
            $boxes = CashTransfer::query();
        }


        return new CashTransferCollection($boxes->paginate(config('tenant.items_per_page')));
    }

    public function record($id)
    {
        $box = CashTransfer::findOrFail($id);
        return new CashTransferResource($box);
    }

    public function store()
    {
        try {
            DB::connection('tenant')->beginTransaction();
            $data = request()->all();
            $user_id = auth()->id();
            $soap_type_id = Company::first()->soap_type_id;
            $cash_principal_id = Cash::where('principal', 1)->where('user_id', $user_id)
                ->where('state', 1)
                ->first()->id;
            $date_of_issue = date('Y-m-d');
            $data['cash_principal_id'] = $cash_principal_id;
            $data['date_of_issue'] = $date_of_issue;
            $cash_transfer = CashTransfer::create($data);
            $amount = $cash_transfer->amount;
            $cash_destination_id = $cash_transfer->cash_destination_id;
            $date_of_issue = $cash_transfer->date_of_issue;
            $cash_destination = Cash::findOrFail($cash_destination_id);
            $user_destination = $cash_destination->user;
            $message = "La caja principal a transferido S/. $amount a la caja $cash_destination->reference_number de $user_destination->name";
            if ($cash_transfer->observation) $message .= " con la observación: $cash_transfer->observation";
            $box = new Box;
            $box->cash_id = $cash_destination_id;
            $box->date = $date_of_issue;
            $box->amount = $amount;
            $box->incomes = 1;
            $box->group_id = 1;
            $box->category_id = 1;
            $box->subcategory_id = 1;
            $box->state = 1;
            $box->type = 1;
            $box->soap_type_id = $soap_type_id;
            $box->user_id = auth()->id();
            $box->cash_transfer_id = $cash_transfer->id;
            $box->description = 'Transferencia de caja principal';
            $box->method = 'Efectivo';
            $box->save();
            (new WhatsappController)->sendMessageOne($user_destination->telephone, $message);
            event(new InsertCashEvent($amount, $cash_destination_id));
            DB::connection('tenant')->commit();
            return [
                'success' => true,
                'data' => $cash_transfer,
                'message' => 'Transferencia realizada con éxito'
            ];
        } catch (Exception $e) {
            DB::connection('tenant')->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function available()
    {
        $cash_principal = Cash::where('principal', 1)->where('user_id', auth()->id())
            ->where('state', 1)
            ->first();
        $all_cash = $cash_principal->beginning_balance ?? 0;
        $all_incomes = Box::where('cash_id', $cash_principal->id)->where('incomes', 1)->sum('amount');
        $all_expenses = Box::where('cash_id', $cash_principal->id)->where('expenses', 1)->sum('amount');
        $all_transfer = CashTransfer::where('cash_principal_id', $cash_principal->id)->sum('amount');
        $all_cash += $all_incomes;
        $all_cash -= $all_expenses;
        $all_cash -= $all_transfer;
        return $all_cash;
    }
    public function destroy()
    {
    }
}
