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
        $records = History::all();

        return new HistoryCollection($records);
    }

    /* public function record($id)
    {
        $record = new HistoryResource(History::findOrFail($id));

        return $record;
    } */
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
    /* public function pdf() */
    /* {
        // Encuentra el registro en la base de datos
        /* $record = History::findOrFail($id); *//*

        // Genera el PDF usando la vista y pasa los datos necesarios
        $pdf = \PDF::loadView('system.historial.contrato_restaurant', compact('record'))
            ->setPaper('a4', 'landscape');

        // Retorna el PDF al navegador para que se pueda ver/descargar
        return $pdf->stream();
    } */
    /* public function pdf()
    {
        // Generar un PDF a partir de la vista sin necesidad de datos dinámicos
        $pdf = \PDF::loadView('system.historial.contrato_restaurant')
            ->setPaper('a4', 'landscape');

        // Retornar el PDF para visualizarlo en el navegador
        return $pdf->stream('contrato.pdf');
    } */
    public function pdf()
    {
        // Generar el PDF con la vista especificada
        $pdf = PDF::loadView('system.historial.contrato_restaurant', [])
            ->setPaper('a4', 'landscape'); // Configurar tamaño A4 y orientación horizontal

        // Retornar el PDF para visualizarlo en el navegador
        return $pdf->stream('contrato.pdf');
    }
}
