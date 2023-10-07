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
use Illuminate\Support\Facades\Storage;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

class EtiquetasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        
        return view('etiquetas::index');
    }

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
            $format = $request->format;
            $paper = $request->paper;
            $location = $request->location;
            $barcode = $request->barcode;
            $template = $format == '1' ? 'template' : ($format == '2' ? 'template2' : 'template4');



            $record = Item::find(1);

            $company = Company::first();

            $price = $record->sale_unit_price;
            $price = number_format($price,0, ".", "");

            $margin_top = 0;
            $margin_left = 0;
            $margin_right = 0;
            $margin_bottom = 0;
            if ($format == 1) {
                if ($paper == 1) {
                    $margin_top = 1;
                }
            }
            if ($format == 2) {
                if ($paper == 1) {

                    $margin_top = 1;
                }
            }
            $stock = $request->stock ?? 0;
            if($company->etiqueta != null ){
                $image = asset('storage' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . explode("/", $company->etiqueta)[2]);
            }else{
                $image = null ; 
            }
            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    $paper ==  1 ? 50 :  106,
                    25
                ],

                'margin_top' => $margin_top,
                'margin_right' => $margin_right,
                'margin_bottom' => $margin_bottom,
                'margin_left' => $margin_left
            ]);


            
            $html = view('etiquetas::' . $template, compact(
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
                'paper',
                'barcode',
                'is_code_128'
            ))->render();

            $pdf->WriteHTML($html);
            $pdf->output('etiquetas_' . now()->format('Y_m_d') . '.pdf', 'I');
        } catch (Exception $e) {
            return response($e, 500);
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

    public function delete_image(){
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

        return compact('palabras', 'codigos', 'company_name', 'etiqueta','establishment');
    }
    public function items(Request $request)
    {
        $input = $request->input("input");
        $items = Item::where("description", "like", "%" . $input . "%")->orWhere("internal_id", "like", "%" . $input . "%")->take(15)->get()
            ->transform(function ($row) {
                if ($row->internal_id != null && $row->type_barcode == "EAN-8") {
                    $row->internal_id = substr($row->internal_id, 0, -1);
                }
                return [
                    "id" => $row->id,
                    "descripcion" => $row->description,
                    "barras" => $row->internal_id,
                    "tipo_barras" => $row->barcode_type,
                    "stock" => $row->stock,
                    "price" => $row->sale_unit_price,
                    "purchase" => $row->purchase_unit_price,
                    "location" => $row->location,
                ];
            });
        return [
            "items" => $items
        ];
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
