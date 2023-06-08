<?php

namespace Modules\Internet\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Internet\Models\InternetRegister;
use Modules\Internet\Models\InternetSuspension;

class InternetSuspensionController extends Controller
{

    public function store(Request $request)
    {



        DB::beginTransaction();

        try {
            $id = $request->id;
            $suspension = InternetSuspension::findOrNew($id);
            $description = $request->description;
            $suspend_date = Carbon::now()->format('Y-m-d');
            $register_id = $request->register_id;
            $register = InternetRegister::find($register_id);
            $register->active = 0;
            $register->save();
            $active = $request->active ?? 1;
            $suspension->description = $description;
            $suspension->suspend_date = $suspend_date;
            $suspension->register_id = $register_id;
            $suspension->active = $active;
            $suspension->save();
            DB::commit();
            return ["success" => true, "message" => $id ? "Suspensión editada" : "Suspensión creada"];
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }
}
