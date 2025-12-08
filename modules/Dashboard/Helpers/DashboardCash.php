<?php

namespace Modules\Dashboard\Helpers;

use App\Models\Tenant\Box;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Document;
use App\Models\Tenant\Mozo;
use App\Models\Tenant\Purchase;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Restobar\Models\Area;
use Modules\Restobar\Models\Food;
use Modules\Restobar\Models\Orden;
use Modules\Restobar\Models\OrdenItem;

class DashboardCash
{
    public function getActiveCash($user_id = null)
    {
        $authenticated_user = auth()->user();

        // Si el usuario autenticado es admin o superadmin, buscar la última caja de cualquier seller
        if ($authenticated_user && in_array($authenticated_user->type, ['admin', 'superadmin'])) {
            // Obtener todos los IDs de usuarios tipo seller
            $seller_ids = User::where('type', 'seller')->pluck('id');

            if ($seller_ids->isEmpty()) {
                return null;
            }

            // Primero buscar una caja abierta de cualquier seller (state = 1 o true)
            $cash = Cash::whereIn('user_id', $seller_ids)
                ->where(function ($query) {
                    $query->where('state', 1)
                        ->orWhere('state', true);
                })
                ->orderBy('date_opening', 'desc')
                ->first();

            // Si no hay caja abierta, buscar la última caja cerrada de cualquier seller
            if (!$cash) {
                $cash = Cash::whereIn('user_id', $seller_ids)
                    ->where(function ($query) {
                        $query->where('state', 0)
                            ->orWhere('state', false);
                    })
                    ->orderBy('id', 'desc') // Usar ID en lugar de date_closed por si es null
                    ->first();
            }

            // Si aún no hay caja, buscar la última sin importar el estado
            if (!$cash) {
                $cash = Cash::whereIn('user_id', $seller_ids)
                    ->orderBy('id', 'desc')
                    ->first();
            }

            return $cash;
        }

        // Para usuarios no admin, verificar que sea seller y buscar solo sus cajas
        $user = User::find($user_id);
        if (!$user || $user->type !== 'seller') {
            return null;
        }

        // Primero buscar una caja abierta (state = 1 o true)
        $cash = Cash::where('user_id', $user_id)
            ->where(function ($query) {
                $query->where('state', 1)
                    ->orWhere('state', true);
            })
            ->orderBy('date_opening', 'desc')
            ->first();

        // Si no hay caja abierta, buscar la última caja cerrada
        if (!$cash) {
            $cash = Cash::where('user_id', $user_id)
                ->where(function ($query) {
                    $query->where('state', 0)
                        ->orWhere('state', false);
                })
                ->orderBy('id', 'desc') // Usar ID en lugar de date_closed por si es null
                ->first();
        }

        // Si aún no hay caja, buscar la última sin importar el estado
        if (!$cash) {
            $cash = Cash::where('user_id', $user_id)
                ->orderBy('id', 'desc')
                ->first();
        }

        return $cash;
    }

    public function data($request)
    {
        $cash_id = $request->cash_id;
        $cash = null;
        $authenticated_user = auth()->user();

        // Si no se proporciona cash_id, buscar automáticamente
        if (!$cash_id) {
            $cash = $this->getActiveCash();

            if (!$cash) {
                return [
                    'success' => false,
                    'message' => 'No se encontró ninguna caja para este usuario'
                ];
            }

            $cash_id = $cash->id;
        } else {
            // Si se proporciona cash_id, buscar esa caja específica
            $cash = Cash::find($cash_id);

            if (!$cash) {
                return [
                    'success' => false,
                    'message' => 'Caja no encontrada'
                ];
            }

            // Verificar permisos: admin o superadmin pueden ver todas las cajas, seller solo las suyas
            if (!in_array($authenticated_user->type, ['admin', 'superadmin']) && $cash->user_id !== auth()->id()) {
                return [
                    'success' => false,
                    'message' => 'No tiene permisos para ver esta caja'
                ];
            }
        }

        return [
            'success' => true,
            'data' => [
                'metrics' => $this->getMetrics($cash_id),
                'sales_trend' => $this->getSalesTrendByHour($cash_id),
                'waiter_performance' => $this->getWaiterPerformance($cash_id),
                'top_products' => $this->getTopProductsByCategory($cash_id),
                'cash_info' => $this->getCashInfo($cash),
            ]
        ];
    }

    private function getMetrics($cash_id)
    {
        // FILTRAR SOLO VENTAS DE ESTA CAJA ESPECÍFICA
        // State = 1 significa que es una venta registrada
        $sales = Box::where('cash_id', $cash_id)
            ->where('expenses', 0)
            ->where('incomes', 0)
            ->where('state', 1);

        // Total de ventas (según Box)
        $total_sales = $sales->sum('amount');

        // Ventas por método de pago - SOLO DE ESTA CAJA
        $sales_by_method = Box::where('cash_id', $cash_id)
            ->where('expenses', 0)
            ->where('incomes', 0)
            ->where('state', 1)
            ->select('method', DB::raw('SUM(amount) as total'))
            ->groupBy('method')
            ->get();

        $efectivo = $sales_by_method->where('method', 'Efectivo')->sum('total') ?? 0;
        $tarjeta = $sales_by_method->whereIn('method', ['Tarjeta', 'TARJETA: NIUBIZ', 'TARJETA: IZYPAY', 'TARJETA: OPENPAY'])->sum('total') ?? 0;
        $yape = $sales_by_method->where('method', 'Yape')->sum('total') ?? 0;
        $plin = $sales_by_method->where('method', 'PLIN')->sum('total') ?? 0;
        $transferencia = $sales_by_method->whereIn('method', ['Transferencia', 'Deposito Bancario'])->sum('total') ?? 0;

        // Total de ventas NOTA DE VENTA - SOLO DE ESTA CAJA
        $total_sale_notes = SaleNote::where('cash_id', $cash_id)
            ->where('state_type_id', '!=', '11') // excluir anuladas
            ->sum('total');

        // Total de ventas DOCUMENTOS (boletas + facturas) - SOLO DE ESTA CAJA
        $total_documents = Document::where('cash_id', $cash_id)
            ->where('state_type_id', '!=', '11')
            ->sum('total');

        // Obtener IDs de órdenes que pertenecen a esta caja específica
        $orden_ids_from_salenote = SaleNote::where('cash_id', $cash_id)
            ->whereNotNull('orden_id')
            ->pluck('orden_id')
            ->toArray();

        $orden_ids_from_document = Document::where('cash_id', $cash_id)
            ->whereNotNull('orden_id')
            ->pluck('orden_id')
            ->toArray();

        $orden_ids = array_unique(array_merge($orden_ids_from_salenote, $orden_ids_from_document));

        // Cantidad de atenciones (órdenes pagadas) - SOLO DE ESTA CAJA
        $orders_paid = Orden::whereIn('id', $orden_ids)
            ->where('status_orden_id', 4)
            ->count();

        // Cantidad de anulaciones - SOLO DE ESTA CAJA
        $canceled = SaleNote::where('cash_id', $cash_id)
            ->where('state_type_id', '11')
            ->count();

        $canceled += Document::where('cash_id', $cash_id)
            ->where('state_type_id', '11')
            ->count();

        return [
            'total_sales'      => round($total_sales, 2),
            'efectivo'         => round($efectivo, 2),
            'tarjeta'          => round($tarjeta, 2),
            'yape'             => round($yape, 2),
            'plin'             => round($plin, 2),
            'transferencia'    => round($transferencia, 2),
            'orders_count'     => $orders_paid,
            'canceled_count'   => $canceled,

            // 👇 NUEVOS CAMPOS
            'total_sale_notes' => round($total_sale_notes, 2),
            'total_documents'  => round($total_documents, 2),
        ];
    }


    /**
     * Obtiene la tendencia de ventas por hora durante el turno
     * Solo muestra las horas desde que abrió hasta que cerró la caja
     */
    private function getSalesTrendByHour($cash_id)
    {
        $cash = Cash::find($cash_id);
        
        if (!$cash || !$cash->date_opening) {
            return [];
        }
        
        // Combinar date_opening + time_opening para obtener el datetime completo
        $opening_datetime = $cash->date_opening . ' ' . ($cash->time_opening ?? '00:00:00');
        $opening_date = Carbon::parse($opening_datetime);

        // Si la caja está abierta, usar la hora actual, sino usar date_closed + time_closed
        if ($cash->state) {
            $closing_date = Carbon::now();
        } else {
            $closing_datetime = $cash->date_closed . ' ' . ($cash->time_closed ?? '00:00:00');
            $closing_date = Carbon::parse($closing_datetime);
        }

        // Obtener todas las ventas de ESTA CAJA ESPECÍFICA con su fecha/hora completa
        // State = 1 significa que es una venta registrada
        $sales = Box::where('cash_id', $cash_id)
            ->where('expenses', 0)
            ->where('incomes', 0)
            ->where('state', 1)
            ->whereBetween('created_at', [$opening_date, $closing_date])
            ->select('created_at', 'amount')
            ->get();

        // Agrupar ventas por hora
        $sales_by_hour = [];
        foreach ($sales as $sale) {
            $hour_key = Carbon::parse($sale->created_at)->format('Y-m-d H:00');
            if (!isset($sales_by_hour[$hour_key])) {
                $sales_by_hour[$hour_key] = 0;
            }
            $sales_by_hour[$hour_key] += $sale->amount;
        }

        // Si no hay ventas, retornar array vacío
        if (count($sales_by_hour) === 0) {
            return [];
        }

        // Usar la hora de apertura de caja (mantener fecha y hora, solo resetear minutos y segundos)
        // Ejemplo: 2025-12-01 20:02:12 -> 2025-12-01 20:00:00
        $start_hour = $opening_date->copy()->setMinute(0)->setSecond(0);
        
        // Usar la hora de cierre de caja (redondear hacia arriba si tiene minutos)
        // Ejemplo: 2025-12-02 03:24:14 -> 2025-12-02 04:00:00
        $end_hour = $closing_date->copy()->setMinute(0)->setSecond(0);
        if ($closing_date->minute > 0 || $closing_date->second > 0) {
            $end_hour->addHour();
        }
        
        // Crear array desde inicio hasta fin
        $trend_data = [];
        $current = $start_hour->copy();
        
        while ($current < $end_hour) {
            $key = $current->format('Y-m-d H:00');
            $trend_data[] = [
                'hour' => $current->format('H:i'),
                'date' => $current->format('d/m'),
                'total' => round($sales_by_hour[$key] ?? 0, 2)
            ];
            $current->addHour();
        }

        return $trend_data;
    }

    private function getWaiterPerformance($cash_id)
    {
        $waiters_performance = [];

        // PRIMERO: Obtener IDs de órdenes que pertenecen a esta caja específica
        $orden_ids_from_salenote = SaleNote::where('cash_id', $cash_id)
            ->where('state_type_id', '!=', '11')
            ->whereNotNull('orden_id')
            ->pluck('orden_id')
            ->toArray();

        $orden_ids_from_document = Document::where('cash_id', $cash_id)
            ->where('state_type_id', '!=', '11')
            ->whereNotNull('orden_id')
            ->pluck('orden_id')
            ->toArray();

        $orden_ids = array_unique(array_merge($orden_ids_from_salenote, $orden_ids_from_document));

        Log::info("Órdenes de la caja $cash_id: " . implode(', ', $orden_ids));

        if (empty($orden_ids)) {
            Log::info("No hay órdenes para la caja $cash_id");
            return [];
        }

        // SEGUNDO: Obtener items solo de esas órdenes específicas
        $items = OrdenItem::whereIn('orden_id', $orden_ids)
            ->whereHas('orden', function ($query) {
                $query->where('status_orden_id', 4); // Solo órdenes pagadas
            })
            ->with(['orden.salenote', 'orden.document', 'user'])
            ->get();

        Log::info("Items encontrados para caja $cash_id: " . $items->count());

        // Agrupar por mozo (orden_item.user_id)
        $groupedByWaiter = $items->groupBy('user_id');
        
        Log::info("Usuarios agrupados: " . $groupedByWaiter->keys()->implode(', '));

        foreach ($groupedByWaiter as $waiter_id => $waiter_items) {

            $waiter = User::with('worker_type')->find($waiter_id);
            if (!$waiter) {
                Log::info("Usuario $waiter_id no encontrado");
                continue;
            }

            $workerTypeName = $waiter->worker_type ? $waiter->worker_type->description : 'Sin tipo';
            Log::info("Usuario encontrado: ID={$waiter->id}, Name={$waiter->name}, WorkerType={$workerTypeName}");

            // Solo mozos o caja (según worker_type)
            if (!$waiter->worker_type || !in_array(strtoupper($waiter->worker_type->description), ['MOZO', 'CAJA'])) {
                Log::info("Usuario {$waiter->name} descartado por worker_type: {$workerTypeName}");
                continue;
            }

            $total_sales = 0;
            $orders_attended = [];

            foreach ($waiter_items as $item) {
                $order = $item->orden;

                if (!$order) continue;

                $orders_attended[$order->id] = true;

                if ($order->sale_note_id && $order->salenote) {
                    $total_sales += $order->salenote->total;
                } elseif ($order->document_id && $order->document) {
                    $total_sales += $order->document->total;
                }
            }

            $waiters_performance[] = [
                'waiter_id'      => $waiter->id,
                'waiter_name'    => $waiter->name,
                'orders_count'   => count($orders_attended),
                'total_sales'    => round($total_sales, 2),
            ];
        }
        Log::info("Mozos encontrados para caja $cash_id: " . count($waiters_performance));

        // Ordenar
        usort($waiters_performance, function ($a, $b) {
            return $b['total_sales'] <=> $a['total_sales'];
        });

        return array_slice($waiters_performance, 0, 5);
    }


    private function getTopProductsByCategory($cash_id)
    {
        // PRIMERO: Obtener IDs de órdenes que pertenecen a esta caja específica
        $orden_ids_from_salenote = SaleNote::where('cash_id', $cash_id)
            ->where('state_type_id', '!=', '11')
            ->whereNotNull('orden_id')
            ->pluck('orden_id')
            ->toArray();

        $orden_ids_from_document = Document::where('cash_id', $cash_id)
            ->where('state_type_id', '!=', '11')
            ->whereNotNull('orden_id')
            ->pluck('orden_id')
            ->toArray();

        $orden_ids = array_unique(array_merge($orden_ids_from_salenote, $orden_ids_from_document));

        if (empty($orden_ids)) {
            return [];
        }

        // Obtener todas las áreas activas
        $areas = Area::where('active', 1)->get();

        $products_by_area = [];

        foreach ($areas as $area) {
            // SEGUNDO: Obtener items vendidos de esta área SOLO de las órdenes de esta caja
            $products = OrdenItem::whereIn('orden_id', $orden_ids)
                ->whereHas('orden', function ($query) {
                    $query->where('status_orden_id', 4); // Solo órdenes pagadas
                })
                ->whereHas('food', function ($query) use ($area) {
                    $query->where('area_id', $area->id);
                })
                ->with('food')
                ->select(
                    'food_id',
                    DB::raw('SUM(quantity) as total_quantity'),
                    DB::raw('SUM(quantity * price) as total_sales')
                )
                ->groupBy('food_id')
                ->orderByDesc('total_quantity')
                ->limit(5)
                ->get();

            if ($products->count() > 0) {
                $products_list = $products->map(function ($item) {
                    return [
                        'product_id' => $item->food_id,
                        'product_name' => $item->food ? $item->food->description : 'Sin nombre',
                        'quantity_sold' => $item->total_quantity,
                        'total_sales' => round($item->total_sales, 2),
                    ];
                })->toArray();

                $products_by_area[] = [
                    'area_id' => $area->id,
                    'area_name' => $area->description,
                    'products' => $products_list,
                ];
            }
        }

        return $products_by_area;
    }

    /**
     * Obtiene información de la caja y cajero
     */
    private function getCashInfo($cash)
    {
        return [
            'cashier_name' => $cash->user ? $cash->user->name : 'Sin usuario',
            'opening_date' => $cash->date_opening,
            'opening_time' => Carbon::parse($cash->time_opening)->format('H:i'),
            'turn' => $cash->turn ? $cash->turn->turn_desc : 'Sin turno',
            'is_open' => (bool) $cash->state,
        ];
    }
}
