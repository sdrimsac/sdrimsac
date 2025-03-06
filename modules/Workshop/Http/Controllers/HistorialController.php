<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\Workshop\Http\Resources\HistorialCollection;
use Modules\Workshop\Http\Resources\HistorialResource;
use Modules\Workshop\Http\Requests\HistorialRequest;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Workshop\Models\Historial;
use Modules\Workshop\Models\Vehiculo;
use Mpdf\Mpdf;
use Barryvdh\DomPDF\Facade as PDF;

class HistorialController extends Controller
{
    public function index()
    {
        return view('workshop::historial.index');
    }
    public function records(Request $request)
    {
        $vehiculo_id = $request->vehiculo_id;
        $records = Historial::query();

        if ($vehiculo_id) {
            $records = $records->where('vehiculo_id', $vehiculo_id);
        }

        $records = $records->select('historial.*')
            ->leftJoin('sale_notes', 'historial.sale_note_id', '=', 'sale_notes.id')
            ->leftJoin('documents', 'historial.document_id', '=', 'documents.id')
            ->addSelect([
                DB::raw('CASE 
                    WHEN historial.sale_note_id IS NOT NULL THEN sale_notes.external_id 
                    WHEN historial.document_id IS NOT NULL THEN documents.external_id 
                    ELSE NULL 
                END as external_id'),
                DB::raw('CASE 
                    WHEN historial.sale_note_id IS NOT NULL THEN "80" 
                    WHEN historial.document_id IS NOT NULL THEN documents.document_type_id 
                    ELSE NULL 
                END as document_type_id')
            ]);

        $records = $records->get();

        return new HistorialCollection($records);
    }

    public function record($id)
    {
        $record = new HistorialResource(Historial::findOrFail($id));

        return $record;
    }
    public function record2($id)
    {
        $historial = Historial::findOrFail($id);

        if ($historial->estado == 1) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede editar el historial porque está inactivo.'
            ], 403);
        }

        $record = new HistorialResource($historial);

        return $record;
    }

    public function generarPdf($vehiculo_id)
    {
        $vehiculo = Vehiculo::with(['historial.servicesDetails', 'historial.historialItem'])
            ->findOrFail($vehiculo_id);

        if ($vehiculo->historial->isEmpty()) {
            return "El vehículo no tiene historial registrado.";
        }

        // Fetch customer name
        $customer = DB::connection('tenant')->table('persons')->select('name')->where('id', $vehiculo->customer_id)->first();
        $vehiculo->customer_name = $customer->name;

        // Fetch item details and personal name
        $vehiculo->historial->each(function ($historial) {
            $historial->historialItem->each(function ($historialItem) {
                $item = DB::connection('tenant')->table('items')->select('internal_id', 'description')->where('id', $historialItem->item_id)->first();
                $historialItem->item_internal_id = $item->internal_id;
                $historialItem->item_description = $item->description;
            });

            // Fetch personal name
            $personal = DB::connection('tenant')->table('personal')->select('name')->where('id', $historial->personal_id)->first();
            $historial->personal_name = $personal->name;
        });

        $pdf = Pdf::loadView('workshop::mecanico.vehicle_historial', compact('vehiculo'));

        return $pdf->stream("Historial_Vehiculo_{$vehiculo->id}.pdf");
    }

    public function store(HistorialRequest $request)
    {
        $id = $request->input('id');
        $bank = Historial::firstOrNew(['id' => $id]);
        $bank->fill($request->all());
        $bank->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Historial editado con éxito' : 'Historial registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        try {

            $bank = Historial::findOrFail($id);
            $bank->delete();

            return [
                'success' => true,
                'message' => 'Historial eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El Historial esta siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar Historial'];
        }
    }
}
