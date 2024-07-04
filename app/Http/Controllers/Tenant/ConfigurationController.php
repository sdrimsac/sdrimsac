<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Requests\Tenant\ConfigurationRequest;
use App\Http\Resources\Tenant\ConfigurationResource;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Item;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ItemCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Tenant\FormatTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Catalogs\DetractionType;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Services\RoleService;
use Illuminate\Queue\Worker;

class ConfigurationController extends Controller
{
    public function create()
    {
        return view('tenant.configurations.form');
    }
    public function app()
    {
    }
    public function etiquetas(Request $request)
    {
        $configuration = Configuration::first();
        $etiquetas = $configuration->config_etiquetas;
        if (!$etiquetas) {
            $etiquetas = [];
        }

        // Convertir el request a un array
        $newEtiqueta = json_decode(json_encode($request->all()), true);

        $found = false;
        foreach ($etiquetas as $index => $etiqueta) {
            if (!is_array($etiqueta)) {
                continue;
            }
            if (
                $etiqueta['QSticker'] == $newEtiqueta['QSticker'] &&
                $etiqueta['modelType'] == $newEtiqueta['modelType'] && $etiqueta['paperType'] == $newEtiqueta['paperType']
            ) {
                $etiquetas[$index] = $newEtiqueta; // Reemplazar el objeto existente
                $found = true;
                break;
            }
        }
        if (!$found) {
            $etiquetas[] = $newEtiqueta; // Si no se encontró un objeto existente, agregar el nuevo objeto
        }

        $configuration->config_etiquetas = $etiquetas;
        $configuration->save();
        return [
            'success' => true,
            'message' => 'Configuración actualizada'
        ];
    }
    public function addSeeder()
    {
        $reiniciar =  DB::connection('tenant')->table('format_templates')
            ->truncate();
        $archivos = Storage::disk('core')->allDirectories('Templates/pdf');
        $colection = array();
        $valor = array();
        foreach ($archivos as $valor) {
            $lina = explode('/', $valor);
            if (count($lina) <= 3) {
                array_push($colection, $lina);
            }
        }

        foreach ($colection as $insertar) {
            $insertar =  DB::connection('tenant')->table('format_templates')
                ->insert(['formats' => $insertar[2]]);
        }

        return [
            'success' => true,
            'message' => 'Configuración actualizada'
        ];
    }

    public function changeFormat(Request $request)
    {
        $format = Configuration::first();
        $format->fill($request->all());
        $format->save();

        $config_format = config(['tenant.pdf_template' => $format->formats]);
        // $fp = fopen(base_path() .'/config/tenant.php' , 'w');
        // fwrite($fp, '<?php return ' . var_export(config('tenant'), true) . ';');
        // fclose($fp);
        return [
            'success' => true,
            'message' => 'Configuración actualizada'
        ];
    }

    public function getFormats()
    {
        $formats = DB::connection('tenant')->table('format_templates')->get();
        return $formats;
    }

    public function pdfTemplates()
    {
        return view('tenant.advanced.pdf_templates');
    }

    public function record()
    {
        $configuration = Configuration::first();
        $record = new ConfigurationResource($configuration);
        return  $record;
    }
    function check_and_set_restaurant()
    {
        $areas = [
            ['description' => 'BARRA', 'copies' => 0, 'printer' => null, 'active' => 1],
            ['description' => 'COCINA', 'copies' => 0, 'printer' => null, 'active' => 1],
            ['description' => 'MESA', 'copies' => 0, 'printer' => null, 'active' => 1]
        ];


        $workersType = [
            ['description' => 'MOZO', 'active' => 1],
            ['description' => 'COCINA', 'active' => 1],
            ['description' => 'BARMAN', 'active' => 1],
        ];

        foreach ($areas as $area) {
            $existingArea = DB::connection('tenant')->table('areas')->where('description', $area['description'])->first();
            if (!$existingArea) {
                DB::connection('tenant')->table('areas')->insert($area);
            }
        }
        foreach ($workersType as $workerType) {
            $existingWorkerType = DB::connection('tenant')->table('workers_type')->where('description', $workerType['description'])->first();
            if (!$existingWorkerType) {
                DB::connection('tenant')->table('workers_type')->insert($workerType);
            }
        }
        $users = [
            ['name' => 'BARRA', 'email' => null, 'password' => null, 'api_token' => null, 'establishment_id' => 1, 'locked' => 0, 'number' => 2, 'pin' => 5822, 'type' => 'seller', 'worker_type_id' => 4, 'area_id' => 1, 'active' => 1],
            ['name' => 'COCINA', 'email' => null, 'password' => null, 'api_token' => null, 'establishment_id' => 1, 'locked' => 0, 'number' => 3, 'pin' => 5725, 'type' => 'seller', 'worker_type_id' => 3, 'area_id' => 3, 'active' => 1],
            ['name' => 'MOZO', 'email' => null, 'password' => null, 'api_token' => null, 'establishment_id' => 1, 'locked' => 0, 'number' => 4, 'pin' => 7808, 'type' => 'seller', 'worker_type_id' => 2, 'area_id' => 4, 'active' => 1]
        ];
        foreach ($users as $user) {
            $existingUser = DB::connection('tenant')->table('users')->where('name', $user['name'])->first();
            if (!$existingUser) {
                $worker_type_id = $this->get_type_id($user['name']);
                $area_id = $this->get_area_id($user['name']);
                if ($worker_type_id && $area_id) {
                    $user['worker_type_id'] = $worker_type_id;
                    $user['area_id'] = $area_id;
                    DB::connection('tenant')->table('users')->insert($user);
                }
            }
        }
    }
    function get_area_id($name)
    {
        if ($name == 'MOZO') {
            $worker_type_id = DB::connection('tenant')->table('areas')->where('description', 'COCINA')->first();
            if ($worker_type_id) {
                return $worker_type_id->id;
            }
        }
        $worker_type_id = DB::connection('tenant')->table('areas')->where('description', $name)->first();
        if ($worker_type_id) {
            return $worker_type_id->id;
        }
        return null;
    }
    function get_type_id($name)
    {
        if ($name == 'BARRA') {
            $worker_type_id = DB::connection('tenant')->table('workers_type')->where('description', 'BARMAN')->first();
            if ($worker_type_id) {
                return $worker_type_id->id;
            }
        }
        $worker_type_id = DB::connection('tenant')->table('workers_type')->where('description', $name)->first();
        if ($worker_type_id) {
            return $worker_type_id->id;
        }
        return null;
    }
    public function store(ConfigurationRequest $request)
    {
        $id = $request->input('id');
        $configuration = Configuration::find($id);
        $configuration->fill($request->all());
        //dd($request->all());
        $configuration->save();

        if ($configuration->restaurant) {
            $this->check_and_set_restaurant();
        }

        return [
            'success' => true,
            'message' => 'Configuración actualizada',
            'data' => $configuration
        ];
    }


    public function icbper(Request $request)
    {


        DB::connection('tenant')->transaction(function () use ($request) {

            $id = $request->input('id');
            $configuration = Configuration::find($id);
            $configuration->amount_plastic_bag_taxes = $request->amount_plastic_bag_taxes;
            $configuration->save();


            $items = Item::get(['id', 'amount_plastic_bag_taxes']);

            foreach ($items as $item) {

                $item->amount_plastic_bag_taxes = $configuration->amount_plastic_bag_taxes;
                $item->update();
            }
        });

        return [
            'success' => true,
            'message' => 'Configuración actualizada'
        ];
    }


    public function tables()
    {

        $items = new ItemCollection(Item::where('id', '<>', null)->take(15)->get());
        $affectation_igv_types = AffectationIgvType::whereActive()->get();
        $item_id = Configuration::first()->item_variation_id;
        $detraction_types = DetractionType::all();
        $item = null;
        if ($item_id) {
            $item = Item::find($item_id);
        }
        return compact('affectation_igv_types', 'items', 'item', 'detraction_types');
    }

    public function visualDefaults()
    {
        $defaults = [
            'bg' => 'light',
            'header' => 'light',
            'sidebars' => 'light',
        ];
        $configuration = Configuration::first();
        $configuration->visual = $defaults;
        $configuration->save();

        return [
            'success' => true,
            'message' => 'Configuración actualizada'
        ];
    }

    public function visualSettings(Request $request)
    {
        $visuals = [
            'bg' => $request->bg,
            'header' => $request->header,
            'sidebars' => $request->sidebars,
        ];

        $configuration = Configuration::find(1);
        $configuration->visual = $visuals;
        $configuration->save();

        return [
            'success' => true,
            'message' => 'Configuración actualizada'
        ];
    }

    public function getSystemPhone()
    {
        $configuration = Configuration::first();
        $ws = $configuration->enable_whatsapp;

        // $current = url('/phone');
        // $parse_current = parse_url($current);
        // $explode_current = explode('.', $parse_current['host']);
        // $app_url = config('app.url');
        // if(!array_key_exists('port', $parse_current)){
        //     if (strpos($app_url, 'admin') !== false) {
        //        $path = $parse_current['scheme'].'://admin.'.config('tenant.app_url_base').$parse_current['path'];
        //     } else {
        //         $path = $parse_current['scheme'].'://'.config('tenant.app_url_base').$parse_current['path'];
        //     }
        // }else{
        //     if (strpos($app_url, 'admin') !== false) {
        //        $path = $parse_current['scheme'].'://admin.'.config('tenant.app_url_base').':'.$parse_current['port'].$parse_current['path'];
        //     } else {
        //         $path = $parse_current['scheme'].'://'.config('tenant.app_url_base').':'.$parse_current['port'].$parse_current['path'];
        //     }
        // }

        // $http = new Client(['verify' => false]);
        // $response = $http->request('GET', $path);
        // if($response->getStatusCode() == '200'){
        //     $body = $response->getBody();

        //     $configuration->phone_whatsapp = $body;
        //     $configuration->save();
        // }
        // return 'error';
    }
}
