<?php

namespace Modules\Etiquetas\Http\Controllers;

use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Etiquetas\Models\Codigos;
use Modules\Etiquetas\Models\MurcielagoPalabras;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

class CodesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        return view('etiquetas::codes.index');
    }

    /* public function generate(Request $request)
    {
        ini_set("pcre.backtrack_limit", "500000");

        try {
            $is_code_128 = true;
            $type_barcode = $request->type_barcode;
            if (str_contains($type_barcode, "EAN")) {
                $is_code_128 = false;
            }
            $sale_code = $request->salecode;
            $type = $request->type;
            $purchase_code = $request->purchasecode;
            $description = $request->description;
            $murcielagoCode = $request->murcielagoCode;
            $price1 = $request->price1;
            $price2 = $request->price2;
            $format = $request->format;
            $paper = $request->paper;
            $location = $request->location;
            $barcode = $request->barcode;
            $template = $format == '1' ? 'template' : ($format == '2' ? 'template2' : 'template4');
            if ($format == '1' && $paper == '2') {
                // $template = 'template3';
                $template = 'template_format_1_template_2';
            }
            if ($type == '3' && $format == '1' && $paper == '2') {
                // $template = 'template3';
                $template = 'template8';
            }
            if ($type == '3' && $format == '1' && $paper == '1') {
                $template = 'template9';
            }
            if ($type == '4' && $format == '1' && $paper == '2') {
                $template = 'template10';
            }
            if ($type == '5' && $format == '1' && $paper == '2') {
                $template = 'template14';
            }
            if ($type == '6' && $format == '1' && $paper == '2') {
                $template = 'template16';
            }
            if ($type == '7' && $format == '1' && $paper == '2') {
                $template = 'template18';
            }
            if ($type == '8' && $format == '1' && $paper == '1') {
                $template = 'template20';
            }
            if ($type == '9' && $format == '1' && $paper == '2') {
                $template = 'template21';
            }
            
            $record = Item::where('description', $description)->first();
            $company = Company::first();
            $price = $record->sale_unit_price;
            $price = number_format($price, 0, ".", "");
            $margin_top = 0;
            $margin_left = 0;
            $margin_right = 0;
            $margin_bottom = 0;
            if ($format == 1) {
                if ($paper == 1) {
                    // $margin_top = 1;
                }
            }
            if ($format == 2) {
                if ($paper == 1) {

                    // $margin_top = 1;
                }
            }
            $stock = $request->stock ?? 0;
            if ($company->etiqueta != null) {
                $image = asset('storage' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . explode("/", $company->etiqueta)[2]);
            } else {
                $image = null;
            }
            $width = $paper == 1 ? 50 : 65;
            $height = $paper == 1 ? 25 : 23;
            if ($template === "template_format_1_template_2") {
                $height = 20;
                $width = 65;
            }
            if ($template === "template14") {
                $height = 25;
                $width = 100;
            }
            if ($template === "template16") {
                $height = 20;
                $width = 60;
            }
            if ($template === "template18") {
                $height = 20;
                $width = 60;
            }
            if ($template === "template20") {
                $height = 25;
                $width = 50;
            }
            if ($template === "template21") {
                $height = 20;
                $width = 60;
            }
            // if($company->number == '10465702449'){
            //     $format = 1;
            //     $width = 70;
            //     $height = 35;
            //     Log::info('formato 1');
            //     $margin_left = 0;
            //     $template = 'template6';
            // }
            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    $width,
                    $height
                    // $paper ==  1 ? 50 :  65,
                    // $paper == 1 ? 25 : 23
                ],

                'margin_top' => $margin_top,
                'margin_right' => $margin_right,
                'margin_bottom' => $margin_bottom,
                'margin_left' => $margin_left
            ]);


            // $pdf->shrink_tables_to_fit = 0;
            $html = view('codes::' . $template, compact(
                // $html = view('etiquetas::templatetest', compact(
                'type',
                'record',
                'stock',
                'company',
                'description',
                'sale_code',
                'purchase_code',
                'image',
                'location',
                'price',
                'price1',
                'price2',
                'murcielagoCode',
                'paper',
                'barcode',
                'is_code_128'
            ))->render();

            $pdf->WriteHTML($html);
            $pdf->Output('etiquetas_' . now()->format('Y_m_d') . '.pdf', 'D');
            // $pdf->Stream('etiquetas_' . now()->format('Y_m_d') . '.pdf', 'D');
        } catch (Exception $e) {
            return response($e, 500);
        }
    } */

    public function generate(Request $request)
    {
        ini_set("pcre.backtrack_limit", "500000");

        try {
            $is_code_128 = true;
            $type_barcode = $request->type_barcode;
            if (str_contains($type_barcode, "EAN")) {
                $is_code_128 = false;
            }
            $sale_code = $request->salecode;
            $type = $request->type;
            $purchase_code = $request->purchasecode;
            $description = $request->description;
            $murcielagoCode = $request->murcielagoCode;
            $price1 = $request->price1;
            $price2 = $request->price2;
            $format = $request->format;
            $paper = $request->paper;
            $location = $request->location;
            $barcode = $request->barcode;
            $barcodes = !empty($barcode) ? explode(',', $barcode) : [];
            if (empty($barcodes)) {
                throw new Exception('No se proporcionaron códigos de barras');
            }

            $template = $format == '1' ? 'template' : ($format == '2' ? 'template2' : 'template4');
            if ($format == '1' && $paper == '2') {
                $template = 'template_format_1_template_2';
            }
            if ($type == '3' && $format == '1' && $paper == '2') {
                $template = 'template8';
            }
            if ($type == '3' && $format == '1' && $paper == '1') {
                $template = 'template9';
            }
            if ($type == '4' && $format == '1' && $paper == '2') {
                $template = 'template10';
            }
            if ($type == '5' && $format == '1' && $paper == '2') {
                $template = 'template14';
            }
            if ($type == '6' && $format == '1' && $paper == '2') {
                $template = 'template16';
            }
            if ($type == '7' && $format == '1' && $paper == '2') {
                $template = 'template18';
            }
            if ($type == '8' && $format == '1' && $paper == '1') {
                $template = 'template20';
            }
            if ($type == '9' && $format == '1' && $paper == '2') {
                $template = 'template21';
            }

            $record = Item::where('description', $description)->first();

            if (!$record) {
                throw new Exception('No se encontró el producto con la descripción proporcionada.');
            }
            $company = Company::first();
            $price = $record->sale_unit_price;
            $price = number_format($price, 0, ".", "");

            $margin_top = 0;
            $margin_left = 0;
            $margin_right = 0;
            $margin_bottom = 0;

            $stock = $request->stock ?? 0;
            if ($company->etiqueta != null) {
                $image = asset('storage' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . explode("/", $company->etiqueta)[2]);
            } else {
                $image = null;
            }

            $width = $paper == 1 ? 50 : 65;
            $height = $paper == 1 ? 25 : 23;

            if ($template === "template_format_1_template_2") {
                $height = 20;
                $width = 65;
            }
            if ($template === "template14") {
                $height = 25;
                $width = 100;
            }
            if ($template === "template16") {
                $height = 20;
                $width = 60;
            }
            if ($template === "template18") {
                $height = 20;
                $width = 60;
            }
            if ($template === "template20") {
                $height = 25;
                $width = 50;
            }
            if ($template === "template21") {
                $height = 20;
                $width = 60;
            }

            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [$width, $height],
                'margin_top' => $margin_top,
                'margin_right' => $margin_right,
                'margin_bottom' => $margin_bottom,
                'margin_left' => $margin_left
            ]);

            // Si el formato/papel requiere 2 columnas, agrupar los códigos de barra de 2 en 2
            $isTwoColumns = ($paper == 2); // Ajusta esta condición según tu lógica real de columnas
            if ($isTwoColumns) {
                for ($i = 0; $i < count($barcodes); $i += 2) {
                    if ($i > 0) {
                        $pdf->AddPage();
                    }
                    $currentBarcode1 = isset($barcodes[$i]) ? $barcodes[$i] : '';
                    $currentStock1 = 1;
                    $currentBarcode2 = isset($barcodes[$i + 1]) ? $barcodes[$i + 1] : '';
                    $currentStock2 = 1;
                    // Validar que al menos uno de los códigos existe
                    if (empty($currentBarcode1) && empty($currentBarcode2)) {
                        throw new Exception('No se encontraron códigos para imprimir en esta página.');
                    }
                    if (!$record) {
                        throw new Exception('No se encontró el producto con la descripción proporcionada.');
                    }
                    $html = view('etiquetas::codes.' . $template, compact(
                        'type',
                        'record',
                        'company',
                        'description',
                        'sale_code',
                        'purchase_code',
                        'image',
                        'location',
                        'price',
                        'price1',
                        'price2',
                        'murcielagoCode',
                        'paper',
                        'is_code_128'
                    ) + [
                        'barcode1' => $currentBarcode1,
                        'stock1' => $currentStock1,
                        'barcode2' => $currentBarcode2,
                        'stock2' => $currentBarcode2 ? $currentStock2 : null
                    ])->render();
                    $pdf->WriteHTML($html);
                }
            } else {
                // 1 columna, igual que antes
                foreach ($barcodes as $index => $currentBarcode) {
                    if ($index > 0) {
                        $pdf->AddPage();
                    }
                    $currentStock = 1;
                    $html = view('etiquetas::codes.' . $template, compact(
                        'type',
                        'record',
                        'company',
                        'description',
                        'sale_code',
                        'purchase_code',
                        'image',
                        'location',
                        'price',
                        'price1',
                        'price2',
                        'murcielagoCode',
                        'paper',
                        'is_code_128'
                    ) + [
                        'barcode' => $currentBarcode,
                        'stock' => $currentStock
                    ])->render();
                    $pdf->WriteHTML($html);
                }
            }

            $pdf->Output('etiquetas_' . now()->format('Y_m_d') . '.pdf', 'D');
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar códigos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function save_word(Request $request)
    {
        $word = $request->input('word');
        $indice = $request->input('indice');
        if ($word) {

            $word = strtoupper($word);

            $exist = MurcielagoPalabras::where('palabra', $word)->first();
            if ($exist) {

                return ['success' => false, 'message' => 'La palabra ya existe'];
            } else {

                //$id = Model::insertGetId(["name"=>"Niklesh","email"=>"myemail@gmail.com"]);
                $id = MurcielagoPalabras::insertGetId([
                    "indice" => $indice,
                    "palabra" => $word

                ]);

                return [
                    'success' => true,
                    'id' => $id,
                    'message' => 'Palabra guardada'
                ];
            }
        } else {
            return ['success' => false, 'message' => 'Palabra inválida'];
        }
    }

    public function delete_image()
    {
        $company = Company::first();
        if ($company->etiqueta != null) {
            $image_path = $company->etiqueta;
            Storage::delete($image_path);
        }
        $company->etiqueta = null;
        $company->save();
        return [
            "success" => true,
            "image" => null
        ];
    }
    public function image(Request $request)
    {
        $company = Company::first();
        if ($company->etiqueta != null) {
            $image_path = $company->etiqueta;
            Storage::delete($image_path);
        }


        $file = $request->file('file');
        $path = $file->store('public/files');

        $company->etiqueta = $path;
        $company->save();

        return [
            "success" => true,
            "image" => asset('storage' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . explode("/", $path)[2])
        ];
    }

    public function tables()
    {
        $palabras = MurcielagoPalabras::all();
        $codigos = Codigos::all();
        $company = Company::first();
        $company_name = $company->name;
        $etiqueta = null;
        $establishment = Establishment::find(auth()->user()->establishment_id);
        if ($company->etiqueta) {
            $etiqueta = asset('storage' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . explode("/", $company->etiqueta)[2]);
        }

        return compact('palabras', 'codigos', 'company_name', 'etiqueta', 'establishment');
    }
    /* public function items(Request $request)
    {
        $establishment_id = auth()->user()->establishment_id;
        $input = $request->input("input");
        $items = Item::where("description", "like", "%" . $input . "%")->orWhere(function ($subquery) use ($input) {
            $subquery->where("internal_id", "like", "%" . $input . "%")->orWhere("barcode", "like", "%" . $input . "%");
        })

            ->take(15)->get()
            ->transform(function ($row) {
                if ($row->internal_id != null && $row->type_barcode == "EAN-8") {
                    $row->internal_id = substr($row->internal_id, 0, -1);
                }
                $stock = $row->getStockByWarehouse(auth()->user()->establishment_id);
                return [
                    "id" => $row->id,
                    "descripcion" => $row->description,
                    "barras" => $row->internal_id,
                    "tipo_barras" => $row->barcode_type,
                    "stock" => $stock,
                    "price" => $row->sale_unit_price,
                    "purchase" => $row->purchase_unit_price,
                    "location" => $row->location,
                    "item_unit_types" => $row->item_unit_types,
                    'max_quantity' => $row->max_quantity
                ];
            });
        return [
            "items" => $items
        ];
    } */
    /* public function items(Request $request)
    {
        $establishment_id = auth()->user()->establishment_id;
        $input = $request->input("input");

        // Filtrar los items con active = 1 y buscar por descripción, internal_id o barcode
        $items = Item::where("active", 1)
            ->where(function ($query) use ($input) {
                $query->where("description", "like", "%" . $input . "%")
                    ->orWhere("internal_id", "like", "%" . $input . "%")
                    ->orWhere("barcode", "like", "%" . $input . "%");
            })
            ->take(15)
            ->get()
            ->transform(function ($row) use ($establishment_id) {
                // Filtrar el stock solo si el item_warehouse está en active = 1
                $stock = $row->warehouses()
                    ->where('warehouse_id', $establishment_id)
                    ->where('active', 1)
                    ->sum('stock'); // Sumar el stock válido

                // Evitar mostrar el item si no hay stock activo
                if ($stock <= 0) {
                    return null;
                }

                // Ajustar internal_id si el tipo de código de barras es EAN-8
                if ($row->internal_id != null && $row->type_barcode == "EAN-8") {
                    $row->internal_id = substr($row->internal_id, 0, -1);
                }

                return [
                    "id" => $row->id,
                    "descripcion" => $row->description,
                    "barras" => $row->internal_id,
                    "tipo_barras" => $row->barcode_type,
                    "stock" => $stock,
                    "price" => $row->sale_unit_price,
                    "purchase" => $row->purchase_unit_price,
                    "location" => $row->location,
                    "item_unit_types" => $row->item_unit_types,
                    'max_quantity' => $row->max_quantity,
                ];
            });


        return [
            "items" => $items
        ];
    } */

    public function items(Request $request)
    {
        $establishment_id = auth()->user()->establishment_id;
        $input = $request->input("input");

        // Solo filtrar items donde codes_family = 1
        $items = Item::where("active", 1)
            ->where('codes_family', 1)
            ->whereHas('warehouses', function ($query) use ($establishment_id) {
                $query->where('warehouse_id', $establishment_id)
                    ->where('active', 1);
            })
            ->where(function ($query) use ($input) {
                $query->where("description", "like", "%" . $input . "%")
                    ->orWhere("internal_id", "like", "%" . $input . "%")
                    ->orWhere("barcode", "like", "%" . $input . "%");
            })
            ->take(15)
            ->get()
            ->transform(function ($row) use ($establishment_id) {
                if ($row->internal_id != null && $row->type_barcode == "EAN-8") {
                    $row->internal_id = substr($row->internal_id, 0, -1);
                }

                $stock = $row->getStockByWarehouse($establishment_id);

                // Calcular precio de compra con IGV si corresponde
                $purchase_price = $row->purchase_unit_price;
                if ($row->purchase_affectation_igv_type_id === "10") {
                    $purchase_price = $purchase_price * 1.18;
                }

                $barcodes = $row->item_codes()
                    ->pluck('code_barcode')
                    ->toArray();

                return [
                    "id" => $row->id,
                    "descripcion" => $row->description,
                    "barras" => $barcodes,
                    "tipo_barras" => $row->barcode_type,
                    "stock" => $stock,
                    "price" => $row->sale_unit_price,
                    "purchase" => $purchase_price,
                    "location" => $row->location,
                    "item_unit_types" => $row->item_unit_types,
                    'max_quantity' => $row->max_quantity
                ];
            });

        return [
            "items" => $items
        ];
    }

    public function getStockByWarehouse($warehouse_id)
    {
        return $this->warehouses()
            ->where('warehouse_id', $warehouse_id)
            ->where('active', 1)
            ->where('stock', '>', 0)
            ->sum('stock');
    }




    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('etiquetas::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('etiquetas::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('etiquetas::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
