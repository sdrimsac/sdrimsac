<?php

namespace Modules\Restaurant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\UserSchedule;
use App\Models\Tenant\User;

class UserScheduleController extends Controller
{
    public function index()
    {
        return view('restaurant::estilista.schedules.index');
    }

    public function create()
    {
        $users = User::where('has_schedule', true)->get();
        return view('restaurant::estilista.schedules.form', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:tenant.users,id',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);


        
        // Crear el horario
        $schedule = UserSchedule::create($request->all());

        return [
            'success' => true,
            'message' => 'Horario creado con éxito',
            'data' => $schedule
        ];
    }

    public function show($id)
    {
        $schedule = UserSchedule::with('days.timeSlots')->findOrFail($id);
        return view('restaurant::estilista.schedules.show', compact('schedule'));
    }

    public function edit($id)
    {
        $schedule = UserSchedule::findOrFail($id);
        $users = User::where('has_schedule', true)->get();
        return view('restaurant::estilista.schedules.form', compact('schedule', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $schedule = UserSchedule::findOrFail($id);
        $schedule->update($request->all());

        return [
            'success' => true,
            'message' => 'Horario actualizado con éxito',
            'data' => $schedule
        ];
    }

    public function destroy($id)
    {
        $schedule = UserSchedule::findOrFail($id);
        $schedule->delete();

        return [
            'success' => true,
            'message' => 'Horario eliminado con éxito'
        ];
    }

    public function records()
    {
        $userId = auth()->id();
        $records = UserSchedule::where('user_id', $userId)->with('user:id,name')->get();

        return [
            'data' => $records
        ];
    }

    public function createDefault()
    {
        $user = auth()->user();
        
        if (!$user->has_schedule) {
            $user->has_schedule = true;
            $user->save();
        }

        $schedule = UserSchedule::createDefaultSchedule($user->id);

        return [
            'success' => true,
            'message' => 'Horario predeterminado creado con éxito',
            'data' => $schedule
        ];
    }

    public function getCurrentUser()
    {
        $user = auth()->user();
        return [
            'id' => $user->id,
            'name' => $user->name,
            'has_schedule' => $user->has_schedule
        ];
    }
} 