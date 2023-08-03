<?php

namespace Modules\LotItem\Http\Controllers;

use App\Imports\LotItemsImport;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;
use Modules\Item\Models\ItemLot;
use Modules\LotItem\Exports\ItemLotExport;
use Modules\LotItem\Http\Resources\LotItemCollection;

class LotItemController extends Controller
{

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $import = new LotItemsImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
    public function deleteDuplicate()
    {
        $duplicateRecords = ItemLot::select('series', 'item_id', 'warehouse_id', DB::raw('count(*) as total'))
            ->groupBy('series', 'item_id', 'warehouse_id')
            ->havingRaw('count(*) > 1')
            ->get();
        $deleted = 0;
        $result = [];
        foreach ($duplicateRecords as $duplicate) {
            $to_delete = $duplicate->total - 1;
            $result[] = [
                'serie' => $duplicate->series,
                'item_id' => $duplicate->item_id,
                'warehouse_id' => $duplicate->warehouse_id,
                'total' => $to_delete,
            ];
            ItemWarehouse::where('id', $duplicate->warehouse_id)
                ->where('item_id', $duplicate->item_id)
                ->update(['stock' => DB::raw('stock - ' . $to_delete)]);
            Item::where('id', $duplicate->item_id)
                ->update(['stock' => DB::raw('stock - ' . $to_delete)]);
            ItemLot::where('series', $duplicate->series)
                ->where('item_id', $duplicate->item_id)
                ->take($to_delete)
                ->delete();

            $deleted += $to_delete;
        }

        return [
            'success' => true,
            'productos eliminados' =>  $deleted,
            'data' => $result
        ];
    }

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
        if ($warehouse_id) {
            $records = $records->where('warehouse_id', $warehouse_id);
        }

        return new LotItemCollection($records->paginate(10));
    }
    public function tables()
    {

        $warehouses = Warehouse::all();
        return compact('warehouses');
    }
    public function pdf(Request $request)
    {
    }
    public function excel(Request $request)
    {
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
            ->download('Reporte_Serie_' . Carbon::now() . '.xlsx');
    }
    public function record($id){
        $record = ItemLot::find($id);
        return compact('record');
    }
    public function delete_record($id){
        $record = ItemLot::find($id);
        $item_id = $record->item_id;
        $warehouse_id = $record->warehouse_id;
        ItemWarehouse::where('item_id', $item_id)->where('warehouse_id', $warehouse_id)->update(['stock' => DB::raw('stock - 1')]);
        Item::where('id', $item_id)->update(['stock' => DB::raw('stock - 1')]);
        $record->delete();
        return [
            'success' => true,
            'message' => 'Registro eliminado'
        ];
    }
    public function update_record(Request $request){
        $id = $request->id;
        $record = ItemLot::find($id);
        $record->update($request->all());
        return [
            'success' => true,
            'message' => 'Registro actualizado'
        ];

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
