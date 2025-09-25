<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Requests\Tenant\ConfigurationRequest;
use App\Http\Resources\Tenant\ConfigurationResource;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Item;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\ItemCollection;
use App\Models\Tenant\Cash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Tenant\FormatTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Catalogs\DetractionType;
use App\Models\Tenant\ConfEstablishment;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\EstablishmentNotificationNumber;
use App\Models\Tenant\ExcludedUser;
use App\Models\Tenant\NumberActivity;
use App\Models\Tenant\User;
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
    public function app() {}
    public function saveNumbersEstablishments(Request $request)
    {
        try {
            $data = $request->payload;
            EstablishmentNotificationNumber::where('id', '!=', null)->delete();
            foreach ($data as $row) {
                EstablishmentNotificationNumber::create([
                    'establishment_id' => $row['establishment_id'],
                    'number' => $row['number_id']
                ]);
            }

            return [
                'success' => true,
                'message' => 'Números guardados correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al guardar los números: ' . $e->getMessage()
            ];
        }
    }
    public function recordConfigurationClient(Request $request)
    {
        // Obtener configuración y usuario
        $configuration = Configuration::first();
        $user = auth()->user() ?? auth('api')->user();

        // Obtener el ID de caja activa para el usuario
        $cash_id = $this->getActiveCashId($user);

        return [
            'affectation_igv_type_id' => $configuration->affectation_igv_type_id,
            'establishment_id' => $user->establishment_id,
            'cash_id' => $cash_id
        ];
    }

    /**
     */
    private function getActiveCashId($user)
    {
        $cash = Cash::where('user_id', $user->id)
            ->where('state', 1)
            ->first();

        if ($cash) {
            return $cash->id;
        }

        $cash = Cash::where('state', 1)->first();

        return $cash ? $cash->id : null;
    }
    public function tablesNumbersEstablishments(Request $request)
    {
        $establishments = Establishment::all()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => $row->description,
            ];
        });
        $numbers = NumberActivity::all();
        $records = EstablishmentNotificationNumber::all();
        return compact('records', 'establishments', 'numbers');
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
        $CategoryItem = [
            ['name' => 'IMSUMOS', 'identifier' => null, 'icono' => null, 'pos_drag' => false, 'user_id' => null, 'active' => 1, 'show_count_pos' => false, 'images' => null],

        ];

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

        $Item = [
            [
                'name' => null,
                'second_name' => null,
                'description' => 'VARIACION',
                'item_type_id' => '01',
                'internal_id' => '000ZZ',
                'barcode' => null,
                'barcode_type' => null,
                'item_code' => null,
                'date_of_due' => null,
                'account_id' => null,
                'item_code_gs1' => null,
                'unit_type_id' => 'ZZ',
                'currency_type_id' => 'PEN',
                'sale_unit_price' => 1,
                'has_igv' => false,
                'purchase_unit_price' => 0,
                'has_isc' => false,
                'commission_amount' => null,
                'commission_type' => null,
                'amount_plastic_bag_taxes' => 0.20,
                'system_isc_type_id' => null,
                'percentage_isc' => 0.00,
                'suggested_price' => 0.00,
                'sale_affectation_igv_type_id' => 20,
                'purchase_affectation_igv_type_id' => '20',
                'calculate_quantity' => false,
                'sale_unit_price_set' => null,
                'is_set' => false,
                'is_manufactured' => false,
                'category_id' => null,
                'brand_id' => null,
                'image' => 'imagen-no-disponible.jpg',
                'image_medium' => 'imagen-no-disponible.jpg',
                'image_small' => 'imagen-no-disponible.jpg',
                'is_stock' => 'Si',
                'stock' => 0,
                'stock_min' => 0.00,
                'lot_code' => null,
                'lots_enabled' => false,
                'series_enabled' => false,
                'percentage_of_profit' => 0.00,
                'has_perception' => false,
                'percentage_perception' => 0.00,
                'attributes' => json_encode([]),
                'active' => true,
                'location' => null,
                'warehouse_id' => null,
                'status' => 1,
                'apply_store' => 0,
                'max_quantity' => null,
                'max_quantity_description' => null,
                'has_orden_compra' => false,
                'is_promotion' => false,
                'promotion_count' => 0,
                'delivery_cost' => 0.00,
                'has_commercial_treatment' => true,
                'has_color_size' => false,
                'subject_to_detraction' => false,
                'weight' => 0.00,
                'model' => null,
                'quality' => null,
                'origin' => null,
                'points_value' => null,
                'has_warranty' => false,
                'month_day' => null,
                'init_report' => false,
                'commission' => 0.00,
                'codes_family' => false,
                'calculate_price' => false,

            ]
        ];

        foreach ($CategoryItem as $category) {
            $existingCategory = DB::connection('tenant')->table('categories')->where('name', $category['name'])->first();
            if (!$existingCategory) {
                DB::connection('tenant')->table('categories')->insert($category);
            }
        }

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

        /* foreach ($Item as $item) {
            $existingItem = DB::connection('tenant')->table('items')->where('description', $item['description'])->first();
            if (!$existingItem) {
                DB::connection('tenant')->table('items')->insert($item);
            }
        } */

        foreach ($Item as &$item) {
            // Asegurar que attributes no sea null ni array PHP
            if (is_array($item['attributes'])) {
                $item['attributes'] = json_encode($item['attributes']);
            } elseif (is_null($item['attributes'])) {
                $item['attributes'] = json_encode([]);
            }

            $existingItem = DB::connection('tenant')->table('items')
                ->where('description', $item['description'])
                ->first();

            if (!$existingItem) {
                DB::connection('tenant')->table('items')->insert($item);
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
            $worker_type_id = DB::connection('tenant')->table('areas')->where('description', 'MESA')->first();
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
    public function getUsersExcluded(Request $request)
    {
        $users = User::whereHas('excluded_user')->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
            ];
        });

        return compact('users');
    }
    public function addUserExcluded(Request $request)
    {
        $user_id = $request->input('user_id');
        $exist = ExcludedUser::where('user_id', $user_id)->first();
        if (!$exist) {
            $excluded_user = new ExcludedUser();
            $excluded_user->user_id = $user_id;
            $excluded_user->save();
        } else {
            return [
                'success' => false,
                'message' => 'Usuario ya se encuentra excluido'
            ];
        }
        return [
            'success' => true,
            'message' => 'Usuario excluido'
        ];
    }
    public function removeUserExcluded(Request $request)
    {
        $user_id = $request->input('user_id');
        $excluded_user = ExcludedUser::where('user_id', $user_id)->first();
        if ($excluded_user) {
            $excluded_user->delete();
        } else {
            return [
                'success' => false,
                'message' => 'Usuario no se encuentra excluido'
            ];
        }
        return [
            'success' => true,
            'message' => 'Usuario eliminado de la lista de excluidos'
        ];
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
        $warehouses = DB::connection('tenant')->table('warehouses')->get();
        $items = new ItemCollection(Item::where('id', '<>', null)->take(15)->get());
        $affectation_igv_types = AffectationIgvType::whereActive()->get();
        $item_id = Configuration::first()->item_variation_id;
        $detraction_types = DetractionType::all();
        $users = User::where('type', 'seller')->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
            ];
        });
        $item = null;
        if ($item_id) {
            $item = Item::find($item_id);
        }
        return compact('affectation_igv_types', 'items', 'item', 'detraction_types', 'users', 'warehouses');
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

    public function activateRestaurant(Request $request)
    {
        $configuration = Configuration::find(1);
        $configuration->restaurant = true;
        $configuration->save();

        ConfEstablishment::query()->update(['print_command' => 1]);

        return [
            'success' => true,
            'message' => 'Restaurante activado y configuraciones aplicadas'
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
