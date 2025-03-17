<?php

namespace Modules\Restaurant\Http\Controllers;


use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\UserSchedule;
use Modules\Restaurant\Models\UserScheduleDay;

class EstilistaController extends Controller
{

    public function index()
    {
        $configuration = Configuration::first();
        $establishment = Establishment::find(auth()->user()->establishment_id);
        return view('restaurant::estilista.timework', compact('configuration', 'establishment'));
    }

    public function workers()
    {
        $users = User::whereHas('worker_type', function ($query) {
            $query->where('description', 'ESTILISTA');
        })->get()->transform(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];
        });
        return response()->json($users);
    }
    
    public function schedule(Request $request)
    {
        $user = User::find($request->user_id);
        $date = $request->date;
        $get_number_day = date('w', strtotime($date));
        $schedule = UserScheduleDay::where('day_of_week', $get_number_day)->whereHas('schedule', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->first();
        return response()->json($schedule);
    }
}
