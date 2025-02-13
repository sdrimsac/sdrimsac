<?php

namespace Modules\Workshop\Http\Controllers;

use App\CoreFacturalo\Template;
use App\CoreFacturalo\Helpers\Storage\StorageDocument;
use App\Exports\ListVehicle;
use Modules\Workshop\Http\Resources\VehiculoCollection;
use Modules\Workshop\Http\Resources\VehiculoResource;
use Modules\Workshop\Http\Requests\VehiculoRequest;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Configuration;
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
use Illuminate\Support\Facades\Storage;
use Modules\Workshop\Models\VehicleFeature;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

class VehiculoController extends Controller
{

    use StorageDocument;
    protected $vehiculo;
    protected $company;

    public function index()
    {
        return view('workshop::vehiculo.index');
    }
    public function records(Request $request)
    {
        $records = $this->getRecords($request)->paginate(10);
        return new VehiculoCollection($records);
    }
    public function getRecords(Request $request)
    {
        $placa = $request->input('placa');
        $customer = $request->input('customer');
        $records = Vehiculo::query()
            ->when($placa, function ($query, $placa) {
                return $query->where('placa', 'like', '%' . $placa . '%');
            })
            ->when($customer, function ($query, $customer) {
                return $query->whereHas('customer', function ($query) use ($customer) {
                    $query->where('name', 'like', '%' . $customer . '%');
                });
            });
        return $records;
    }

    public function excelVehicle(Request $request)
    {
        ini_set('memory_limit', '10500M');
        ini_set('max_execution_time', '30000');
        $records = $this->getRecords($request, false, true)->get();
        $establishment = Establishment::first();
        $company = Company::active();
        return (new ListVehicle)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('Listado_de_vehiculos_' . Carbon::now() . '.xlsx');
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
            $historial_item = new HistorialItem;
            $historial_item->cantidad = $item['cantidad'];
            $historial_item->price = $item['precioUnitario'];
            $historial_item->item_id = $item['id'];
            $historial_item->historial_id = $historial_id;
            $historial_item->save();

            $this->updateStock($item['id'], $item['cantidad']);
        }

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
    public function restoreItems($historial_id)
    {
        $Items = HistorialItem::where('historial_id', $historial_id)->get();
        foreach ($Items as $itemToDelete) {
            $this->updateStock($itemToDelete->item_id, -$itemToDelete->cantidad);
        }
        return response()->json(["success" => true]);
    }

    public function generarTicketEntrega($historial_id)
    {
        $historial = Historial::with(['vehiculo', 'personal'])
            ->findOrFail($historial_id);

        $historialItems = HistorialItem::where('historial_id', $historial_id)->get();

        if ($historialItems->isEmpty()) {
            return response()->json(["error" => "No hay productos registrados en este historial"], 404);
        }

        $company = Company::active();
        $placa = $historial->vehiculo->placa;
        $mecanico = $historial->personal->name;
        $updated_at = optional($historialItems->first())->updated_at;

        $width = 226.77;
        $base_height = 250;
        $item_height = 30;

        $height = $base_height + ($historialItems->count() * $item_height);

        $customPaper = [$width, 0, $width, $height];

        $pdf = PDF::loadView('workshop::tipo.entrega', compact(
            'historialItems',
            'historial_id',
            'placa',
            'mecanico',
            'updated_at',
            'company'
        ));
        $pdf->setPaper(array(0, 0, 249.45, $height));

        return $pdf->stream('ticket_entrega_' . $historial_id . '.pdf');
    }


    public function record($id)
    {
        $record = new VehiculoResource(Vehiculo::findOrFail($id));
        return $record;
    }
    public function record2($id)
    {
        $record = new VehiculoResource(Vehiculo::findOrFail($id));
        return $record;
    }

    /* public function record_payment($id)
    {
        $record = Vehiculo::find($id);
        $customer_id = $record->customer_id;
        $historial = Historial::where('vehiculo_id', $id)->where('estado', 0)->first();

        if (!$historial) {
            return response()->json([
                'error' => 'No se encontró un historial activo para este vehículo.'
            ], 404);
        }

        $items = $historial->historialItem->transform(function ($row) {
            $item = $row->item->replicate();
            $item->quantity = $row->cantidad;
            $item->item_id = $row->item_id;
            $item->sale_unit_price = $row->price;
            return $item;
        });

        if ($items->isEmpty()) {
            return response()->json([
                'error' => 'No hay items en el historial para este vehículo, por favor no sigas el proceso.'
            ], 400);
        }

        $service_item = Item::where('description', 'SERVICIO')->first();
        $services = DB::connection('tenant')->table('historial_service_details as hsd')
            ->join('services_details as sd', 'hsd.services_detail_id', '=', 'sd.id')
            ->where('hsd.historial_id', $historial->id)
            ->get()
            ->map(function ($row) use ($service_item) {

                if ($service_item) {
                    $cloned_service_item = $service_item->replicate();


                    $cloned_service_item->quantity = 1;
                    $cloned_service_item->sale_unit_price = $row->price_unit;
                    $cloned_service_item->description = $row->name;
                    $cloned_service_item->price = $row->price_unit;
                    $cloned_service_item->currency_type_id = 'PEN';
                    $cloned_service_item->unit_type_id = 'ZZ';
                    $cloned_service_item->item_id = $service_item->id;

                    return $cloned_service_item;
                }
                return null;
            });

        $services = $services->filter()->values();

        if ($services->isEmpty()) {
            return response()->json([
                'error' => 'No hay servicios relacionados con este historial.'
            ], 400);
        }

        $items_with_services = $items->toArray();

        foreach ($services as $service) {
            $items_with_services[] = $service;
        }

        return [
            'customer_id' => $customer_id,
            'establishment_id' => $historial->establishment_id,
            'items' => $items_with_services
        ];
    } */

    public function record_payment($id)
    {
        $record = Vehiculo::find($id);
        $customer_id = $record->customer_id;
        $historial = Historial::where('vehiculo_id', $id)->where('estado', 0)->first();

        if (!$historial) {
            return response()->json([
                'error' => 'No se encontró un historial activo para este vehículo.'
            ], 404);
        }

        // Get regular items from historial
        $items = $historial->historialItem->transform(function ($row) {
            $item = $row->item->replicate();
            $item->quantity = $row->cantidad;
            $item->item_id = $row->item_id;
            $item->sale_unit_price = $row->price;
            return $item;
        });

        // Get services using SERVICIO item as template
        $service_item = Item::where('description', 'SERVICIO')->first();
        $services = collect();

        if ($service_item) {
            $services = DB::connection('tenant')->table('historial_service_details as hsd')
                ->join('services_details as sd', 'hsd.services_detail_id', '=', 'sd.id')
                ->where('hsd.historial_id', $historial->id)
                ->get()
                ->map(function ($row) use ($service_item) {
                    $cloned_service_item = $service_item->replicate();
                    $cloned_service_item->quantity = 1;
                    $cloned_service_item->sale_unit_price = $row->price_unit;
                    $cloned_service_item->description = $row->name;
                    $cloned_service_item->price = $row->price_unit;
                    $cloned_service_item->currency_type_id = 'PEN';
                    $cloned_service_item->unit_type_id = 'ZZ';
                    $cloned_service_item->item_id = $service_item->id;
                    return $cloned_service_item;
                });
        }

        // Combine both regular items and services
        $all_items = $items->concat($services);

        if ($all_items->isEmpty()) {
            return response()->json([
                'error' => 'No hay items ni servicios en el historial para este vehículo.'
            ], 400);
        }

        return [
            'customer_id' => $customer_id,
            'establishment_id' => $historial->establishment_id,
            'items' => $all_items->values()
        ];
    }


    public function tables()
    {
        $establishments = Establishment::where('id', auth()->user()->establishment_id)->get();

        return compact(
            'establishments',
        );
    }

    private function setFilename()
    {
        $name = ['TS', $this->vehiculo->id, date('Ymd')];
        $this->vehiculo->filename = join('-', $name);
        $this->vehiculo->save();
    }
    private function setFilenameHistorial($historial, $services)
    {
        $name = ['TS', $historial->id, date('Ymd')];
        $historial->filename = join('-', $name);
        $historial->save();
    }

    public function store(VehiculoRequest $request)
    {
        $id = $request->input('id');
        $plate = $request->input('placa');
        $customer_id = $request->input('customer_id');
        $establishment_id = auth()->user()->establishment_id;

        $vehicle = Vehiculo::where('id', $id)
            ->orWhere('placa', $plate)
            ->first();

        if ($vehicle) {
            if ($vehicle->customer_id == $customer_id) {
                return response()->json(['success' => false, 'message' => 'El vehículo con esta placa ya está registrado para este cliente'], 422);
            }

            $historial = new Historial;
            $historial->fill($request->except('vehiculo'));
            $historial->vehiculo_id = $vehicle->id;
            $historial->establishment_id = $establishment_id;
            $historial->save();

            $historial_id = $historial->id;

            $vehicleFeatureData = $request->input('vehiculo', []);
            $vehicleFeatureData['vehiculo_id'] = $vehicle->id;
            $vehicleFeatureData['historial_id'] = $historial_id;
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
            return response()->json(['success' => false, 'message' => 'El vehículo con esta placa ya existe'], 422);
        }

        // Si no existe, se crea el nuevo vehículo
        $data = $request->except('vehiculo');
        $vehicle = Vehiculo::firstOrNew(['id' => $id]);
        if (!$vehicle->exists) {
            $vehicle->fill($data);
            $vehicle->save();
        }

        $historial = new Historial;
        $historial->fill($data);
        $historial->vehiculo_id = $vehicle->id;
        $historial->establishment_id = $establishment_id;
        $historial->save();

        $historial_id = $historial->id;

        $vehicleFeatureData = $request->input('vehiculo', []);
        $vehicleFeatureData['vehiculo_id'] = $vehicle->id;
        $vehicleFeatureData['historial_id'] = $historial_id;
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

        $query = DB::connection('tenant')
            ->table('historial_service_details as hsd')
            ->join('services_details as sd', 'hsd.services_detail_id', '=', 'sd.id')
            ->where('hsd.historial_id', $historial_id)
            ->whereIn('hsd.services_detail_id', $services_detail_ids)
            ->select('sd.name', 'sd.price_unit');
        $services = $query->get();


        $this->setFilenameHistorial($historial, $services);

        $this->createPdfHistorial($historial, "a4", $historial->filename, $services);

        /* $this->vehiculo = $vehicle;
        $this->setFilename();
        $this->createPdf($this->vehiculo, "a4", $this->vehiculo->filename); */

        return [
            'success' => true,
            'message' => ($id) ? 'Vehículo editado con éxito' : 'Vehículo registrado con éxito'
        ];
    }

    public function storeHistory(Request $request)
    {
        $vehiculo_id = $request->input('vehiculo_id');
        $establishment_id = auth()->user()->establishment_id;
        $historial_id = $request->input('id');

        $historialData = $request->only([
            'vehiculo_id',
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
            $historial = Historial::find($historial_id);

            if ($historial) {
                // Update existing historial
                $historial->fill($historialData);
                $historial->save();
            } else {
                // Create new historial
                $historial = new Historial();
                $historial->fill($historialData);
                $historial->vehiculo_id = $vehiculo_id;
                $historial->establishment_id = $establishment_id;
                $historial->save();
                $historial_id = $historial->id;
            }

            $vehicleFeatureData = $request->input('vehiculo', []);
            $vehicleFeatureData['vehiculo_id'] = $vehiculo_id;
            $vehicleFeatureData['historial_id'] = $historial_id;
            $vehicleFeature = VehicleFeature::updateOrCreate(
                ['vehiculo_id' => $vehiculo_id, 'historial_id' => $historial_id],
                $vehicleFeatureData
            );

            $services_detail_ids = $request->input('services_detail_ids', []);
            DB::connection('tenant')->table('historial_service_details')->where('historial_id', $historial_id)->delete();
            $dataToInsert = array_map(function ($service_detail_id) use ($historial) {
                return [
                    'services_detail_id' => $service_detail_id,
                    'historial_id' => $historial->id
                ];
            }, $services_detail_ids);

            DB::connection('tenant')->table('historial_service_details')->insert($dataToInsert);

            $query = DB::connection('tenant')
                ->table('historial_service_details as hsd')
                ->join('services_details as sd', 'hsd.services_detail_id', '=', 'sd.id')
                ->where('hsd.historial_id', $historial_id)
                ->whereIn('hsd.services_detail_id', $services_detail_ids)
                ->select('sd.name', 'sd.price_unit');
            $services = $query->get();

            $this->setFilenameHistorial($historial, $services);

            $this->createPdfHistorial($historial, "a4", $historial->filename, $services);

            return [
                'success' => true,
                'message' => $historial_id ? 'Historial actualizado con éxito' : 'Historial registrado con éxito'
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
    public function format_vehicle($id, $historial_id, $version = null)
    {
        $vehiculo = Vehiculo::where('id', $id)->first();
        $historial = Historial::where('vehiculo_id', $id)
            ->where('estado', 0)->first();

        $vehicleFeatures = VehicleFeature::where('vehiculo_id', $id)
            ->where('historial_id', $historial->id)
            ->first();

        $combinedData = array_merge(
            $vehiculo->toArray(),
            $vehicleFeatures ? $vehicleFeatures->toArray() : []
        );

        $list1 = [
            $this->get_vehiculo($combinedData, "Faros Delanteros", "front_lights"),
            $this->get_vehiculo($combinedData, "Luces Direccionales Delanteros", "directional_lights_front"),
            $this->get_vehiculo($combinedData, "Luces Direccionales Posteriores", "directional_lights_back"),
            $this->get_vehiculo($combinedData, "Luces de Peligro", "hazard_lights"),
            $this->get_vehiculo($combinedData, "Brazo y Plumilla Limpia Parabrisas", "wiper_washer_arm"),
            $this->get_vehiculo($combinedData, "Tapa Gasolina", "gasoil_cap"),
            $this->get_vehiculo($combinedData, "Antena Radio", "radio_antenna"),
            $this->get_vehiculo($combinedData, "Espejos Laterales", "side_mirrors"),
            $this->get_vehiculo($combinedData, "Manijas de Puerta", "door_handles"),
            $this->get_vehiculo($combinedData, "Alarma", "alarm"),
            $this->get_vehiculo($combinedData, "Escarpines", "booties"),
            $this->get_vehiculo($combinedData, "Llanta y Aro de Repuesto", "spare_tire"),
            $this->get_vehiculo($combinedData, "Dado Seguro de Rueda", "wheel_nut"),
            $this->get_vehiculo($combinedData, "Copa de Aro", "wheel_cup"),
        ];
        $list2 = [
            $this->get_vehiculo($combinedData, "Cenicero", "ashtray"),
            $this->get_vehiculo($combinedData, "Espejo Retrovisor Interno", "internal_rearview_mirror"),
            $this->get_vehiculo($combinedData, "Auto Radio", "car_radio"),
            $this->get_vehiculo($combinedData, "Alfombra de Protección", "protection_mat"),
            $this->get_vehiculo($combinedData, "Pisos de Jebe", "rubber_floors"),
            $this->get_vehiculo($combinedData, "Posa Vasos", "cup_holder"),
            $this->get_vehiculo($combinedData, "Llave de Vehículo", "vehicle_key"),
        ];
        $list3 = [
            $this->get_vehiculo($combinedData, "Extintor", "extinguisher"),
            $this->get_vehiculo($combinedData, "Gata y Palanca", "jack_lever"),
            $this->get_vehiculo($combinedData, "Estuche de Herramientas", "toolkit"),
        ];

        $list4 = [
            $this->get_vehiculo($combinedData, "Tarjeta de Propiedad", "property_card"),
            $this->get_vehiculo($combinedData, "Cuaderno de Bitácora", "logbook"),
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
        $timestamp = now()->format('Y_m_d');
        $pdfPath = storage_path("app/public/format_vehiculo_{$id}_{$timestamp}.pdf");
        $pdf->save($pdfPath);

        return $pdf->stream("formato_vehiculo_{$id}_{$timestamp}.pdf");
    }
    public function createPdfHistorial($historial = null, $format_pdf = null, $filename = null, $services = null)
    {
        ini_set("pcre.backtrack_limit", "5000000");
        $template = new Template();
        $pdf = new Mpdf();

        $historial->services = $services;

        $document = $historial;
        /* $document = $services; */
        $company = ($this->company != null) ? $this->company : Company::active();
        $filename = ($filename != null) ? $filename : $historial->filename;

        $configuration = Configuration::first();
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();

        $trade_name = $configuration->formats;
        /* $html = $template->pdf($trade_name, "vehiculo", $company, $document, $format_pdf, $establishment); */
        $html = $template->pdf($trade_name, "vehiculo", $company, $document, $format_pdf, $establishment);

        $pdf_font_regular = config('tenant.pdf_name_regular');
        $pdf_font_bold = config('tenant.pdf_name_bold');

        if ($pdf_font_regular != false) {
            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $default = [
                'fontDir' => array_merge($fontDirs, [
                    app_path('CoreFacturalo' . DIRECTORY_SEPARATOR . 'Templates' .
                        DIRECTORY_SEPARATOR . 'pdf' .
                        DIRECTORY_SEPARATOR . $trade_name .
                        DIRECTORY_SEPARATOR . 'font')
                ]),
                'fontdata' => $fontData + [
                    'custom_bold' => [
                        'R' => $pdf_font_bold . '.ttf',
                    ],
                    'custom_regular' => [
                        'R' => $pdf_font_regular . '.ttf',
                    ],
                ]
            ];

            if ($trade_name == 'citec') {
                $default = [
                    'mode' => 'utf-8',
                    'margin_top' => 2,
                    'margin_right' => 0,
                    'margin_bottom' => 0,
                    'margin_left' => 0,
                    'fontDir' => array_merge($fontDirs, [
                        app_path('CoreFacturalo' . DIRECTORY_SEPARATOR . 'Templates' .
                            DIRECTORY_SEPARATOR . 'pdf' .
                            DIRECTORY_SEPARATOR . $trade_name .
                            DIRECTORY_SEPARATOR . 'font')
                    ]),
                    'fontdata' => $fontData + [
                        'custom_bold' => [
                            'R' => $pdf_font_bold . '.ttf',
                        ],
                        'custom_regular' => [
                            'R' => $pdf_font_regular . '.ttf',
                        ],
                    ]
                ];
            }

            $pdf = new Mpdf($default);
        }

        $path_css = app_path('CoreFacturalo' . DIRECTORY_SEPARATOR . 'Templates' .
            DIRECTORY_SEPARATOR . 'pdf' .
            DIRECTORY_SEPARATOR . $trade_name .
            DIRECTORY_SEPARATOR . 'style.css');

        $stylesheet = file_get_contents($path_css);

        $pdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
        $pdf->WriteHTML($html, HTMLParserMode::HTML_BODY);


        $this->uploadFile($filename, $pdf->output('', 'S'), 'vehiculo');
    }
    public function uploadFile($filename, $file_content, $file_type)
    {
        $this->uploadStorage($filename, $file_content, $file_type);
    }
    private function reloadPDF($vehiculo, $format, $filename, $services)
    {
        $this->createPdfHistorial($vehiculo, $format, $filename, $services);
    }
    public function toPrint($id, $format)
    {

        $historial = Historial::where('vehiculo_id', $id)->where('estado', 0)->first();

        if (!$historial) throw new Exception("El código es inválido, 
        no se encontró el servicio técnico relacionado");

        $services = DB::connection('tenant')
            ->table('historial_service_details as hsd')
            ->join('services_details as sd', 'hsd.services_detail_id', '=', 'sd.id')
            ->where('hsd.historial_id', $historial->id)
            ->select('sd.name', 'sd.price_unit')
            ->get();

        $this->reloadPDF($historial, $format, $historial->filename, $services);
        $temp = tempnam(sys_get_temp_dir(), 'vehiculo');

        file_put_contents($temp, $this->getStorage($historial->filename, 'vehiculo '));

        return response()->file($temp, $this->generalPdfResponseFileHeaders($historial->filename));
    }
    public function RePrint($id)
    {
        $historial = Historial::where('id', $id)->first();

        if (!$historial) {
            throw new Exception("El código es inválido, no se encontró el servicio técnico relacionado");
        }
        if ($historial->filename == null) {
            throw new Exception("El archivo PDF relacionado no se encontró en el almacenamiento");
        }
        if ($historial->filename !== null) {
            return Storage::disk('tenant')->download("vehiculo" . DIRECTORY_SEPARATOR . $historial->filename . '.pdf');
        }
    }

    public function format_History($historial_id)
    {
        $historial = Historial::find($historial_id);
        if (!$historial) {
            abort(404, 'Historial no encontrado');
        }
        $vehiculo = Vehiculo::find($historial->vehiculo_id);
        if (!$vehiculo) {
            abort(404, 'Vehículo no encontrado');
        }
        $vehicleFeatures = VehicleFeature::where('historial_id', $historial_id)->first();
        $combinedData = array_merge(
            $vehiculo->toArray(),
            $vehicleFeatures ? $vehicleFeatures->toArray() : []
        );

        $list1 = [
            $this->get_vehiculo($combinedData, "Faros Delanteros", "front_lights"),
            $this->get_vehiculo($combinedData, "Luces Direccionales Delanteros", "directional_lights_front"),
            $this->get_vehiculo($combinedData, "Luces Direccionales Posteriores", "directional_lights_back"),
            $this->get_vehiculo($combinedData, "Luces de Peligro", "hazard_lights"),
            $this->get_vehiculo($combinedData, "Brazo y Plumilla Limpia Parabrisas", "wiper_washer_arm"),
            $this->get_vehiculo($combinedData, "Tapa Gasolina", "gasoil_cap"),
            $this->get_vehiculo($combinedData, "Antena Radio", "radio_antenna"),
            $this->get_vehiculo($combinedData, "Espejos Laterales", "side_mirrors"),
            $this->get_vehiculo($combinedData, "Manijas de Puerta", "door_handles"),
            $this->get_vehiculo($combinedData, "Alarma", "alarm"),
            $this->get_vehiculo($combinedData, "Escarpines", "booties"),
            $this->get_vehiculo($combinedData, "Llanta y Aro de Repuesto", "spare_tire"),
            $this->get_vehiculo($combinedData, "Dado Seguro de Rueda", "wheel_nut"),
            $this->get_vehiculo($combinedData, "Copa de Aro", "wheel_cup"),
        ];
        $list2 = [
            $this->get_vehiculo($combinedData, "Cenicero", "ashtray"),
            $this->get_vehiculo($combinedData, "Espejo Retrovisor Interno", "internal_rearview_mirror"),
            $this->get_vehiculo($combinedData, "Auto Radio", "car_radio"),
            $this->get_vehiculo($combinedData, "Alfombra de Protección", "protection_mat"),
            $this->get_vehiculo($combinedData, "Pisos de Jebe", "rubber_floors"),
            $this->get_vehiculo($combinedData, "Posa Vasos", "cup_holder"),
            $this->get_vehiculo($combinedData, "Llave de Vehículo", "vehicle_key"),
        ];
        $list3 = [
            $this->get_vehiculo($combinedData, "Extintor", "extinguisher"),
            $this->get_vehiculo($combinedData, "Gata y Palanca", "jack_lever"),
            $this->get_vehiculo($combinedData, "Estuche de Herramientas", "toolkit"),
        ];

        $list4 = [
            $this->get_vehiculo($combinedData, "Tarjeta de Propiedad", "property_card"),
            $this->get_vehiculo($combinedData, "Cuaderno de Bitácora", "logbook"),
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
        $timestamp = now()->format('Y_m_d');
        $pdfPath = storage_path("app/public/format_vehiculo_{$historial_id}_{$timestamp}.pdf");
        $pdf->save($pdfPath);

        return $pdf->stream("formato_vehiculo_{$historial_id}_{$timestamp}.pdf");
    }
}
