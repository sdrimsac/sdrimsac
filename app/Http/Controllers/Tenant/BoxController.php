<?php

namespace App\Http\Controllers\Tenant;

use Exception;
use Carbon\Carbon;
use App\Models\Tenant\Box;
use App\Models\Tenant\Cash;
use App\Models\Tenant\User;
use App\Models\Tenant\Group;
use App\Models\Tenant\Company;
use App\Models\Tenant\Category;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\Subcategory;
use Illuminate\Http\Request;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\DocumentPayment;
use App\Models\Tenant\SaleNotePayment;
use App\Http\Requests\Tenant\BoxRequest;
use App\Models\Tenant\PaymentMethodType;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Tenant\BoxResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\BoxCollection;
use Modules\Report\Exports\BoxesExport;
use Modules\Report\Exports\BoxesResumenExport;
use App\Http\Resources\Tenant\PaymentMethodTypeCollection;
use App\Models\Tenant\CreditList;
use Modules\Dashboard\Helpers\DashboardSalePurchase;
use App\Exports\BoxesExportCashClosed;
use App\Exports\GlobalBoxExport;
use Modules\Restaurant\Models\Food;

class BoxController extends Controller
{
    public function index()                              //Llama al template Blade de laravel
    {
        return view('tenant.boxes.index');
    }
    public function incomebox()                              //Llama al template Blade de laravel
    {
        return view('tenant.incomebox.index');
    }


    public function columns() //buscador x campo
    {
        return [
            'id'                => 'Código',
            'group_id'          => 'Grupo',
            'category_id'       => 'Categorias',
            'subcategory_id'    => 'Subcategorias',
            'date'              => 'Fecha',
            'description'       => 'Descripcion - Detalle',
        ];
    }
    public function date_start($id)
    {
        $cash = Cash::where('user_id', $id)->get()->last();

        return $cash->date_opening;
    }
    public function tables()
    {
        $gruop = Group::all();
        $category = Category::all();
        $subcategory = Subcategory::all();
        $company = Company::first();
        $methods = PaymentMethodType::all();
        return compact('gruop', 'category', 'subcategory', 'company', 'methods');
    }
    public function resumen_boxes(Request $request)
    {
        $records = PaymentMethodType::all();
        return new PaymentMethodTypeCollection($records);
    }
    public function reports_categoria_type(Request $request)
    {

        $group_id = $request['group_id'];
        $category_id = $request['category_id'];
        $subcategory_id = $request['subcategory_id'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $user_id = $request['user_id'];
        $d_start = null;
        $d_end = null;
        $array_data = [
            "ingresos" => [],
            "egresos" => []
        ];
        $user = User::find($user_id);

        $categories = Category::all();
        $subcategories = Subcategory::all();
        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        $data1 = Box::where('method', 'Efectivo')->whereBetween('date', [$d_start, $d_end])->orderBy('date', 'asc')->orderBy('type', 'asc')->get();
        $data_by_group = $data1->groupBy('group_id');
        $records = [];
        foreach ($data_by_group as $group_id => $records_by_group) {
            $data_by_category = $records_by_group->groupBy('category_id');
            $categories = [];
            $group_name = '';
            foreach ($data_by_category as $category_id => $records_by_category) {
                //dd('1');
                $data_by_subcategory = $records_by_category->groupBy('subcategory_id');
                //dd($records_by_category->groupBy('subcategory_id'));
                $subcategories = [];
                $category_name = '';
                foreach ($data_by_subcategory as $subcategory_id => $rows) {
                    $rows_data = [];
                    $subcategory_name = '';
                    foreach ($rows as $row) {
                        $group_name = $row->groups->group;
                        $category_name = $row->categories->category;
                        $subcategory_name = $row->subcategories->subcategory;
                        if ($row->sale_note_id != null) {
                            $customer = $row->salenote->customer->name;
                        } else {
                            $customer = "";
                        }
                        if ($row->document_id != null) {
                            $customer = $row->document->customer->name;
                        } else {
                            $customer = "";
                        }
                        $rows_data[] = [
                            'id' => $row->id,
                            'description' => $row->description,
                            'type' => $row->type,
                            'sale_note_id' => $row->sale_note_id,
                            'document_id' => $row->document_id,
                            'method' => $row->method,
                            'customer_salenote' => ($row->sale_note_id == null) ? "-" : $row->salenote->customer->name,
                            'customer_document' => ($row->document_id == null) ? "-" : $row->document->customer->name,
                            'date' => Carbon::parse($row->date)->format('d-m-Y') . " " . Carbon::parse($row->created_at)->format('H:m:s'),
                            'monto' => $row->amount,
                            'user' => $row->user->name
                        ];
                    }
                    $subcategories[] = [
                        'subcategory_id' => $subcategory_id,
                        'subcategory_name' => $subcategory_name,
                        'rows' => $rows_data
                    ];
                }
                $categories[] = [
                    'category_id' => $category_id,
                    'category_name' => $category_name,
                    'subcategories' => $subcategories
                ];
            }
            $records[] = [
                'group_id' => $group_id,
                'group_name' => $group_name,
                'categories' => $categories
            ];
        }


        //$result=$data1->groupBy('group_id')->groupBy('category_id')->groupBy('subcategory_id')[''];
        //return $result;
        //dd($result[0]);
        $pdf = PDF::loadView('report::boxes.report_category', compact("user", "records", "company", "establishment", "date_start", "date_end"))->setPaper('a4', 'landscape');
        return $pdf->stream('Reporte_Ventas_' . date('YmdHis') . '.pdf');
    }

    public function reports_resumen_type(Request $request)
    {
        $date_close = $request['date_close'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $user_id = $request['user_id'];
        $type_box = $request['type_box'];
        $request->request->add(['establishment_id' => auth()->user()->establishment_id]);
        $request->request->add(['enabled_move_item' => false]);
        $request->request->add(['enabled_transaction_customer' => false]);
        $d_start = null;
        $d_end = null;
        $user = User::find($user_id);
        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }

        $cash = Cash::where('date_closed', $date_close)->where('user_id', $user_id)->get()->last();

        $data1 = Box::where('type', '1')->where('method', 'Efectivo')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');
        $data2 = Box::where('type', '2')->whereBetween('date', [$d_start, $d_end])->where('expenses', 1)->where('state', 0)->where('user_id', $user_id)->OrderBy('date', 'asc');
        $data3 = Box::where('type', '1')->where('method', 'Transferencia')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');
        $data4 = Box::where('type', '1')->where('method', 'Deposito Bancario')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');
        $data5 = Box::where('type', '1')->where('method', 'Tarjeta')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');
        $data6 = Box::where('type', '1')->where('method', 'Yape')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');
        $data7 = Box::where('type', '1')->where('method', 'PLIN')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');
        $data8 = Box::where('type', '1')->where('method', 'CULQUI')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');
        $data9 = Box::where('type', '1')->where('method', 'BBVA')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');
        $data10 = Box::where('type', '1')->where('method', 'BCP')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');
        $data11 = Box::where('type', '1')->where('method', 'BCO NACION')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');
        $data12 = Box::where('type', '1')->where('method', 'Scotiabank')->where('expenses', 0)->where('incomes', 0)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');
        $dataingresos_all = Box::where('type', '1')->where('method', 'Efectivo')->where('incomes', 1)->where('state', 0)->whereBetween('date', [$d_start, $d_end])->where('user_id', $user_id)->OrderBy('date', 'asc');

        $row_ingresos = $data1->get();

        // if ($request->type_box == "1") {
        $data_ingresos = $data1->sum('amount');

        $data_ingresos_all = $dataingresos_all->sum('amount');

        $row_egresos = $data2->sum('amount');

        $row_transferencia = $data3->sum('amount');

        $row_depositos = $data4->sum('amount');

        $row_tarjetas = $data5->sum('amount');

        $row_yape = $data6->sum('amount');

        $row_plin = $data7->sum('amount');

        $row_culqui = $data8->sum('amount');

        $row_bbva = $data9->sum('amount');

        $row_bcp = $data10->sum('amount');

        $row_nacion = $data11->sum('amount');

        $row_scotiabank = $data12->sum('amount');

        if ($request->type_box == "2") {
            if ($row_egresos != null || $row_egresos != 0.0) {
                $data_egresos = $data2->sum('amount');
            } else {
                $data_egresos = "0.00";
            }
        } else {
            $data_egresos = "0.00";
        }
        if ($request->type_box == null) {
            if ($row_egresos != null || $row_egresos != 0.0) {
                $data_egresos = $data2->sum('amount');
            } else {
                $data_egresos = "0.00";
            }
        }

        $row_cierre = Box::where('state', '0')->get()->last();
        $row_apertura = Cash::orderBy('state')->get()->last();
        $fecha_apertura = $row_apertura->date_opening . " " . $row_apertura->created_at->format('h:m:s');
        $fecha_cierre = '';
        if ($row_cierre && $row_apertura) {

            $fecha_cierre = $row_cierre->close . " " . $row_cierre->created_at->format('h:m:s');
        }

        if ($row_transferencia != null || $row_transferencia != 0.0) {
            $transferencias = $data3->sum('amount');
        } else {
            $transferencias = "0.00";
        }

        if ($row_depositos != null) {
            $depositos = $row_depositos->depositos;
        } else {
            $depositos = "0.00";
        }

        if ($row_tarjetas != null) {
            $tarjetas = $row_tarjetas;
        } else {
            $tarjetas = "0.00";
        }

        if ($row_yape != null) {
            $yape = $row_yape;
        } else {
            $yape = "0.00";
        }
        if ($row_plin != null) {
            $plin = $row_plin;
        } else {
            $plin = "0.00";
        }
        if ($row_culqui != null) {
            $culqui = $row_culqui;
        } else {
            $culqui = "0.00";
        }

        if ($row_bbva != null) {
            $bbva = $row_bbva;
        } else {
            $bbva = "0.00";
        }
        if ($row_bcp != null) {
            $bcp = $row_bcp;
        } else {
            $bcp = "0.00";
        }
        if ($row_nacion != null) {
            $nacion = $row_nacion;
        } else {
            $nacion = "0.00";
        }
        if ($row_scotiabank != null) {
            $scotiabank = $row_scotiabank;
        } else {
            $scotiabank = "0.00";
        }
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;
        $items = (new DashboardSalePurchase())->data($request->all());
        //dd($items);
        $saldo = 0;
        if ($request['type'] == "pdf") {
            $pdf = PDF::loadView('report::boxes.report_resumen_pdf', compact("type_box", "bbva", "bcp", "scotiabank", "nacion", 'yape', 'culqui', "plin", "items", "cash", "data_ingresos_all", "data_ingresos",  "data_egresos", "establishment", "date_start", 'items', "date_end", "company", "fecha_apertura", "fecha_cierre", "transferencias", "depositos", "tarjetas", "user"))->setPaper('a4', 'landscape');
            //$pdf = PDF::loadView('report::boxes.report_resumen_pdf', compact("type_box",'yape',"plin","items","cash","data_ingresos_all", "data_ingresos","yape","plin", "data_egresos", "establishment", "date_start",'items', "date_end", "company", "fecha_apertura", "fecha_cierre", "transferencias", "depositos", "tarjetas", "user"))->setPaper('a4', 'landscape');
            return $pdf->stream('Reporte_Arqueo_Caja_' . date('YmdHis') . '.pdf');
        } else if ($request['type'] == "excel") {

            return (new BoxesResumenExport)
                ->records($data_ingresos)
                ->records2($data_egresos)
                ->records3($transferencias)
                ->records4($depositos)
                ->records4($tarjetas)
                ->items($items)
                ->company($company)
                ->user($user)
                ->establishment($establishment)
                ->download('Reporte_arqueo_resumen_' . Carbon::now() . '.xlsx');
        }
    }
    public function reports_type(Request $request)
    {

        $group_id = $request['group_id'];
        $category_id = $request['category_id'];
        $subcategory_id = $request['subcategory_id'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $user_id = $request['user_id'];
        $user = User::find($user_id);
        $d_start = null;
        $d_end = null;
        $type_box = $request['type_box'];

        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start . '-01')->endOfMonth()->format('Y-m-d');

                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }
        // Box::whereBetween('date', [$date_start, $date_end])
        //->OrderBy('sale_note_id')->OrderBy('document_id')
        //latest
        $data = Box::whereBetween('date', [$d_start, $d_end])->latest();
        //  dd($data);
        if ($user_id) {
            $data =  $data->where('user_id', $user_id);
        }
        if ($type_box) {
            $data =  $data->where('type', $type_box);
        }

        $boxes_report = new BoxCollection($data->get());
        //   return $boxes_report;
        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;

        $saldo = 0;
        if ($request['type'] == "pdf") {
            $pdf = PDF::loadView('report::boxes.report_pdf', compact("user", "boxes_report", "establishment", "date_start", "date_end", "company", "type_box"))->setPaper('a4', 'landscape');
            return $pdf->stream('Reporte_Ventas_' . date('YmdHis') . '.pdf');
        } else if ($request['type'] == "excel") {

            return (new BoxesExport)
                ->records($data->get())
                ->company($company)
                ->type_box($type_box)
                ->establishment($establishment)
                ->download('Reporte_arqueo_caja_' . Carbon::now() . '.xlsx');
        }
    }
    public function reports_bancario_type(Request $request)
    {
        $group_id = $request['group_id'];
        $category_id = $request['category_id'];
        $subcategory_id = $request['subcategory_id'];
        $period = $request['period'];
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        $month_start = $request['month_start'];
        $month_end = $request['month_end'];
        $user_id = $request['user_id'];
        $type_box = $request['type_box'];
        $d_start = null;
        $d_end = null;

        switch ($period) {
            case 'month':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_start . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'between_months':
                $d_start = Carbon::parse($month_start . '-01')->format('Y-m-d');
                $d_end = Carbon::parse($month_end . '-01')->endOfMonth()->format('Y-m-d');
                break;
            case 'date':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
            case 'between_dates':
                $d_start = $date_start;
                $d_end = $date_end;
                break;
        }

        $data = Box::whereBetween('date', [$d_start, $d_end])->where('amount', '>', "0.00")->latest();

        $data = $data->where('method', '!=', "Efectivo")->Where('method', '!=', 'Credito')->latest();

        if ($user_id) {
            $data =  $data->where('user_id', $user_id);
        }
        $boxes_report = new BoxCollection($data->get());

        $company = Company::first();
        $establishment = ($request->establishment_id) ? Establishment::findOrFail($request->establishment_id) : auth()->user()->establishment;

        $saldo = 0;
        if ($request['type'] == "pdf") {
            $pdf = PDF::loadView('report::boxes.report_bancario_pdf', compact("boxes_report", "establishment", "company", "date_start", "date_end"))->setPaper('a4', 'landscape');
            return $pdf->stream('Reporte_Ventas_' . date('YmdHis') . '.pdf');
        } else if ($request['type'] == "excel") {

            return (new BoxesExport)
                ->records($data->get())
                ->company($company)
                ->type_box($type_box)
                ->establishment($establishment)
                ->download('Reporte_arqueo_caja_' . Carbon::now() . '.xlsx');
        }
    }
    public function reports_results(Request $request)
    {

        $date_close = $request['date_close'];
        $user_id = $request['user_id'];
        //------------------------------------------------------------------------------------------------------------
        if ($date_close) {
            $data = Box::whereHas('cash', function ($q) use ($date_close) {
                $q->where('date_closed', $date_close);
            });
        } else {
            $data  = Box::query();
        }



        $data->OrderBy("date", "desc")->OrderBy("type", "desc")->latest();

        if ($user_id) {
            $data =  $data->where('user_id', $user_id);
        }

        return new BoxCollection($data->paginate(config('tenant.items_per_page')));
    }
    public function reports_results_excel(Request $request)
    {
        $date_close = $request['date_close'];
        $user_id = $request['user_id'];
        $user = User::find($user_id);
        $user = ($user) ? $user : auth()->user();
        $establishment = Establishment::findOrFail($user->establishment_id);
        $company = Company::first();
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        //------------------------------------------------------------------------------------------------------------
        if ($date_close) {
            $data = Box::whereHas('cash', function ($q) use ($date_close) {
                $q->where('date_closed', $date_close);
            });
        } else {
            $data  = Box::query();
        }

        $data->with(['cash'])
            ->OrderBy("date", "desc")->OrderBy("type", "desc")->latest();

        if ($user_id) {
            $data =  $data->where('user_id', $user_id);
        }
        $type_box  = 1;
        $boxes_report = $data->get();

        return (new BoxesExportCashClosed)
            ->records($boxes_report)
            ->type_box($type_box)
            ->company($company)
            ->download('Lista_de_cajas _cerradas' . Carbon::now() . '.xlsx');
    }
    public function reports_results_pdf(Request $request)
    {

        $date_close = $request['date_close'];
        $user_id = $request['user_id'];
        $user = User::find($user_id);
        $user = ($user) ? $user : auth()->user();
        $establishment = Establishment::findOrFail($user->establishment_id);
        $company = Company::first();
        $date_start = $request['date_start'];
        $date_end = $request['date_end'];
        //------------------------------------------------------------------------------------------------------------
        if ($date_close) {
            $data = Box::whereHas('cash', function ($q) use ($date_close) {
                $q->where('date_closed', $date_close);
            });
        } else {
            $data  = Box::query();
        }

        $data->with(['cash'])
            ->OrderBy("date", "desc")->OrderBy("type", "desc")->latest();

        if ($user_id) {
            $data =  $data->where('user_id', $user_id);
        }
        $type_box  = 1;
        $boxes_report = $data->get();

        //dump the first element of the array
        $pdf = PDF::loadView('report::boxes.report_pdf', compact("type_box", "user", "boxes_report", "establishment", "company", "date_start", "date_end"))->setPaper('a4', 'landscape');
        return $pdf->stream('Reporte_Detalle_' . date('YmdHis') . '.pdf');
    }
    public function reports(Request $request)
    {
        return view('tenant.boxes.reports.index');
    }
    public function global_records(Request $request)
    {
        $date_open = $request['date_open'];
        $all_data = $this->global_get_records($date_open);
        $records = $all_data['records'];
        $columns = $all_data['columns'];
        return [
            'success' => true,
            'data' => $records,
            'columns' => $columns
        ];
    }
    // function global_get_records($date_open)
    // {
    //     $cashes = Cash::select(['id', 'user_id', 'turn_id'])->where('date_opening', $date_open);
    //     //solo sacar user_id de cashes
    //     $found = $cashes->get()->transform(function ($row) {
    //         return [
    //             'id' => $row->id,
    //             'user_id' => $row->user_id,
    //             'turn_id' => $row->turn_id,
    //         ];
    //     });
    //     $establishment = Establishment::select(['id', 'description'])->get();
    //     $records_by_establishment = [];
    //     $payments = ["Efectivo", "Culqui", "Yape", "PLIN", "TARJETA: IZYPAY",  "TARJETA:NIUBIZ", "TARJETA: OPENPAY"];
    //     foreach ($establishment as $key => $value) {

    //         $users_id = User::where('establishment_id', $value['id'])->pluck('id');

    //         $cashes_establishment = $cashes->whereIn("user_id",$users_id)
    //             ->with('turn')
    //             ->get()
    //             ->transform(function ($row) use ($payments) {
    //                 $allMethods = $row->boxes->pluck('method')->unique();
    //                 $unmatchedMethods = $allMethods->diff($payments);

    //                 $records = [];
    //                 foreach ($payments as $key => $value) {
    //                     $record = $row->boxes->where('method', $value)->sum('amount');
    //                     $records[] = [
    //                         'method' => $value,
    //                         'amount' => $record
    //                     ];
    //                 }
    //                 foreach ($unmatchedMethods as $key => $value) {
    //                     $record = $row->boxes->where('method', $value)->sum('amount');
    //                     $records[] = [
    //                         'method' => $value,
    //                         'amount' => $record
    //                     ];
    //                 }
    //                 return [
    //                     'id' => $row->id,
    //                     'turn' => optional($row->turn)->turn_desc ?? "MAÑANA",
    //                     'turn_id' => optional($row->turn)->id ?? 1,
    //                     'records' => $records
    //                 ];
    //             });
    //         $records_by_establishment[] = [
    //             'cash' => $cashes_establishment,
    //             'establishment_id' => $value['id'],
    //             'establishment_description' => $value['description'],
    //         ];
    //     }

    //     return (array)$records_by_establishment;
    // }

    public function global_export(Request $request){

        $type = $request->type;
        $date_open = $request->date_open;
        $all_info = $this->global_get_records($date_open);
        $records = $all_info['records'];
        $columns = $all_info['columns'];
        $company = Company::first();
        if($type == 'pdf'){
            $pdf = PDF::loadView('tenant.reports.box_global.report_pdf', compact("records", "company", "date_open","columns"))->setPaper('a4', 'landscape');
            return $pdf->stream('Reporte_global_caja_' . date('YmdHis') . '.pdf');
        }else{
                
                return (new GlobalBoxExport)
                    ->records($records)
                    ->company($company)
                    ->columns($columns)
                    ->download('Reporte_global_caja_' . Carbon::now() . '.xlsx');
        }

    }
    function global_get_records($date_open)
    {
        $establishments = Establishment::select(['id', 'description'])->get();
        $payments = ["Efectivo", "Culqui", "Yape", "PLIN", "TARJETA: IZYPAY", "TARJETA:NIUBIZ", "TARJETA: OPENPAY"];
        $columns = [];
        $diff_payments = [];
        $records_by_establishment = [];

        foreach ($establishments as $establishment) {
            $users_id = User::where('establishment_id', $establishment->id)->pluck('id');

            $cashes_establishment = Cash::select(['id', 'user_id', 'turn_id'])
                ->where('date_opening', $date_open)
                ->whereIn('user_id', $users_id)
                ->with('turn')
                ->get()
                ->map(function ($row) use ($payments, &$diff_payments) {
                    $allMethods = $row->boxes->pluck('method')->unique();
                    $records = [];

                    foreach ($payments as $value) {
                        if ($value != "Efectivo") {
                            $record = $row->boxes->where('method', $value)->sum('amount');
                            $records[] = [
                                'method' => $value,
                                'amount' => $record
                            ];
                        } else {

                            $total = 0;
                            $row->boxes->where('type', '1')->where('method', 'Efectivo')->where('expenses', 0)->where('incomes', 0)->where('state', 0)
                                ->each(function ($box)  use (&$total) {
                                    if ($box->sale_note_id) {
                                        $sale_note = $box->salenote;
                                        if ($sale_note->total > $box->amount) {
                                            $total += $box->amount;
                                        } else {
                                            $total += $sale_note->total;
                                        }
                                        if ($sale_note->total_discount) {
                                            $total += $sale_note->total_discount;
                                        }
                                    }
                                    if ($box->document_id) {
                                        $document = $box->document;
                                        if ($document->total > $box->amount) {
                                            $total += $box->amount;
                                        } else {
                                            $total += $document->total;
                                        }
                                        if ($document->total_discount) {
                                            $total += $document->total_discount;
                                        }
                                    }
                                });
                         
                            $records[] = [
                                'method' => $value,
                                'amount' => $total
                            ];
                        }
                    }
                    $diff = $allMethods->diff($payments)->values()->all();
                    if (count($diff) > 0) {
                        $diff_payments = array_merge($diff_payments, $diff);
                    }
                    foreach ($diff as $key => $value) {
                        $record = $row->boxes->where('method', $value)->sum('amount');
                        $records[] = [
                            'method' => $value,
                            'amount' => $record
                        ];
                    }

                    return [
                        'id' => $row->id,
                        'turn' => optional($row->turn)->turn_desc ?? "MAÑANA",
                        'turn_id' => optional($row->turn)->id ?? 1,
                        'records' => $records
                    ];
                });

            $records_by_establishment[] = [
                'cash' => $cashes_establishment,
                'establishment_id' => $establishment->id,
                'establishment_description' => $establishment->description,
            ];
        }
        $columns = array_merge($payments, array_unique($diff_payments));

        return ["records" => $records_by_establishment, "columns" => $columns];
    }

    public function global_tables(Request $request)
    {
    }
    public function global_index(Request $request)
    {
        return view('tenant.boxes.reports.global');
    }
    public function records(Request $request)
    {
        $records = Box::where($request->column, 'like', "%{$request->value}%")->where('type', '2')->orderBy('id', 'desc'); //para ordenar

        return new BoxCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function records2(Request $request)
    {
        $records = Box::where($request->column, 'like', "%{$request->value}%")->where('type', '1')->orderBy('id', 'desc'); //para ordenar

        return new BoxCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function record($id) //Selecccionar un Registro
    {
        $record = new BoxResource(Box::findOrFail($id));
        return $record;
    }

    public function store(BoxRequest $request)
    { //Guardar y Actualizar
        $id          = $request->input('id');
        $box         = Box::firstOrNew(['id' => $id]);
        $box->fill($request->all());
        $box->date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $box->user_id = auth()->user()->id;
        $box->save();
        return [
            'success' => true,
            'message' => ($id) ? 'Actualizado con éxito' : 'Registrado con éxito',
            'data'    => $box
        ];
    }

    public function destroy($id) //Eliminar
    {
        $box = Box::findOrFail($id);
        $box->delete();
        return [
            'success' => true,
            'message' => 'Eliminado con éxito'
        ];
    }
}
