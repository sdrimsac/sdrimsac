<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\System\HistoryCollection;
use App\Http\Requests\System\HistoryRequest;
use App\Models\System\Business;
use App\Models\System\History;
use App\Http\Resources\System\HistoryResource;
use Barryvdh\DomPDF\Facade as PDF;

class HistorialController extends Controller
{
    public function index()
    {
        return view('system.historial.index');
    }


    public function records()
    {
        $records = History::with('business')->get();

        return new HistoryCollection($records);
    }

    public function record($id)
    {
        $record = new HistoryResource(History::findOrFail($id));
        return $record;
    }

    public function store(HistoryRequest $request)
    {
        $id = $request->input('id');
        $plan = History::firstOrNew(['id' => $id]);
        $plan->fill($request->all());
        $plan->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Historial editado con éxito' : 'Historial registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        $plan = History::findOrFail($id);
        $plan->delete();

        return [
            'success' => true,
            'message' => 'Historial eliminado con éxito'
        ];
    }
    public function tables()
    {
        $business = Business::all();

        return compact('business');
    }

    public function pdf($id)
    {
        $record = History::with('business')->findOrFail($id);

        if (!$record->business) {
            return response()->json([
                'error' => 'El cliente no tiene un negocio asociado.'
            ], 404);
        }

        $business_id = $record->business_id;

        $template_paths = [
            1 => 'system.historial.contrato_restaurant_pdf',
            2 => 'system.historial.contrato_hotel_pdf',
            3 => 'system.historial.contrato_bar_pdf',
            8 => 'system.historial.contrato_creditos_pdf',
        ];

        $template = $template_paths[$business_id] ?? 'system.historial.contrato_default_pdf';

        $data = [
            'record' => $record,
            'name' => $record->name,
            'number' => $record->number,
            'business' => $record->business->description ?? 'Sin descripción',
            'telephone' => $record->telephone,
            'direccion' => $record->direccion,
            'direccion_secondary' => $record->direccion_secondary,
            'email' => $record->email,
            'ruc' => $record->ruc,
        ];
        $pdf = PDF::loadView($template, $data)
            ->setPaper('a4', 'portrait');

        return $pdf->stream('contrato.pdf');
    }
}
