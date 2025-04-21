<?php

namespace Modules\Restaurant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\UserScheduleException;
use App\Models\Tenant\User;

class UserScheduleExceptionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('restaurant::estilista.exceptions.index', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:tenant.users,id',
            'exception_date' => 'required|date',
            'is_working_day' => 'boolean',
            'start_time' => 'nullable|required_if:is_working_day,true|date_format:H:i',
            'end_time' => 'nullable|required_if:is_working_day,true|date_format:H:i|after:start_time',
            'reason' => 'nullable|string|max:255'
        ]);

        // Verificar si ya existe una excepción para esta fecha y usuario
        $existingException = UserScheduleException::where('user_id', $request->user_id)
            ->where('exception_date', $request->exception_date)
            ->first();
            
        if ($existingException) {
            $existingException->update($request->all());
            $exception = $existingException;
            $message = 'Excepción actualizada con éxito';
        } else {
            $exception = UserScheduleException::create($request->all());
            $message = 'Excepción creada con éxito';
        }

        return [
            'success' => true,
            'message' => $message,
            'data' => $exception
        ];
    }

    public function edit($id)
    {
        $exception = UserScheduleException::findOrFail($id);
        return view('restaurant::estilista.exceptions.form', compact('exception'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'exception_date' => 'required|date',
            'is_working_day' => 'boolean',
            'start_time' => 'nullable|required_if:is_working_day,true|date_format:H:i',
            'end_time' => 'nullable|required_if:is_working_day,true|date_format:H:i|after:start_time',
            'reason' => 'nullable|string|max:255'
        ]);

        $exception = UserScheduleException::findOrFail($id);
        $exception->update($request->all());

        return [
            'success' => true,
            'message' => 'Excepción actualizada con éxito',
            'data' => $exception
        ];
    }

    public function destroy($id)
    {
        $exception = UserScheduleException::findOrFail($id);
        $exception->delete();

        return [
            'success' => true,
            'message' => 'Excepción eliminada con éxito'
        ];
    }

    public function records()
    {
        $userId = auth()->id();
        $records = UserScheduleException::where('user_id', $userId)
            ->orderBy('exception_date', 'desc')
            ->get();

        return [
            'data' => $records
        ];
    }
} 