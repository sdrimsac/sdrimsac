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
use Modules\Restaurant\Models\TableType;
use Modules\Restaurant\Models\Zone;

class TableController extends Controller
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
    public function tableTypes()
    {
        $table_types = TableType::all();
        return [
            'success' => true,
            'table_types' => $table_types
        ];
    }
    public function check()

    {
        $total = 0;
        $user = auth()->user();
        $establishment_id = $user->establishment_id;
        $tables = Table::where('status_table_id', 2)
            ->where('number', 'not like', '%caj%')
            ->where('is_room', false)->where('has_billar', false)
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
        return view('restaurant::configuration.tables', compact('configurations'));
    }
    public function columns()
    {
        return [
            'number' => 'Nº Mesa',
        ];
    }
    public function recordsByArea($id)
    {
        $user = auth()->user();
        $establishment_table_id = $user->establishment_table_id;
        $establishment_id = $user->establishment_id;
        $query = Table::where('number', 'not like', '%caj%');

        if ($establishment_table_id) {
            $query->where('establishment_id', $establishment_table_id)
                ->where(function ($q) {
                    $q->where(function ($query) {
                        $query->where('is_room', 1)->where('status_table_id', 2);
                    })
                        ->orWhere(function ($query) {
                            $query->where('is_room', 0);
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
        $zones = Zone::where('active', true)->get();

        return [
            'success' => true,
            'data' => $tables,
            'zones' => $zones
        ];
    }
    public function get_tables()
    {
        ini_set('memory_limit', '2500M');

        $user = auth()->user();
        $establishment_id = $user->establishment_id;
        $this->checkTables($establishment_id);
        $tables = Table::where('is_room', false)->where('has_billar', false)->where('establishment_id', 
        $establishment_id)->orWhereNull('establishment_id')->get();
        $zones = Zone::where('active', true)->get();
        return compact('tables', 'zones');
    }

    public function tables_zones(Request $request)
    {
        $configuration = Configuration::first();
        $zones = Zone::where('active', true)->get();
        return compact(
            'zones',
        );
    }

    public function store_zone(Request $request, $type)
    {
        $model = null;
        switch ($type) {
            case 'zones':
                $model = new Zone;
                break;
            default:
                $model = new Zone;
                break;
        }
        $id = $request->input('id');
        $model = $model->firstOrNew(['id' => $id]);
        $model->fill($request->all());
        $model->save();
        return [
            'success' => true,
            'message' => ($id) ? 'Registro actualizado con éxito' : 'Registro creado con éxito'
        ];
    }

    public function deleteItemZone($type, $id)
    {
        $model = null;
        switch ($type) {
            case 'zones':
                $model = Zone::find($id);
                break;
            default:
                $model = Zone::find($id);
                break;
        }
        $model->delete();
        return [
            'success' => true,
            'message' => 'Registro eliminado con éxito'
        ];
    }

    public function UserTable()
    {
        try {
            $orders = Orden::where('status_orden_id', 1)
                ->with(['orden_items' => function($query) {
                    $query->where('status_orden_id', 1);
                }, 'table', 'orden_items.user'])
                ->whereHas('table', function($query) {
                    $query->where('status_table_id', 2);
                })
                ->get();

            $result = [];
            foreach($orders as $order) {
                foreach($order->orden_items as $item) {
                    $result[] = [
                        'orden_id' => $order->id,
                        'orden_item_id' => $item->id,
                        'table_id' => $order->table_id,
                        'usuario_id' => $item->user_id,
                        'usuario' => $item->user ? $item->user->name : 'Sin usuario',
                        'mesa' => $order->table ? $order->table->number : 'Sin mesa'
                    ];
                }
            }

            return [
                'success' => true,
                'data' => $result
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /* public function get_ordens($id)
    {
        $ordens = Orden::where('table_id', $id)
            ->where('status_orden_id', '<>', 5)
            ->with(['orden_items' => function($query) {
                $query->where('status_orden_id', '<>', 5);
            }])
            ->get();

        return compact('ordens');
    } */
    public function get_ordens($id)
    {
        ini_set('memory_limit', '3500M');
        $ordens = Orden::where('table_id', $id)
            ->where('status_orden_id', '<>', 5)
            ->with(['orden_items' => function($query) {
                $query->where('status_orden_id', '<>', 5);
            }])
            ->get();

        return compact('ordens');
    }
    public function records()
    {
        ini_set('memory_limit', '3500M');
        // $this->checkTables();
        $records = Table::where('is_room', false)->where('has_billar', false);
        return new TableCollection($records->paginate(config('tenant.items_per_page')));
    }
    function checkTables($establishment_id)
    {
        Table::where('status_table_id', 2)
            ->where('is_room', false)
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
    // function checkTables($establishment_id)
    // {

    //     Table::where('status_table_id', 2)
    //         ->where('is_room', false)
    //         ->where('establishment_id', $establishment_id)
    //         ->orWhereNull('establishment_id')
    //         ->chunk(
    //             50,
    //             function ($rows) {
    //                 foreach ($rows as $table) {
    //                     $ordens = Orden::where('table_id', $table->id)
    //                         ->where('status_orden_id', '<>', 4)
    //                         ->where('status_orden_id', '<>', 5)
    //                         ->get();

    //                     $hasActiveOrdersWithItems = false;

    //                     foreach ($ordens as $orden) {
    //                         $ordenItems = OrdenItem::where('orden_id', $orden->id)->get();

    //                         if ($ordenItems->isEmpty()) {
    //                             $orden->status_orden_id = 4;
    //                             $orden->save();
    //                         } else {
    //                             $hasActiveOrdersWithItems = true;
    //                         }
    //                     }

    //                     if (!$hasActiveOrdersWithItems) {
    //                         $table->status_table_id = 1;
    //                         $table->save();
    //                     }
    //                 }
    //             }
    //         );
    // }
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
            ->where('is_room', false)
            ->where('establishment_id', $request->input('establishment_id'))
            ->where('area_id', $request->input('area_id'))
            ->get();
        if (count($tables) > 0) {
            return [
                'success' => false,
                'message' => 'Ya existen mesas con los números ingresados'
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
        $data = $request->all();
        
        // Convert is_cleaning to boolean
        if (isset($data['is_cleaning'])) {
            $data['is_cleaning'] = filter_var($data['is_cleaning'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }
        if (isset($data['has_frigobar'])) {
            $data['has_frigobar'] = filter_var($data['has_frigobar'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }

        $table = Table::firstOrNew(['id' => $id]);
        $table->fill($data);
        $table->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Área actualizada con éxito' : 'Área creada con éxito'
        ];
    }


    public function destroy($id)
    {
        //
    }
}
