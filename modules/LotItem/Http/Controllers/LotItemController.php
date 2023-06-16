<?php

namespace Modules\LotItem\Http\Controllers;

use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Warehouse;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Item\Models\ItemLot;
use Modules\LotItem\Exports\ItemLotExport;
use Modules\LotItem\Http\Resources\LotItemCollection;

class LotItemController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('lotitem::index');
    }
    public function recordsByItem(Request $request)
    {
        $description = $request->description;
        $item_id = $request->item_id;
        $warehouse_id = $request->warehouse_id;

        $records = ItemLot::where('item_id', $item_id)->where('has_sale', 0)->where('state', 'Activo');

        if ($description) {
            $records = $records->where('series', 'like', '%' . $description . '%');
        }
        if($warehouse_id) {
            $records = $records->where('warehouse_id', $warehouse_id);
        }

        return new LotItemCollection($records->paginate(10));
    }
    public function tables()
    {

        $warehouses = Warehouse::all();
        return compact('warehouses');
    }
    public function pdf(Request $request) {}
    public function excel(Request $request) {
        $company = Company::first();
        $establishment = Establishment::first();
        $series = $request->series;
        $item_id = $request->item_id;
        $warehouse_id = $request->warehouse_id;
        $d_start = $request->d_start;
        $d_end = $request->d_end;
        $has_sale = $request->has_sale == "true" ? 1 : 0;
        $active = $request->active == "true" ? 'Activo' : 'Inactivo';
        $records = ItemLot::where('state', $active)->where('has_sale', $has_sale);
        if ($series) {
            $records = $records->where('series', 'like', "%{$series}%");
        }
        if ($item_id) {
            $records = $records->where('item_id', $item_id);
        }
        if ($warehouse_id) {
            $records = $records->where('warehouse_id', $warehouse_id);
        }
        if ($d_start) {
            if ($d_end) {
                $records = $records->whereBetween('date', [$d_start, $d_end]);
            } else {
                $records = $records->whereDate('date', $d_start);
            }
        }
        $records = $records->get();
        return (new ItemLotExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Reporte_Serie_'.Carbon::now().'.xlsx');
    }
    public function records(Request $request)
    {
        $series = $request->series;
        $item_id = $request->item_id;
        $warehouse_id = $request->warehouse_id;
        $d_start = $request->d_start;
        $d_end = $request->d_end;
        $has_sale = $request->has_sale == "true" ? 1 : 0;
        $active = $request->active == "true" ? 'Activo' : 'Inactivo';
        $records = ItemLot::where('state', $active)->where('has_sale', $has_sale);
        if ($series) {
            $records = $records->where('series', 'like', "%{$series}%");
        }
        if ($item_id) {
            $records = $records->where('item_id', $item_id);
        }
        if ($warehouse_id) {
            $records = $records->where('warehouse_id', $warehouse_id);
        }
        if ($d_start) {
            if ($d_end) {
                $records = $records->whereBetween('date', [$d_start, $d_end]);
            } else {
                $records = $records->whereDate('date', $d_start);
            }
        }





        return new LotItemCollection($records->orderBy('series')->paginate(20));
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('lotitem::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('lotitem::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('lotitem::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
