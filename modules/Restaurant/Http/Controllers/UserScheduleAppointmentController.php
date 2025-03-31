<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Models\Tenant\Item;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\UserScheduleAppointment;
use App\Models\Tenant\User;
use App\Models\Tenant\Person;
use Carbon\Carbon;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\Table;

class UserScheduleAppointmentController extends Controller
{
    public function index()
    {
        $users = User::where('has_schedule', true)->get();
        return view('restaurant::estilista.appointments.index', compact('users'));
    }

    public function create()
    {
        $users = User::where('has_schedule', true)->get();
        $clients = Person::where('type', 'customers')->get();
        return view('restaurant::estilista.appointments.form', compact('users', 'clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:tenant.users,id',
            'client_id' => 'required|exists:tenant.persons,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|integer|min:5',
            'notes' => 'nullable|string',
            'service_id' => 'nullable|exists:tenant.items,id',
            'whatsapp' => 'nullable|string'
        ]);

        // Verificar disponibilidad
        $isAvailable = UserScheduleAppointment::checkAvailability(
            $request->user_id,
            $request->appointment_date,
            $request->start_time,
            $request->end_time
        );

        if (!$isAvailable) {
            return [
                'success' => false,
                'message' => 'El horario seleccionado no está disponible'
            ];
        }

        // Crear la cita
        $appointment = UserScheduleAppointment::create([
            'user_id' => $request->user_id,
            'client_id' => $request->client_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $request->duration,
            'status' => 'scheduled',
            'notes' => $request->notes,
            'service_id' => $request->service_id
        ]);

        // Si se proporcionó un número de WhatsApp, actualizar el cliente
        if ($request->has('whatsapp') && $request->whatsapp) {
            $client = Person::find($request->client_id);
            if ($client) {
                $client->telephone = $request->whatsapp;
                $client->save();
            }
        }

        return [
            'success' => true,
            'message' => 'Cita programada con éxito',
            'data' => $appointment
        ];
    }

    public function show($id)
    {
        $appointment = UserScheduleAppointment::with(['user', 'client', 'service'])->findOrFail($id);

        return [
            'success' => true,
            'data' => $appointment
        ];
    }

    public function edit($id)
    {
        $appointment = UserScheduleAppointment::findOrFail($id);
        $users = User::where('has_schedule', true)->get();
        $clients = Person::where('type', 'customers')->get();
        return view('restaurant::estilista.appointments.form', compact('appointment', 'users', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:tenant.users,id',
            'client_id' => 'required|exists:tenant.persons,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|integer|min:5',
            'notes' => 'nullable|string',
            'service_id' => 'nullable|exists:tenant.items,id',
            'whatsapp' => 'nullable|string'
        ]);

        $appointment = UserScheduleAppointment::findOrFail($id);

        // Verificar disponibilidad solo si cambiaron la fecha, hora o estilista
        if (
            $appointment->user_id != $request->user_id ||
            $appointment->appointment_date != $request->appointment_date ||
            $appointment->start_time != $request->start_time ||
            $appointment->end_time != $request->end_time
        ) {

            $isAvailable = UserScheduleAppointment::checkAvailability(
                $request->user_id,
                $request->appointment_date,
                $request->start_time,
                $request->end_time,
                $id // Excluir la cita actual de la verificación
            );

            if (!$isAvailable) {
                return [
                    'success' => false,
                    'message' => 'El horario seleccionado no está disponible'
                ];
            }
        }

        // Actualizar la cita
        $appointment->update([
            'user_id' => $request->user_id,
            'client_id' => $request->client_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $request->duration,
            'notes' => $request->notes,
            'service_id' => $request->service_id
        ]);

        // Si se proporcionó un número de WhatsApp, actualizar el cliente
        if ($request->has('whatsapp') && $request->whatsapp) {
            $client = Person::find($request->client_id);
            if ($client) {
                $client->telephone = $request->whatsapp;
                $client->save();
            }
        }

        return [
            'success' => true,
            'message' => 'Cita actualizada con éxito',
            'data' => $appointment
        ];
    }

    public function destroy($id)
    {
        $appointment = UserScheduleAppointment::findOrFail($id);
        $appointment->delete();

        return [
            'success' => true,
            'message' => 'Cita eliminada con éxito'
        ];
    }

    public function services(Request $request)
    {
        $services = Item::all()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => $row->description,
                'price' => $row->sale_unit_price,
                'type' => $row->item_type,
                'category' => $row->category_id,
                'subcategory' => $row->subcategory_id,
                'brand' => $row->brand_id,
                'model' => $row->model_id,
                'color' => $row->color_id,
            ];
        });

        return [
            'data' => $services
        ];
    }
    public function clients(Request $request)
    {
        $term = $request->term;
        $query = Person::where('type', 'customers');

        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%')
                    ->orWhere('telephone', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%');
            });
        }

        $clients = $query->limit(20)->get();

        // Obtener los IDs de los clientes para hacer una consulta eficiente
        $clientIds = $clients->pluck('id')->toArray();

        // Obtener todas las citas para estos clientes en una sola consulta
        $appointments = UserScheduleAppointment::whereIn('client_id', $clientIds)
            ->select('client_id', 'status')
            ->get()
            ->groupBy('client_id');

        // Transformar los datos y agregar los conteos
        $result = $clients->map(function ($client) use ($appointments) {
            $clientAppointments = $appointments->get($client->id, collect([]));

            return [
                'id' => $client->id,
                'name' => $client->name,
                'number' => $client->number,
                'telephone' => $client->telephone,
                'email' => $client->email,
                'scheduled_count' => $clientAppointments->where('status', 'scheduled')->count(),
                'completed_count' => $clientAppointments->where('status', 'completed')->count(),
                'cancelled_count' => $clientAppointments->where('status', 'cancelled')->count(),
                'no_show_count' => $clientAppointments->where('status', 'no_show')->count(),
                'total_count' => $clientAppointments->count()
            ];
        });

        return [
            'data' => $result
        ];
    }
    public function records(Request $request)
    {
        $query = UserScheduleAppointment::query();

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->has('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $records = $query->with('client', 'user:id,name', 'service:id,description')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'asc')
            ->get();

        return [
            'data' => $records
        ];
    }

    public function getByDay($date)
    {
        $userId = auth()->id();
        $appointments = UserScheduleAppointment::where('user_id', $userId)
            ->whereDate('appointment_date', $date)
            ->with('client')
            ->orderBy('start_time')
            ->get();

        return [
            'success' => true,
            'data' => $appointments
        ];
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:scheduled,in_progress,completed,cancelled,no_show'
        ]);

        $appointment = UserScheduleAppointment::findOrFail($id);
        $appointment->status = $request->status;

        $appointment->save();

        if ($request->status == 'in_progress') {
            $this->createOrden($appointment);
        }

        return [
            'success' => true,
            'message' => 'Estado de la cita actualizado con éxito',
            'data' => $appointment
        ];
    }

    function createOrden($appointment)
    {
        $item = Item::find($appointment->service_id);
        $establishment_id = auth()->user()->establishment_id;
        $table = Table::firstOrCreate(
            [
                'number' => 'caja',
                'establishment_id' => $establishment_id
            ],
            [
                'area_id' => auth()->user()->area_id,
                'status_table_id' => 2
            ]
        );
        $orden = Orden::create([
            'table_id' => $table->id,
            'status_orden_id' => 1,
        ]);
        $items = [
            'food_id' => $item->food->id,
            'observations' =>  '-',
            'quantity' => 1,
            'price' => $item->sale_unit_price,
            'user_id' => auth()->user()->id,
            'orden_id' => $orden->id,
            'to_carry' => 0,
            'status_orden_id' => 1,
            'date' => Carbon::today(),
            'time' => date('H:i:s'),
            'area_id' => $item->food->area_id
        ];

        OrdenItem::insert($items);

        $appointment->orden_id = $orden->id;
        $appointment->save();
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:tenant.users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'appointment_id' => 'nullable|exists:tenant.user_schedule_appointments,id'
        ]);

        $isAvailable = UserScheduleAppointment::checkAvailability(
            $request->user_id,
            $request->date,
            $request->start_time,
            $request->end_time,
            $request->appointment_id
        );

        return [
            'success' => true,
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Horario disponible' : 'Horario no disponible'
        ];
    }

    public function addProducts(Request $request, $id)
    {
        try {
            $appointment = UserScheduleAppointment::findOrFail($id);

            foreach ($request->products as $product) {
                $appointment->products()->create([
                    'item_id' => $product['item_id'],
                    'quantity' => $product['quantity'],
                    'unit_price' => $product['unit_price'],
                    'total' => $product['total']
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Productos agregados correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar productos: ' . $e->getMessage()
            ], 500);
        }
    }
}
