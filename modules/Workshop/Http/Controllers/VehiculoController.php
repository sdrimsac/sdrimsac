<?php

namespace Modules\Workshop\Http\Controllers;

use Modules\workshop\Http\Resources\VehiculoCollection;
use Modules\workshop\Http\Resources\VehiculoResource;
use Modules\workshop\Http\Requests\VehiculoRequest;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Vehicle;
use App\Models\Tenant\Warehouse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Workshop\Models\Historial;
use Modules\Workshop\Models\Vehiculo;
use Modules\Workshop\Models\HistorialItem;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Modules\Workshop\Models\VehicleFeature;

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
        /* $records = $this->getRecords($request); */
        $records = $this->getRecords($request)->paginate(config('tenant.items_per_page'));

        return new VehiculoCollection($records);
    }
    /* public function getRecords(Request $request)
    {
        $placa = $request->input('placa');

        $query = Vehiculo::query()
            ->when($placa, function ($query, $placa) {
                return $query->where('placa', 'like', '%' . $placa . '%');
            })
            ->get();

        return $query;
    } */
    public function getRecords(Request $request)
    {
        $placa = $request->input('placa');
    
        // Devuelve la consulta sin ejecutar con get()
        $query = Vehiculo::query()
            ->when($placa, function ($query, $placa) {
                return $query->where('placa', 'like', '%' . $placa . '%');
            });
    
        return $query;  // Devuelve el query builder en lugar de una Collection
    }
    public function setItems(Request $request)
    {
        
        $historial_id = $request->historial_id;
        $items = $request->items;
        $existingItems = HistorialItem::where('historial_id', $historial_id)->get();
        foreach ($existingItems as $itemToDelete) {
            $this->updateStock($itemToDelete->item_id, -$itemToDelete->cantidad);
            
        }
        HistorialItem::where('historial_id', $historial_id)->delete();
        foreach ($items as $item) {
            /* if ($existingItems->has($item['id'])) {
                $historial_item = $existingItems->get($item['id']);
                $historial_item->item_id = $item['id'];
                $historial_item->cantidad = $item['cantidad'];
                $historial_item->price = $item['precioUnitario'];
                $historial_item->save();

                $this->updateStock($item['id'], $item['cantidad']);

                $existingItems->forget($item['id']);
            } else { */
                $historial_item = new HistorialItem;
                $historial_item->cantidad = $item['cantidad'];
                $historial_item->price = $item['precioUnitario'];
                $historial_item->item_id = $item['id'];
                $historial_item->historial_id = $historial_id;
                $historial_item->save();

                $this->updateStock($item['id'], $item['cantidad']);
            /* } */
        }
        /* foreach ($existingItems as $itemToDelete) {
            $itemToDelete->delete();
        } */

        return response()->json(["success" => true]);
    }
    private function updateStock($itemId, $cantidad)
    {
        $establishment = auth()->user()->establishment;
        $warehouse = Warehouse::where('establishment_id', $establishment->id)->first();
        $product = ItemWarehouse::where('item_id', $itemId)
            ->where('warehouse_id', $warehouse->id)
            ->first();
        if ($product) {

            $product->stock -= $cantidad;

            if ($product->stock < 0) {
                return response()->json(["success" => false, "message" => "Stock insuficiente para el producto {$product->description}"], 400);
            }

            $product->save();
        } else {
            return response()->json(["success" => false, "message" => "Producto no encontrado"], 404);
        }
    }
    public function record($id)
    {
        $record = new VehiculoResource(Vehiculo::with('historiales')->findOrFail($id));

        return $record;
    }
    public function record_payment($id)
    {
        $record = Vehiculo::find($id);
        $customer_id = $record->customer_id;
        $historial = Historial::where('vehiculo_id', $id)->first();
        $items = $historial->historialItem->transform( function($row) {
            $item = $row->item;
            $row->item->quantity = $row->cantidad;
            $row->item->sale_unit_price = $row->price;
            return $row->item;
        });

        return [ 'customer_id' => $customer_id, 'items' => $items];
    }

    /* public function store(VehiculoRequest $request)
    {
        $id = $request->input('id');
        $plate = $request->input('placa');
        $establishment_id = auth()->user()->establishment_id;

        $vehicle = Vehiculo::where('id', $id)
            ->orWhere('placa', $plate)
            ->first();

        if ($vehicle) {
            $historial = new Historial;
            $historial->fill($request->except('vehiculo'));
            $historial->vehiculo_id = $vehicle->id;
            $historial->establishment_id = $establishment_id;
            $historial->save();

            $vehicleFeatureData = $request->input('vehiculo', []);
            $vehicleFeatureData['vehiculo_id'] = $vehicle->id;
            $vehicleFeature = new VehicleFeature;
            $vehicleFeature->fill($vehicleFeatureData);
            $vehicleFeature->save();

            // Asociar los servicios seleccionados al historial
            $services_detail_ids = $request->input('services_detail_ids', []);
            $dataToInsert = array_map(function ($service_detail_id) use ($historial) {
                return [
                    'services_detail_id' => $service_detail_id,
                    'historial_id' => $historial->id
                ];
            }, $services_detail_ids);
            DB::connection('tenant')->table('historial_service_details')->insert($dataToInsert);

            return [
                'success' => true,
                'message' => 'Historial creado para el vehículo existente con éxito'
            ];
        }

        $data = $request->except('vehiculo');

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

        $vehicleFeatureData = $request->input('vehiculo', []);
        $vehicleFeatureData['vehiculo_id'] = $vehicle->id;
        $vehicleFeature = new VehicleFeature;
        $vehicleFeature->fill($vehicleFeatureData);
        $vehicleFeature->save();

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
    } */

    public function store(VehiculoRequest $request)
    {
        $id = $request->input('id');
        $plate = $request->input('placa');
        $establishment_id = auth()->user()->establishment_id;

        $vehicle = Vehiculo::where('id', $id)
            ->orWhere('placa', $plate)
            ->first();

        if ($vehicle) {
            $historial = new Historial;
            $historial->fill($request->except('vehiculo'));
            $historial->vehiculo_id = $vehicle->id;
            $historial->establishment_id = $establishment_id;
            $historial->save();

            $vehicleFeatureData = $request->input('vehiculo', []);
            $vehicleFeatureData['vehiculo_id'] = $vehicle->id;
            $vehicleFeature = new VehicleFeature;
            $vehicleFeature->fill($vehicleFeatureData);
            $vehicleFeature->save();

            $services_detail_ids = $request->input('services_detail_ids', []);
            $dataToInsert = array_map(function ($service_detail_id) use ($historial) {
                return [
                    'services_detail_id' => $service_detail_id,
                    'historial_id' => $historial->id
                ];
            }, $services_detail_ids);
            DB::connection('tenant')->table('historial_service_details')->insert($dataToInsert);

            return [
                'success' => true,
                'message' => 'Historial creado para el vehículo existente con éxito'
            ];
        }

        $existingVehicle = Vehiculo::where('placa', $plate)
            ->when($id, function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })
            ->first();

        if ($existingVehicle) {
            return response()->json(['message' => false, 'El vehículo ya existe'], 422);
        }

        // Si no existe, se crea el nuevo vehículo
        $data = $request->except('vehiculo');
        $vehicle = Vehiculo::firstOrNew(['id' => $id]);
        if (!$vehicle->exists) {
            $vehicle->fill($data);
            $vehicle->save();
        }
        /* $vehicle->fill($data);
        $vehicle->save(); */

        $historial = new Historial;
        $historial->fill($data);
        $historial->vehiculo_id = $vehicle->id;
        $historial->establishment_id = $establishment_id;
        $historial->save();

        $vehicleFeatureData = $request->input('vehiculo', []);
        $vehicleFeatureData['vehiculo_id'] = $vehicle->id;
        $vehicleFeature = new VehicleFeature;
        $vehicleFeature->fill($vehicleFeatureData);
        $vehicleFeature->save();

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
            'message' => ($id) ? 'Vehículo editado con éxito' : 'Vehículo registrado con éxito'
        ];
    }
    /* public function storeHistory(Request $request)
    {
        dump($request->all());
        $id = $request->input('id');
        $establishment_id = auth()->user()->establishment_id;

       try {
        $historial = new Historial;
        $historial->fill($id);
        $historialData = $request->only($request);
        $historial->fill($historialData);
        $historial->vehiculo_id = $request->input('vehiculo_id');
        $historial->establishment_id = $establishment_id;
        $historial->save();

        $vehicleFeatureData = $request->input('vehiculo', []);
        $vehicleFeatureData['vehiculo_id'] = $historial->vehiculo_id;
        $vehicleFeature = new VehicleFeature;
        $vehicleFeature->fill($vehicleFeatureData);
        $vehicleFeature->save();
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
            'message' => ($id) ? 'Historia editado con éxito' : 'Historia registrado con éxito'
        ];

       } catch (\Exception $e) {
        return [
            'success' => false,
            'message' => 'Ocurrió un error al registrar el historial: ' . $e->getMessage(),
        ];
       }  
    } */

    public function storeHistory(Request $request)
    {
        $vehiculo_id = $request->input('vehiculo_id');
        $establishment_id = auth()->user()->establishment_id;

        $historialData = $request->only([
            'vehiuclo_id',
            'sale_note_id',
            'document_id',
            'personal_id',
            'establishment_id',
            'observacion',
            'motive',
            'reparacion',
            'garantia',
            'mantenimiento',
            'diagnostico',
            'estado',
            'date_start',
            'date_end',
        ]);

        try {
            $historial = new Historial();
            $historial->fill($historialData);
            $historial->vehiculo_id = $vehiculo_id;
            $historial->establishment_id = $establishment_id;
            $historial->save();

            $vehicleFeatureData = $request->input('vehiculo', []);
            $vehicleFeatureData['vehiculo_id'] = $vehiculo_id;
            $vehicleFeature = new VehicleFeature();
            $vehicleFeature->fill($vehicleFeatureData);
            $vehicleFeature->save();

            $services_detail_ids = $request->input('services_detail_ids', []);
            $dataToInsert = array_map(function ($service_detail_id) use ($historial) {
                return [
                    'services_detail_id' => $service_detail_id,
                    'historial_id' => $historial->id
                ];
            }, $services_detail_ids);

            DB::connection('tenant')->table('historial_service_details')->insert($dataToInsert);

            return [
                'success' => true,
                'message' => 'Historia registrada con éxito'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Ocurrió un error al registrar el historial: ' . $e->getMessage(),
            ];
        }
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
    function get_vehiculo($combinedData, $label, $property)
    {
        $quantityVehiculo = "quantity_" . $property;
        $stateVehiculo = "state_" . $property;

        $quantity = $combinedData[$quantityVehiculo] ?? null;
        $state = $combinedData[$stateVehiculo] ?? null;

        return [
            "label" => $label,
            "quantity" => $quantity,
            "state" => $state
        ];
    }
    public function format_vehicle($id, $version = null)
    {
        $vehiculo = Vehiculo::where('id', $id)->first();

        $vehicleFeatures = VehicleFeature::where('vehiculo_id', $id)->first();

        $combinedData = array_merge(
            $vehiculo->toArray(),
            $vehicleFeatures ? $vehicleFeatures->toArray() : []
        );

        $list1 = [
            $this->get_vehiculo($combinedData, "Faros Delanteros", "front_lights"),
            $this->get_vehiculo($combinedData, "Luces Direccionales Delanteros", "directional_lights_front"),
            $this->get_vehiculo($combinedData, "Luces Direccionales Posteriores", "directional_lights_back"),
            $this->get_vehiculo($combinedData, "Luces de Peligro", "hazard_lights"),
            $this->get_vehiculo($combinedData, "Brazo y Plumilla Limpia Parabrizas", "wiper_washer_arm"),
            $this->get_vehiculo($combinedData, "Tapa Gasolina", "gasoil_cap"),
            $this->get_vehiculo($combinedData, "Antena Radio", "radio_antenna"),
            $this->get_vehiculo($combinedData, "Espejos Laterales", "side_mirrors"),
            $this->get_vehiculo($combinedData, "Manijas de Prueba ", "test_handles"),
            $this->get_vehiculo($combinedData, "Alarma", "alarm"),
            $this->get_vehiculo($combinedData, "Escarpines", "booties"),
            $this->get_vehiculo($combinedData, "Llanta y Aro de Respuesto", "spare_tire"),
            $this->get_vehiculo($combinedData, "Dado Segruo de Rueda", "wheel_nut"),
            $this->get_vehiculo($combinedData, "Copa de Aro", "wheel_cup"),
        ];
        $list2 = [
            $this->get_vehiculo($combinedData, "Cenicero", "ashtray"),
            $this->get_vehiculo($combinedData, "Espejo Retrovisor Interno", "internal_rearview_mirror"),
            $this->get_vehiculo($combinedData, "Auto Radio", "car_radio"),
            $this->get_vehiculo($combinedData, "Alfombra de protección", "protection_mat"),
            $this->get_vehiculo($combinedData, "Pisos de jebe", "rubber_floors"),
            $this->get_vehiculo($combinedData, "Posa Vasos", "cup_holder"),
            $this->get_vehiculo($combinedData, "Llave de Vehículo", "vehicle_key"),


        ];
        $list3 = [
            $this->get_vehiculo($combinedData, "Extintor", "extinguisher"),
            $this->get_vehiculo($combinedData, "Gata y palanca", "jack_lever"),
            $this->get_vehiculo($combinedData, "Estuche de Herramientas", "toolkit"),
        ];

        $list4 = [
            $this->get_vehiculo($combinedData, "Tarjeta de Propiedad", "property_card"),
            $this->get_vehiculo($combinedData, "Cuaderno de bitácora", "logbook"),
            $this->get_vehiculo($combinedData, "Manual del Propietario", "owner_manual"),
            $this->get_vehiculo($combinedData, "Porta Documentos", "document_holder"),
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
            "combinedData"

        ));
        /* $timestamp = now()->format('Ymd_His'); */
        $timestamp = now()->format('Y_m_d');
        $pdfPath = storage_path("app/public/format_vehiculo_{$id}_{$timestamp}.pdf");
        $pdf->save($pdfPath);

        /* return $pdf->stream('FORMATO.pdf'); */
        return $pdf->stream("formato_vehiculo_{$id}_{$timestamp}.pdf");
    }
    public function check_pdf($id, $date)
    {
        /* $formattedDate = Carbon::parse($date)->format('Ymd'); */
        $formattedDate = Carbon::parse($date)->format('Y_m_d'); 

        $pdfPath = storage_path("app/public/format_vehiculo_{$id}_{$formattedDate}.pdf");

        if (file_exists($pdfPath)) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
    public function view_pdf($id, $timestamp)
    {
        
        $pdfPath = storage_path("app/public/format_vehiculo_{$id}_{$timestamp}.pdf");

        if (file_exists($pdfPath)) {
            return response()->file($pdfPath);
        } else {
            return $this->format_vehicle($id);
        }
    }
    
}
