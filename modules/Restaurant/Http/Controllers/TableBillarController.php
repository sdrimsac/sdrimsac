<?php

namespace Modules\Restaurant\Http\Controllers;


use App\Models\Tenant\Configuration;
use Illuminate\Http\Request;
use Modules\Restaurant\Models\Area;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Restaurant\Models\Table;
use Modules\Restaurant\Http\Requests\TableRequest;
use Modules\Restaurant\Http\Resources\TableCollection;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use App\Events\MessageEvent;
use Carbon\Carbon;
use Modules\Restaurant\Models\Billar;

class TableBillarController extends Controller
{


    public function disabled(Request $request)
    {
        $user = auth()->user();
        $user_name = $user->name;
        $table_id = $request->input('table_id');
        $table = Table::find($table_id);
        $table->enabled = false;
        $table->save();
        $caja_area_id = Area::getAreaCajaId();
        $message = "El usuario " . $user_name . " Inhabilito " . $table->number;
        event(new MessageEvent($message, $caja_area_id));

        return [
            'success' => true,
            'message' => 'Mesa desactivada con éxito'
        ];
    }
    public function enabled(Request $request)
    {
        $user = auth()->user();
        $user_name = $user->name;
        $table_id = $request->input('table_id');
        $table = Table::find($table_id);
        $table->enabled = true;
        $table->save();
        $caja_area_id = Area::getAreaCajaId();
        $message = "El usuario " . $user_name . " habilito " . $table->number;
        event(new MessageEvent($message, $caja_area_id));

        return [
            'success' => true,
            'message' => 'Mesa activada con éxito'
        ];
    }
    public function check()
    {
        $total = 0;
        $user = auth()->user();
        $establishment_id = $user->establishment_id;
        $tables = Table::where('status_table_id', 2)
            ->where('number', 'not like', '%caj%')
            ->where('has_billar', false)
            ->where(function ($q) use ($establishment_id) {
                $q->where('establishment_id', $establishment_id)->orWhereNull('establishment_id');
            })
            ->get();
        $number_tables = count($tables);

        if ($number_tables == 0) {
            return [
                'success' => false,
            ];
        }
        $ordens_desc = [];
        $number_ordens = 0;
        $orden_items = [];
        foreach ($tables as $table) {
            $ordens = Orden::where('table_id', $table->id)
                ->whereDoesntHave('credit_list')
                ->whereIn('status_orden_id', [1, 2, 3])->get();
            $number_ordens += count($ordens);
            foreach ($ordens as $orden) {
                $ordens_desc[] = $orden->id;
                $items = OrdenItem::where('orden_id', $orden->id)->get()->toArray();
                $orden_items = array_merge($orden_items, $items);

                $total += OrdenItem::where('orden_id', $orden->id)->selectRaw('SUM(price * quantity) as total')->value('total');
            }
        }
        if ($total == 0) {
            return [
                'success' => false,
            ];
        }
        return [
            'items' => $orden_items,
            'ordenes' => $number_ordens,
            'success' => true,
            'total' => $total
        ];
    }
    public function index()
    {
        $configurations = Configuration::first();
        return view('restaurant::configuration.billar', compact('configurations'));
    }
    public function columns()
    {
        return [
            'number' => 'Nº Mesa Billar',
        ];
    }
    public  function desocupied($id)
    {
        $hotel_rent_item = Table::find($id);
        $table = $hotel_rent_item->table;
        $table->status_table_id = 5;
        $table->sendMessageDesocupied();
        $table->save();
        if ($hotel_rent_item && $hotel_rent_item->is_month_rent) {
            $hotel_rent_item->checkout_date = Carbon::now()->format('Y-m-d');
            $hotel_rent_item->checkout_time = Carbon::now()->format('H:i:s');
            $hotel_rent_item->payment_status = "Pagado";
            $hotel_rent_item->save();
        }
        $table->save();
        return [
            'success' => true,
            'message' => 'Habitación desocupada'
        ];
    }
    public function recordsByArea($id)
    {
        $user = auth()->user();
        $establishment_table_id = $user->establishment_table_id;
        $establishment_id = $user->establishment_id;
        $query = Table::where('number', 'not like', '%caj%');

        if ($establishment_table_id) {
            // $configuration = Configuration::first();
            $query->where('establishment_id', $establishment_table_id)
                ->where(function ($q) {
                    $q->where(function ($query) {
                        $query->where('has_billar', 1)->where('status_table_id', 2);
                    })
                        ->orWhere(function ($query) {
                            $query->where('has_billar', 0);
                        });
                });
        } else {
            $query->where('area_id', $id)
                ->where(function ($q) use ($establishment_id) {
                    $q->where('establishment_id', $establishment_id)
                        ->orWhereNull('establishment_id');
                });
        }

        $tables = new TableCollection($query
            ->get());

        return [
            'success' => true,
            'data' => $tables
        ];
    }
    public function get_tables()
    {
        ini_set('memory_limit', '2500M');

        $user = auth()->user();
        $establishment_id = $user->establishment_id;
        $this->checkTables($establishment_id);
        $tables = Table::where('has_billar', true)->where('establishment_id', $establishment_id)->orWhereNull('establishment_id')
            ->get();
        return compact('tables');
    }
    public function get_ordens($id)
    {
        $ordens = Orden::where('table_id', $id)->where('status_orden_id', '<>', 4)
            ->where('status_orden_id', '<>', 5)
            ->get();

        return compact('ordens');
    }
    public function records(Request $request)
    {
        $column = $request->input('column');
        $value = $request->input('value');
        // $this->checkReserves();
        $records = Table::where('has_billar', true);

        if ($column && $value) {
            $records = $records->where($column, 'like', "%{$value}%");
        }

        return new TableCollection($records->paginate(config('tenant.items_per_page')));

        // return [
        //     'success' => true,
        //     'data' => $tables
        // ];
    }
    function checkTables($establishment_id)
    {
        Table::where('status_table_id', 2)
            ->where('has_billar', false)
            ->where(function ($query) use ($establishment_id) {
                $query->where('establishment_id', $establishment_id)
                    ->orWhereNull('establishment_id');
            })
            ->chunk(
                50,
                function ($tables) {
                    $tableIds = $tables->pluck('id');

                    $ordens = Orden::whereIn('table_id', $tableIds)
                        ->whereNotIn('status_orden_id', [4, 5])
                        ->get();

                    $ordenIds = $ordens->pluck('id');
                    $ordenItems = OrdenItem::whereIn('orden_id', $ordenIds)->get();

                    $ordenItemsGrouped = $ordenItems->groupBy('orden_id');

                    foreach ($tables as $table) {
                        $tableOrdens = $ordens->where('table_id', $table->id);
                        $hasActiveOrdersWithItems = false;

                        foreach ($tableOrdens as $orden) {
                            if ($ordenItemsGrouped->has($orden->id)) {
                                $hasActiveOrdersWithItems = true;
                            } else {
                                $orden->status_orden_id = 4;
                                $orden->save();
                            }
                        }

                        if (!$hasActiveOrdersWithItems) {
                            $table->status_table_id = 1;
                            $table->save();
                        }
                    }
                }
            );
    }
    public function record($id)
    {
        $table = Table::find($id);

        return [
            'success' => true,
            'data' => $table
        ];
    }
    public function store_massive(Request $request)
    {
        $numbers = $request->input('numbers');
        //check in Table if exist the number
        $tables = Table::whereIn('number', $numbers)
            ->where('has_billar', true)
            ->where('establishment_id', $request->input('establishment_id'))
            ->where('area_id', $request->input('area_id'))
            ->get();
        if (count($tables) > 0) {
            return [
                'success' => false,
                'message' => 'Ya existen mesas billar con los números ingresados'
            ];
        }
        foreach ($numbers as $number) {
            $table = new Table();
            $table->number = $number;
            $table->area_id = $request->input('area_id');
            $table->status_table_id = $request->input('status_table_id');
            $table->establishment_id = $request->input('establishment_id');
            $table->save();
        }
        return [
            'success' => true,
            'message' => 'Mesas creadas con éxito'
        ];
    }

    public function store(TableRequest $request)
    {
        $id = $request->input('id');
        $table = Table::firstOrNew(['id' => $id]);
        $table->fill($request->all());
        $table->has_billar = true;
        $table->save();
        return [
            'success' => true,
            'message' => ($id) ? 'Mesa Billar actualizada con éxito' : 'Mesa Billar creada con éxito'
        ];
    }
    /* public function store2(TableRequest $request)
    {
        $request->validate([
            'reference' => 'required|string',
        ]);

        $table_id = auth()->user()->table_id;

        $date_start = Carbon::now()->toDateString();

        $time_start = Carbon::now()->toTimeString();

        $minutes = 0;

        $casino = Billar::create([
            'table_id' => $table_id,
            'date_start' => $date_start,  
            'time_start' => $time_start,  
            'minutes' => $minutes,
            'reference' => $request->reference,
        ]);

        return response()->json([
            'message' => 'Datos guardados exitosamente',
            'data' => $casino,
        ], 201);
    } */
    public function destroy($id)
    {
        //
    }
}
