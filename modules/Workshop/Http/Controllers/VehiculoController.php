<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\workshop\Http\Resources\VehiculoCollection;
use Modules\workshop\Http\Resources\VehiculoResource;
use Modules\workshop\Http\Requests\VehiculoRequest;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Workshop\Models\Historial;
use Modules\Workshop\Models\Vehiculo;
use Modules\Workshop\Models\HistorialItem;
use Barryvdh\DomPDF\Facade as PDF;

class VehiculoController extends Controller
{
    protected $vehiculo;
    protected $company;

    public function index()
    {
        return view('workshop::vehiculo.index');
    }
    public function records(Request $request)
    {
        /* $records = Vehiculo::all(); */
        $records = $this->getRecords($request);

        return new VehiculoCollection($records);
    }
    public function getRecords(Request $request)
    {

        $customer_id = $request->get('customer_id');

        $placa = $request->get('placa');

        $query = Vehiculo::query();
        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }
        if ($placa) {
            $query->where('placa', 'like', '%' . $placa . '%');
        }
        $records = $query->get();
        return $records;
    }

    /* public function setItems(Request $request)
    {

        $historial_id = $request->historial_id;
        $items = $request->items;
        foreach ($items as $item) {
            $historial_item = new HistorialItem;
            $historial_item->cantidad = $item['cantidad'];
            $historial_item->price = $item['precioUnitario'];
            $historial_item->item_id = $item['id'];
            $historial_item->historial_id = $historial_id;
            $historial_item->save();
        }
        return ["sucess" => true];
    } */

    public function setItems(Request $request)
    {
        $historial_id = $request->historial_id;
        $items = $request->items;
        // Obtener todos los ítems actuales para el historial_id dado, para poder compararlos
        $existingItems = HistorialItem::where('historial_id', $historial_id)->get()->keyBy('item_id');
        // Recorrer los ítems que vienen en la solicitud
        foreach ($items as $item) {
            if ($existingItems->has($item['id'])) {
                // Si el ítem ya existe, actualizar su cantidad y precio
                $historial_item = $existingItems->get($item['id']);
                $historial_item->cantidad = $item['cantidad'];
                $historial_item->price = $item['precioUnitario'];
                $historial_item->save();

                // Eliminarlo de la colección de ítems existentes ya que ya fue procesado
                $existingItems->forget($item['id']);
            } else {
                // Si el ítem no existe, crear un nuevo registro
                $historial_item = new HistorialItem;
                $historial_item->cantidad = $item['cantidad'];
                $historial_item->price = $item['precioUnitario'];
                $historial_item->item_id = $item['id'];
                $historial_item->historial_id = $historial_id;
                $historial_item->save();
            }
        }
        // Cualquier ítem que quede en existingItems no estaba en la solicitud, por lo tanto se elimina
        foreach ($existingItems as $itemToDelete) {
            $itemToDelete->delete();
        }

        return response()->json(["success" => true]);
    }
    public function record($id)
    {
        $record = new VehiculoResource(Vehiculo::with('historiales')->findOrFail($id));

        return $record;
    }

    public function store(VehiculoRequest $request)
    {
        $id = $request->input('id');
        $plate = $request->input('placa');

        $data = array_merge($request->except('vehiculo'), $request->input('vehiculo', []));

        $existengVehicle = Vehiculo::where('placa', $plate)
            ->when($id, function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })
            ->first();
        if ($existengVehicle) {
            return response()->json(['message' => false, 'El vehiculo ya existe'], 422);
        }

        $vehicle = Vehiculo::firstOrNew(['id' => $id]);

        $vehicle->fill($data);
        $vehicle->save();
        $establishment_id = auth()->user()->establishment_id;

        $historial = new Historial;
        $historial->fill($data);
        $historial->vehiculo_id = $vehicle->id;
        $historial->establishment_id = $establishment_id;
        $historial->save();

        $services_detail_ids = $request->services_detail_ids;
        $dataToInsert = array_map(function ($service_detail_id) use ($historial) {
            return [
                'services_detail_id' => $service_detail_id,
                'historial_id' => $historial->id
            ];
        }, $services_detail_ids);

        DB::connection('tenant')->table('historial_service_details')->insert($dataToInsert);

        return [
            'success' => true,
            'message' => ($id) ? 'Vehiculo editado con éxito' : 'Vehiculo registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        try {

            $vehicle = Vehiculo::findOrFail($id);
            $vehicle->delete();

            return [
                'success' => true,
                'message' => 'Vehiculo eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El Vehiculo esta siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar Vehiculo'];
        }
    }
    function get_vehiculo($label, $property)
    {
        $quantity = "quantity_" . $property;
        $state = "state_" . $property;
        return [
            "label" => $label,
            "quantity" => $this->vehiculo->{$quantity},
            "state" => $this->vehiculo->{$state}
        ];
    }
    public function format_vehicle($id)
    {
        /* $vehiculo = Vehiculo::find($id); */
        /* a */
        /* $this->vehiculo = $vehiculo; */
        /* $vehiculo = vehiculo::find($id); */
        $vehiculo = Vehiculo::where('id', $id)->first();
        $this->vehiculo = $vehiculo;
        $list1 = [
            $this->get_vehiculo("Faros Delanteros", "front_lights"),
            $this->get_vehiculo("Luces Direccionales Delanteros", "directional_lights_front"),
            $this->get_vehiculo("Luces Direccionales Posteriores", "directional_lights_back"),
            $this->get_vehiculo("Luces de Peligro", "hazard_lights"),
            $this->get_vehiculo("Brazo y Plumilla Limpia Parabrizas", "wiper_washer_arm"),
            $this->get_vehiculo("Tapa Gasolina", "gasoil_cap"),
            $this->get_vehiculo("Antena Radio", "radio_antenna"),
            $this->get_vehiculo("Espejos Laterales", "side_mirrors"),
            $this->get_vehiculo("Manijas de Prueba ", "test_handles"),
            $this->get_vehiculo("Alarma", "alarm"),
            $this->get_vehiculo("Escarpines", "booties"),
            $this->get_vehiculo("Llanta y Aro de Respuesto", "spare_tire"),
            $this->get_vehiculo("Dado Segruo de Rueda", "wheel_nut"),
            $this->get_vehiculo("Copa de Aro", "wheel_cup"),
        ];
        $list2 = [
            $this->get_vehiculo("Cenicero", "ashtray"),
            $this->get_vehiculo("Espejo Retrovisor Interno", "internal_rearview_mirror"),
            $this->get_vehiculo("Auto Radio", "car_radio"),
            $this->get_vehiculo("Alfombra de protección", "protection_mat"),
            $this->get_vehiculo("Pisos de jebe", "rubber_floors"),
            $this->get_vehiculo("Posa Vasos", "cup_holder"),
            $this->get_vehiculo("Llave de Vehículo", "vehicle_key"),


        ];
        $list3 = [
            $this->get_vehiculo("Extintor", "extinguisher"),
            $this->get_vehiculo("Gata y palanca", "jack_lever"),
            $this->get_vehiculo("Estuche de Herramientas", "toolkit"),
        ];

        $list4 = [
            $this->get_vehiculo("Tarjeta de Propiedad", "property_card"),
            $this->get_vehiculo("Cuaderno de bitácora", "logbook"),
            $this->get_vehiculo("Manual del Propietario", "owner_manual"),
            $this->get_vehiculo("Porta Documentos", "document_holder"),
        ];
        $company = Company::active();
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $pdf = Pdf::loadView('workshop::vehiculo.format_vehiculo', compact(
            "company",
            "list1",
            "establishment",
            "list2",
            "list3",
            "list4",
            "vehiculo",

        ));
        return $pdf->stream('FORMATO.pdf');
    }
}
