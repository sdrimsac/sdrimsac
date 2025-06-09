<?php

namespace App\Http\Controllers\System;

use App\CoreFacturalo\Helpers\Certificate\GenerateCertificate;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\ClientRequest;
use App\Http\Resources\System\ClientCollection;
use App\Http\Resources\System\ClientResource;
use App\Models\System\Client;
use App\Models\System\Configuration;
use App\Models\System\Module;
use App\Models\System\Plan;
use Carbon\Carbon;
use Exception;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Document\Helpers\DocumentHelper;
use Modules\MobileApp\Models\System\AppModule;
use App\CoreFacturalo\ClientHelper;
use App\Models\System\ClientPayment;
use App\Models\System\MessageSendSchedule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{

    public function index()
    {
        return view('system.clients.index');
    }

    public function create()
    {
        return view('system.clients.form');
    }

    public function columns()
    {
        return [

            'hostname' => 'hostname',
            'name' => 'nombre',

        ];
    }
    public function sendPaymentsMessages(Request $request) {}
    public function clientEmitDocument(Request $request)
    {
        $configuration = Configuration::first();
        $document = $request->document;
        $document_emit_url = $configuration->document_emit_url;
        $document_emit_url_token = $configuration->document_emit_url_token;
        $url = rtrim($document_emit_url, '/');
        $token = $document_emit_url_token;

        try {
            // Agregar logging para debug
            Log::info("Realizando petición a: " . $url . "/api/documents");
            Log::info("Token: " . $token);
            Log::info("Documento: ", $document);

            $response = Http::withoutVerifying()
                ->withToken($token)
                ->post($url . "/api/documents-client", [
                    "document" => $document
                ]);

            if (!$response->successful()) {
                Log::error("Error en la respuesta: " . $response->body());
                return response()->json([
                    'success' => false,
                    'message' => 'Error en la petición: ' . $response->status(),
                    'response' => $response->body()
                ], $response->status());
            }

            $responseData = $response->json();

            if (empty($responseData)) {
                Log::warning("Respuesta vacía del servidor");
                return response()->json([
                    'success' => false,
                    'message' => 'La respuesta del servidor está vacía'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $responseData
            ]);
        } catch (\Exception $e) {
            Log::error("Error en clientEmitDocument: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function affectationTenant()
    {
        $configuration = Configuration::first();
        $document_emit_url = $configuration->document_emit_url;
        $document_emit_url_token = $configuration->document_emit_url_token;
        $affectation_tenant = null;
        $cash_id = null;
        try {
            if ($document_emit_url && $document_emit_url_token) {

                $url = rtrim($document_emit_url, '/');
                $token = $document_emit_url_token;

                $response = Http::withoutVerifying()->withToken($token)->get($url . "/api/configurations-client");
                $data = $response->json();
                Log::info($response->body());
                if ($data['affectation_igv_type_id']) {
                    $affectation_tenant = $data['affectation_igv_type_id'];
                }
                if ($data['cash_id']) {
                    $cash_id = $data['cash_id'];
                }
                return response()->json([
                    'affectation_tenant' => $affectation_tenant,
                    'cash_id' => $cash_id
                ]);
                // $affectation_tenant = $response['affectation_tenant'];
            }
            return response()->json([
                'affectation_tenant' => $affectation_tenant
            ]);
        } catch (\Exception $e) {
            Log::error("Error en affectationTenant: " . $e->getMessage());
            return response()->json([
                'affectation_tenant' => $affectation_tenant
            ]);
        }
    }
    public function tables()
    {

        $url_base = '.' . config('tenant.app_url_base');
        $plans = Plan::all();
        $types = [['type' => 'admin', 'description' => 'Administrador'], ['type' => 'integrator', 'description' => 'Listar Documentos']];
        $modules = Module::with('levels')
            ->where('sort', '<', 14)
            ->orderBy('sort')
            ->get()
            ->each(function ($module) {
                return $this->prepareModules($module);
            });

        $apps = Module::with('levels')
            ->where('sort', '>', 13)
            ->orderBy('sort')
            ->get()
            ->each(function ($module) {
                return $this->prepareModules($module);
            });

        // luego se podria crear grupos mediante algun modulo, de momento se pasan los id de manera directa
        $group_basic = Module::with('levels')
            ->whereIn('id', [7, 1, 6, 17, 18, 5, 14])
            ->orderBy('sort')
            ->get()
            ->each(function ($module) {
                return $this->prepareModules($module);
            });
        $group_hotel = Module::with('levels')
            ->whereIn('id', [7, 1, 6, 17, 18, 5, 14, 8, 4])
            ->orderBy('sort')
            ->get()
            ->each(function ($module) {
                return $this->prepareModules($module);
            });
        $group_pharmacy = Module::with('levels')
            ->whereIn('id', [7, 1, 6, 17, 18, 5, 14, 8, 4])
            ->orderBy('sort')
            ->get()
            ->each(function ($module) {
                return $this->prepareModules($module);
            });
        $group_restaurant = Module::with('levels')
            ->whereIn('id', [7, 1, 6, 17, 18, 5, 14, 8, 4])
            ->orderBy('sort')
            ->get()
            ->each(function ($module) {
                return $this->prepareModules($module);
            });
        $group_hotel_apps = Module::with('levels')
            ->whereIn('id', [15])
            ->orderBy('sort')
            ->get()
            ->each(function ($module) {
                return $this->prepareModules($module);
            });
        $group_pharmacy_apps = Module::with('levels')
            ->whereIn('id', [19])
            ->orderBy('sort')
            ->get()
            ->each(function ($module) {
                return $this->prepareModules($module);
            });
        $group_restaurant_apps = Module::with('levels')
            ->whereIn('id', [23])
            ->orderBy('sort')
            ->get()
            ->each(function ($module) {
                return $this->prepareModules($module);
            });

        $config = Configuration::first();

        $certificate_admin = $config->certificate;
        $soap_username = $config->soap_username;
        $soap_password = $config->soap_password;
        $regex_password_client = $config->regex_password_client;

        return compact(
            'url_base',
            'plans',
            'types',
            'modules',
            'apps',
            'certificate_admin',
            'soap_username',
            'soap_password',
            'group_basic',
            'group_hotel',
            'group_pharmacy',
            'group_restaurant',
            'group_hotel_apps',
            'group_pharmacy_apps',
            'regex_password_client',
            'group_restaurant_apps'
        );
    }

    public function changeLimitMonthAmount(Request $request)
    {
        $client = Client::findOrFail($request->id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($client->hostname->website);

        DB::connection('tenant')
            ->table('companies')
            ->where('id', 1)
            ->update(['limit_month_amount' => $request->limit_month_amount]);

        return response()->json([
            'success' => true,
            'message' => 'Monto de facturación por mes actualizado correctamente'
        ]);
    }
    private function prepareModules(Module $module): Module
    {
        $levels = [];
        foreach ($module->levels as $level) {
            array_push($levels, [
                'id' => "{$module->id}-{$level->id}",
                'description' => $level->description,
                'module_id' => $level->module_id,
                'is_parent' => false,
            ]);
        }
        unset($module->levels);
        $module->is_parent = true;
        $module->childrens = $levels;
        return $module;
    }

    public function records(Request $request)
    {
        if (strpos(url()->current(), 'sdrimsac') !== false) {
            $canSee = true;
        }

        $query = Client::query();

        if ($request->has('column') && $request->column === 'name' && $request->has('value') && $request->value) {
            $query->where('name', 'like', "%{$request->value}%");
        }
        if ($request->has('column') && $request->column === 'hostname' && $request->has('value') && $request->value) {
            $query->whereHas('hostname', function ($q) use ($request) {
                $q->where('fqdn', 'like', "%{$request->value}%");
            });
        }

        $records = $query->latest()->paginate(100);

        $totalClients = $query->count();

        foreach ($records as $row) {
            $tenancy = app(Environment::class);
            $tenancy->tenant($row->hostname->website);
            $row->limit_month_amount = DB::connection('tenant')
                ->table('companies')
                ->where('id', 1)
                ->first()
                ->limit_month_amount ?? 0;
            $row->count_doc = DB::connection('tenant')
                ->table('configurations')
                ->first()
                ->quantity_documents;

            $row->soap_type = DB::connection('tenant')
                ->table('companies')
                ->first()
                ->soap_type_id;

            $row->count_user = DB::connection('tenant')
                ->table('users')
                ->count();
            $row->company_number = DB::connection('tenant')
                ->table('companies')
                ->first()
                ->number;
            $row->company_name = DB::connection('tenant')
                ->table('companies')
                ->first()
                ->name;
            $row->count_sales_notes = 0;
            $quantity_pending_documents = $this->getQuantityPendingDocuments();

            $row->document_not_sent = $quantity_pending_documents['document_not_sent'];
            $row->document_to_be_canceled = $quantity_pending_documents['document_to_be_canceled'];
            $row->monthly_sales_total = 0;

            if ($row->start_billing_cycle) {
                $start_end_date = DocumentHelper::getStartEndDateForFilterDocument($row->start_billing_cycle);
                $init = $start_end_date['start_date'];
                $end = $start_end_date['end_date'];

                $row->count_doc_month = DB::connection('tenant')
                    ->table('documents')
                    ->whereBetween('date_of_issue', [$init, $end])
                    ->count();

                $row->count_sales_notes_month = DB::connection('tenant')
                    ->table('sale_notes')
                    ->whereBetween('date_of_issue', [$init, $end])
                    ->count();

                $row->count_sales_notes = 0;

                $client_helper = new ClientHelper();
                $row->monthly_sales_total = $client_helper->getSalesTotal($init->format('Y-m-d'), $end->format('Y-m-d'), $row->plan);
            }

            $row->imgClient = DB::connection('tenant')
                ->table('companies')
                ->select('logo')
                ->first()
                ->logo;

            $row->quantity_establishments = $this->getQuantityRecordsFromTable('establishments');
        }

        $clientCollection = new ClientCollection($records);

        $clientCollection->additional([
            'totalClients' => $totalClients,
            'canSee' => $canSee ?? false,
        ]);

        return $clientCollection;
    }


    /**
     *
     * @param  string $table
     * @return int
     */
    private function getQuantityRecordsFromTable($table)
    {
        return DB::connection('tenant')->table($table)->count();
    }


    private function getQuantityPendingDocuments()
    {

        return [
            // 'document_regularize_shipping' => DB::connection('tenant')->table('documents')->where('state_type_id', '01')->where('regularize_shipping', true)->count(),
            'document_not_sent' => DB::connection('tenant')->table('documents')
                ->where('soap_type_id', '02')
                ->whereIn('state_type_id', ['01', '03'])->where('date_of_issue', '<=', date('Y-m-d'))->count(),
            'document_to_be_canceled' => DB::connection('tenant')->table('documents')
                ->where('soap_type_id', '02')
                ->where('state_type_id', '13')->count(),
        ];
    }

    public function record($id)
    {
        $client = Client::findOrFail($id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($client->hostname->website);
        $user_id = 1;
        // Se buscan los valores en las tablas de los clientes, luego se compara con las tablas de admin para mostrar
        // correctamente la seleccion en la seccion de modulos de permisos
        // $modules = DB::connection('tenant')
        //     ->table('modules')
        //     ->where('modules.order_menu', '<=', 13)
        //     ->join('module_user', 'module_user.module_id', '=', 'modules.id')
        //     ->where('module_user.user_id', $user_id)
        //     ->select('modules.value as value')
        //     ->get()
        //     ->pluck('value');
        // $client->modules = DB::connection('system')
        //     ->table('modules')
        //     ->wherein('value', $modules)
        //     ->select('id')
        //     ->distinct()
        //     ->get()
        //     ->pluck('id');

        // Se buscan los valores en las tablas de los clientes, luego se compara con las tablas de admin para mostrar
        // correctamente la seleccion en la seccion de modulos de permisos
        // Apps
        // $apps = DB::connection('tenant')
        //     ->table('modules')
        //     ->where('modules.order_menu', '>', 13)
        //     ->join('module_user', 'module_user.module_id', '=', 'modules.id')
        //     ->where('module_user.user_id', $user_id)
        //     ->select('modules.value as value')
        //     ->get()
        //     ->pluck('value');

        // $client->apps = DB::connection('system')
        //     ->table('modules')
        //     ->wherein('value', $apps)
        //     ->select('id')
        //     ->distinct()
        //     ->get()
        //     ->pluck('id');

        // Se buscan los valores en las tablas de los clientes, luego se compara con las tablas de admin para mostrar
        // correctamente la seleccion en la seccion de modulos de permisos
        // $levels = DB::connection('tenant')
        //     ->table('module_level_user')
        //     ->where('module_level_user.user_id', $user_id)
        //     ->join('module_levels', 'module_levels.id', '=', 'module_level_user.module_level_id')
        //     ->get()
        //     ->pluck('value');

        // $client->levels = DB::connection('system')
        //     ->table('module_levels')
        //     ->wherein('value', $levels)
        //     ->select('id')
        //     ->distinct()
        //     ->get()
        //     ->pluck('id');

        $config = DB::connection('tenant')
            ->table('configurations')
            ->first();

        $client->config_system_env = $config->config_system_env;

        $company = DB::connection('tenant')
            ->table('companies')
            ->first();

        $client->soap_send_id = $company->soap_send_id;
        $client->soap_type_id = $company->soap_type_id;
        $client->soap_username = $company->soap_username;
        $client->soap_password = $company->soap_password;
        $client->soap_url = $company->soap_url;
        $client->certificate = $company->certificate;
        $client->number = $company->number;

        return new ClientResource($client);
    }

    public function charts()
    {
        $records = Client::all();
        $count_documents = [];
        foreach ($records as $row) {
            $tenancy = app(Environment::class);
            $tenancy->tenant($row->hostname->website);
            for ($i = 1; $i <= 12; $i++) {
                $date_initial = Carbon::parse(date('Y') . '-' . $i . '-1');
                $year_before = Carbon::now()->subYear()->format('Y');
                $date_final = Carbon::parse(date('Y') . '-' . $i . '-' . cal_days_in_month(CAL_GREGORIAN, $i, $year_before));
                $count_documents[] = [
                    'client' => $row->number,
                    'month' => $i,
                    'count' => $row->count_doc = DB::connection('tenant')
                        ->table('documents')
                        ->whereBetween('date_of_issue', [$date_initial, $date_final])
                        ->count()
                ];
            }
        }

        $total_documents = collect($count_documents)->sum('count');

        $groups_by_month = collect($count_documents)->groupBy('month');
        $labels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'];
        $documents_by_month = [];
        foreach ($groups_by_month as $month => $group) {
            $documents_by_month[] = $group->sum('count');
        }

        $line = [
            'labels' => $labels,
            'data' => $documents_by_month
        ];

        return compact('line', 'total_documents');
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function update(Request $request)
    {
        /**
         * @var Collection $valueModules
         * @var Collection $valueLevels
         */
        $user_id = 1;
        $array_modules = [];
        $array_levels = [];


        $smtp_host = ($request->has('smtp_host')) ? $request->smtp_host : null;
        $smtp_password = ($request->has('smtp_password')) ? $request->smtp_password : null;
        $smtp_port = ($request->has('smtp_port')) ? $request->smtp_port : null;
        $smtp_user = ($request->has('smtp_user')) ? $request->smtp_user : null;
        $smtp_encryption = ($request->has('smtp_encryption')) ? $request->smtp_encryption : null;
        try {

            $temp_path = $request->input('temp_path');

            $name_certificate = $request->input('certificate');

            if ($temp_path) {

                try {
                    $password = $request->input('password_certificate');
                    $pfx = file_get_contents($temp_path);
                    $pem = GenerateCertificate::typePEM($pfx, $password);
                    $name = 'certificate_' . $request->input('number') . '.pem';
                    if (!file_exists(storage_path('app' . DIRECTORY_SEPARATOR . 'certificates'))) {
                        mkdir(storage_path('app' . DIRECTORY_SEPARATOR . 'certificates'));
                    }
                    file_put_contents(storage_path('app' . DIRECTORY_SEPARATOR . 'certificates' . DIRECTORY_SEPARATOR . $name), $pem);
                    $name_certificate = $name;
                } catch (Exception $e) {
                    return [
                        'success' => false,
                        'message' => $e->getMessage()
                    ];
                }
            }


            $client = Client::findOrFail($request->id);

            $client
                ->setSmtpHost($smtp_host)
                ->setSmtpPort($smtp_port)
                ->setSmtpUser($smtp_user)
                //    ->setSmtpPassword($smtp_password)
                ->setSmtpEncryption($smtp_encryption);
            if (!empty($smtp_password)) {
                $client->setSmtpPassword($smtp_password);
            }
            $client->phone = $request->phone;
            $client->plan_id = $request->plan_id;
            $client->group_whatsapp = $request->group_whatsapp;
            $client->sent_to_group = $request->sent_to_group;
            $client->save();

            $plan = Plan::find($request->plan_id);

            $tenancy = app(Environment::class);
            $tenancy->tenant($client->hostname->website);
            $clientData = [
                'plan' => json_encode($plan),
                'config_system_env' => $request->config_system_env,
                'limit_documents' => $plan->limit_documents,
                'smtp_host' => $client->smtp_host,
                'smtp_port' => $client->smtp_port,
                'smtp_user' => $client->smtp_user,
                'smtp_password' => $client->smtp_password,
                'smtp_encryption' => $client->smtp_encryption,
            ];
            if (empty($client->smtp_password)) unset($clientData['smtp_password']);
            DB::connection('tenant')
                ->table('configurations')
                ->where('id', 1)
                ->update($clientData);

            DB::connection('tenant')
                ->table('companies')
                ->where('id', 1)
                ->update([
                    'soap_type_id' => $request->soap_type_id,
                    'soap_send_id' => $request->soap_send_id,
                    'soap_username' => $request->soap_username,
                    'soap_password' => $request->soap_password,
                    'soap_url' => $request->soap_url,
                    'certificate' => $name_certificate
                ]);


            //modules


            // // Actualiza el modulo de farmacia.
            // $config = (array)DB::connection('tenant')
            //     ->table('configurations')
            //     ->first();
            // // $config['is_pharmacy'] = (self::EnablePharmacy($user_id)) ? 1 : 0;
            // DB::connection('tenant')
            //     ->table('configurations')
            //     ->update($config);
            return [
                'success' => true,
                'message' => 'Cliente Actualizado satisfactoriamente',

            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
        }
    }

    /**
     * Devuelve la informacion si el modulo de farmacia esta habilitado o no para activar la configuracion
     * correspondiente
     *
     * @param int $user_id
     *
     * @return bool
     */
    public static function EnablePharmacy($user_id = 0)
    {
        $modulo_id = DB::connection('tenant')
            ->table('modules')
            ->where('value', 'digemid')
            ->first()->id;
        $modulo = DB::connection('tenant')
            ->table('module_user')
            ->where('module_id', $modulo_id)
            ->where('user_id', $user_id)
            ->first();

        return ($modulo == null) ? false : true;
    }

    public function store_migration(ClientRequest $request)
    {
        $subDom = strtolower($request->input('subdomain'));
        $uuid = config('tenant.prefix_database') . '_' . $subDom;
        $fqdn = $subDom . '.' . config('tenant.app_url_base');

        $website = new Website();
        $hostname = new Hostname();
        $this->validateWebsite($uuid, $website);

        DB::connection('system')->beginTransaction();
        try {
            $website->uuid = $uuid;
            app(WebsiteRepository::class)->create($website);
            $hostname->fqdn = $fqdn;
            app(HostnameRepository::class)->attach($hostname, $website);

            $tenancy = app(Environment::class);
            $tenancy->tenant($website);

            $token = str_random(50);

            $client = new Client();
            $client->hostname_id = $hostname->id;
            $client->token = $token;
            $client->email = strtolower($request->input('email'));
            $client->name = $request->input('name');
            $client->number = $request->input('number');
            $client->plan_id = $request->input('plan_id');
            $client->locked_emission = $request->input('locked_emission');
            $client->save();

            DB::connection('system')->commit();
            return [
                'success' => true,
                'message' => 'Cliente Registrado para migrar satisfactoriamente'
            ];
        } catch (Exception $e) {
            DB::connection('system')->rollBack();
            app(HostnameRepository::class)->delete($hostname, true);
            app(WebsiteRepository::class)->delete($website, true);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    public function storeScheduleVideos(Request $request)
    {
        $messages_send_schedule = $request->messages;

        foreach ($messages_send_schedule as $message_send_schedule) {
            MessageSendSchedule::updateOrCreate(
                ['id' => $message_send_schedule['id']],
                [
                    'send_day_at' => $message_send_schedule['send_day_at'],
                    'active' => $message_send_schedule['active']
                ]
            );
        }

        return [
            'success' => true,
            'message' => 'Mensaje de envío programado actualizado satisfactoriamente'
        ];
    }

    public function recordsScheduleVideos()
    {
        $message_send_schedules = MessageSendSchedule::all();

        return [
            'success' => true,
            'messages' => $message_send_schedules
        ];
    }

    public function store(ClientRequest $request)
    {
        $migration = $request->input('migration');
        $temp_path = $request->input('temp_path');
        $configuration = Configuration::first();

        $name_certificate = $configuration->certificate;

        if ($temp_path) {

            try {
                $password = $request->input('password_certificate');
                $pfx = file_get_contents($temp_path);
                $pem = GenerateCertificate::typePEM($pfx, $password);
                $name = 'certificate_' . 'admin_tenant' . '.pem';
                if (!file_exists(storage_path('app' . DIRECTORY_SEPARATOR . 'certificates'))) {
                    mkdir(storage_path('app' . DIRECTORY_SEPARATOR . 'certificates'));
                }
                file_put_contents(storage_path('app' . DIRECTORY_SEPARATOR . 'certificates' . DIRECTORY_SEPARATOR . $name), $pem);
                $name_certificate = $name;
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        }


        $subDom = strtolower($request->input('subdomain'));
        $uuid = config('tenant.prefix_database') . '_' . $subDom;
        $fqdn = $subDom . '.' . config('tenant.app_url_base');

        $website = new Website();
        $hostname = new Hostname();
        $this->validateWebsite($uuid, $website);

        DB::connection('system')->beginTransaction();
        try {
            $website->uuid = $uuid;
            app(WebsiteRepository::class)->create($website);
            $hostname->fqdn = $fqdn;
            app(HostnameRepository::class)->attach($hostname, $website);

            $tenancy = app(Environment::class);
            $tenancy->tenant($website);

            $token = str_random(50);

            $client = new Client();
            $client->hostname_id = $hostname->id;
            $client->token = $token;
            $client->email = strtolower($request->input('email'));
            $client->name = $request->input('name');
            $client->number = $request->input('number');
            $client->plan_id = $request->input('plan_id');
            $client->locked_emission = $request->input('locked_emission');
            $client->group_whatsapp = $request->input('group_whatsapp');
            $client->sent_to_group = $request->input('sent_to_group');
            $client->phone = $request->input('phone');

            $client->save();

            DB::connection('system')->commit();
        } catch (Exception $e) {
            DB::connection('system')->rollBack();
            app(HostnameRepository::class)->delete($hostname, true);
            app(WebsiteRepository::class)->delete($website, true);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        if ($migration) {

            return [
                'success' => true,
                'message' => 'Cliente Registrado satisfactoriamente'
            ];
        }

        $id = Website::where('uuid', $uuid)->first()->id;
        // Log::info('id: ' . $id);
        // try {
        //     $exitCode = Artisan::call('tenancy:migrate', [
        //         '--path' => 'migrations/tenant',
        //         '--website_id' => $id,
        //         '--quiet' => true,
        //     ]);
        //     if ($exitCode === 0) {
        //         $seed = true;
        //     }
        // } catch (Exception $e) {
        //     Log::error($e->getMessage());
        //     $seed = false;
        // }

        DB::connection('tenant')->table('companies')->insert([
            'identity_document_type_id' => '6',
            'number' => $request->input('number'),
            'name' => $request->input('name'),
            'trade_name' => $request->input('name'),
            'soap_type_id' => $request->soap_type_id,
            'soap_send_id' => $request->soap_send_id,
            'soap_username' => $request->soap_username,
            'soap_password' => $request->soap_password,
            'soap_url' => $request->soap_url,
            'certificate' => $name_certificate,
        ]);

        $plan = Plan::findOrFail($request->input('plan_id'));
        $http = config('tenant.force_https') == true ? 'https://' : 'http://';

        DB::connection('tenant')->table('configurations')->upsert([
            'id' => 1,
            'send_auto' => true,
            'locked_emission' => $request->input('locked_emission'),
            'locked_tenant' => false,
            'locked_users' => false,
            'limit_documents' => $plan->limit_documents,
            'limit_users' => $plan->limit_users,
            'plan' => json_encode($plan),
            'date_time_start' => date('Y-m-d H:i:s'),
            'quantity_documents' => 0,
            'config_system_env' => $request->config_system_env,
            'visual' => json_encode([
                'bg' => 'white',
                'header' => 'light',
                'navbar' => 'fixed',
                'sidebars' => 'light',
                'sidebar_theme' => 'white'
            ]),
            'formats' => 'trade_name',

        ], ['id']);


        $establishment_id =  DB::connection('tenant')->table('establishments')->insertGetId([
            'description' => 'Oficina Principal',
            'country_id' => 'PE',
            'department_id' => '15',
            'province_id' => '1501',
            'district_id' => '150101',
            'address' => '-',
            'email' => $request->input('email'),
            'telephone' => '-',
            'code' => '0000'
        ]);

        DB::connection('tenant')->table('warehouses')->insertGetId([
            'establishment_id' => 1,
            'description' => 'Almacén Oficina Principal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // DB::connection('tenant')->table('series')->insert([
        //     ['establishment_id' => 1, 'document_type_id' => '01', 'number' => 'F001'],
        //     ['establishment_id' => 1, 'document_type_id' => '03', 'number' => 'B001'],
        //     ['establishment_id' => 1, 'document_type_id' => '07', 'number' => 'FC01'],
        //     ['establishment_id' => 1, 'document_type_id' => '07', 'number' => 'BC01'],
        //     ['establishment_id' => 1, 'document_type_id' => '08', 'number' => 'FD01'],
        //     ['establishment_id' => 1, 'document_type_id' => '08', 'number' => 'BD01'],
        //     ['establishment_id' => 1, 'document_type_id' => '20', 'number' => 'R001'],
        //     ['establishment_id' => 1, 'document_type_id' => '09', 'number' => 'T001'],
        //     ['establishment_id' => 1, 'document_type_id' => '40', 'number' => 'P001'],
        //     ['establishment_id' => 1, 'document_type_id' => '80', 'number' => 'NV01'],

        // ]);


        $user_id = DB::connection('tenant')->table('users')->insert([
            'name' => 'Administrador',
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'api_token' => $token,
            'establishment_id' => $establishment_id,
            'type' => $request->input('type'),
            'locked' => true,
        ]);


        if ($request->input('type') == 'admin') {
            $array_modules = [];
            $array_levels = [];
            foreach ($request->modules as $module) {
                array_push($array_modules, [
                    'module_id' => $module,
                    'user_id' => $user_id
                ]);
            }
            foreach ($request->levels as $level) {
                array_push($array_levels, [
                    'module_level_id' => $level,
                    'user_id' => $user_id
                ]);
            }
            DB::connection('tenant')->table('module_user')->insert($array_modules);
            DB::connection('tenant')->table('module_level_user')->insert($array_levels);

            // $this->insertAppModules($user_id);

        } else {
            DB::connection('tenant')->table('module_user')->insert([
                ['module_id' => 1, 'user_id' => $user_id],
                ['module_id' => 3, 'user_id' => $user_id],
                ['module_id' => 5, 'user_id' => $user_id],
            ]);
        }

        // try {
        //     $exitCode = Artisan::call('tenancy:db:seed', [
        //         '--class' => 'TenantSeeder',
        //         '--website_id' => $id,
        //         '--quiet' => true,
        //     ]);
        //     if ($exitCode === 0) {
        //         $seed = true;
        //     }
        // } catch (Exception $e) {
        //     Log::error($e->getMessage());
        //     $seed = false;
        // }
        $this->setDefault();
        $message = 'Cliente Registrado satisfactoriamente';

        return [
            'success' => true,
            'message' => $message
        ];
    }
    function setDefault()
    {
        DB::connection('tenant')->table('series')->insert([
            ['establishment_id' => 1, 'document_type_id' => '01', 'number' => 'F001'],
            ['establishment_id' => 1, 'document_type_id' => '03', 'number' => 'B001'],
            ['establishment_id' => 1, 'document_type_id' => '07', 'number' => 'FC01'],
            ['establishment_id' => 1, 'document_type_id' => '07', 'number' => 'BC01'],
            ['establishment_id' => 1, 'document_type_id' => '08', 'number' => 'FD01'],
            ['establishment_id' => 1, 'document_type_id' => '08', 'number' => 'BD01'],
            ['establishment_id' => 1, 'document_type_id' => '20', 'number' => 'R001'],
            ['establishment_id' => 1, 'document_type_id' => '09', 'number' => 'T001'],
            ['establishment_id' => 1, 'document_type_id' => '40', 'number' => 'P001'],
            ['establishment_id' => 1, 'document_type_id' => '80', 'number' => 'NV01'],
        ]);
        DB::connection('tenant')->table('workers_type')->upsert([
            ['id' => 1, 'description' => 'CAJA', 'active' => 1],
            ['id' => 2, 'description' => 'CONTADOR', 'active' => 1]
            // ['id' => 2, 'description' => 'MOZO', 'active' => 1],
            // ['id' => 3, 'description' => 'COCINA', 'active' => 1],
            // ['id' => 4, 'description' => 'BARMAN', 'active' => 1],
        ], ['id'], ['description', 'active']);
        DB::connection('tenant')->table('areas')->upsert([
            // ['id' => 1, 'description' => 'BARRA',            'copies' => 0,            'printer' => null,            'active' => 1],
            ['id' => 2, 'description' => 'CAJA',            'copies' => 0,            'printer' => "POS-80-Series",            'active' => 1],
            // ['id' => 3, 'description' => 'COCINA',            'copies' => 0,            'printer' => null,            'active' => 1],
            // ['id' => 4, 'description' => 'MESA',            'copies' => 0,            'printer' => null,            'active' => 1]
        ], ['id']);

        // $token = str_random(50);
        // DB::connection('tenant')->table('users')->delete();
        DB::connection('tenant')->table('users')->upsert([
            ['id' => 1, 'name' => 'Administrador', 'email' => "admin@gmail.xyz",       'password' => bcrypt("teros"),              'api_token' => str_random(50), 'establishment_id' => 1,  'locked' => true, 'number' => null,          'pin' => 159357, 'type' => 'admin', 'worker_type_id' => null, 'area_id' =>    null, 'active' =>    1],
            ['id' => 2, 'name' => 'Soporte',    'email' => "admin@sdrimsac.xyz",    'password' => bcrypt("Sdr147258369"),       'api_token' => str_random(50), 'establishment_id' => 1,  'locked' => true, 'number' => null,       'pin' => 205687,    'type' => 'superadmin', 'worker_type_id' => null, 'area_id' =>    null, 'active' =>    1],
            ['id' => 3, 'name' => 'Contador',      'email' => "contador@sdrimsac.xyz", 'password' => bcrypt("12345"),              'api_token' => str_random(50), 'establishment_id' => 1,      'locked' => true, 'number' => null,       'pin' => 12345, 'type' => 'seller', 'worker_type_id' => 2, 'area_id' =>    null, 'active' =>    1],
            ['id' => 4, 'name' =>     'CAJA',    'email' => null, 'password' => null,   'api_token' => null,     'establishment_id' =>    1, 'locked' =>    0,                                                                      'number' =>        1,     'pin' => 8800, 'type'    => 'seller', 'worker_type_id' =>    1, 'area_id' =>    2, 'active' =>    1],
            // ['id' => 5, 'name' =>     'BARRA',        'email' => null, 'password' => null,   'api_token' => null,     'establishment_id' =>    1, 'locked' =>    0,                                                                      'number' =>        2,     'pin' => 5822, 'type'    => 'seller', 'worker_type_id' =>    4, 'area_id' =>    1, 'active' =>    1],
            // ['id' => 6, 'name' =>     'COCINA',        'email' => null, 'password' => null,   'api_token' => null,     'establishment_id' =>    1, 'locked' =>    0,                                                                      'number' =>        3,     'pin' => 5725, 'type'    => 'seller', 'worker_type_id' =>    3, 'area_id' =>    3, 'active' =>    1],
            // ['id' => 7, 'name' =>     'MOZO',    'email' => null, 'password' => null,   'api_token' => null,     'establishment_id' =>    1, 'locked' =>    0,                                                                      'number' =>        4,     'pin' => 7808, 'type'    => 'seller', 'worker_type_id' =>    2, 'area_id' =>    4, 'active' =>    1]


        ], ['id']);

        DB::connection('tenant')->table('status_table')->upsert([
            [
                'id' => '1',
                'description' => "Libre",
                'active' => true
            ],
            [
                'id' => '2',
                'description' => "Ocupado",
                'active' => true
            ],
            [
                'id' => '3',
                'description' => "En mantenimiento",
                'active' => true
            ]
        ], 'id');



        DB::connection('tenant')->table('status_orden')->upsert([
            [
                'id' => '1',
                'description' => "Solicitado"
            ],
            [
                'id' => '2',
                'description' => "Preparando"
            ],
            [
                'id' => '3',
                'description' => "Listo"
            ],
            [
                'id' => '4',
                'description' => "Atendido"
            ]
        ], ['id']);


        DB::connection('tenant')->table('group')->upsert([
            'id' => '1',
            'group' => "Ingresos",
            'type'        => 1
        ], ['id']);


        DB::connection('tenant')->table('group')->upsert([
            'id' => '2',
            'group' => "Egresos",
            'type'        => 2
        ], ['id']);

        DB::connection('tenant')->table('category')->upsert([
            'id' => '1',
            'category' => "Ventas",
            'type'        => 1
        ], ['id']);

        DB::connection('tenant')->table('category')->upsert([
            'id' => '2',
            'category' => "Egresos",
            'type'        => 2
        ], ['id']);

        DB::connection('tenant')->table('subcategories')->upsert([
            'id' => '1',
            'subcategory' => "Ventas",
            'type'        => 1
        ], ['id']);




        // DB::connection('tenant')->table('companies')->insert([
        //     'identity_document_type_id' => '6',
        //     'number' => "12345678901",
        //     'name' => "COMPANY DEMO",
        //     'trade_name' => "",
        //     'soap_type_id' => "01",
        //     'soap_send_id' => "01",
        //     'soap_username' => "",
        //     'soap_password' => "",
        //     'soap_url' => "",
        //     'certificate' => "",
        // ]);



        DB::connection('tenant')->table('persons')->delete();
        DB::connection('tenant')->table('persons')->insert([
            ['id' => 1, 'type' => 'customers', 'identity_document_type_id' =>    1, 'number' =>    99999999, 'name' =>    'CLIENTES VARIOS', 'trade_name' => null,                 'country_id' =>  'PE', 'department_id' => 12, 'province_id' => 1203, 'district_id' => 120303,    'perception_agent' => 0, 'percentage_perception' => 0, 'enabled' =>    1, 'seller_id' =>    1, 'created_at' =>    '2022-06-02 22:48:07', 'updated_at' => '2022-06-02 22:48:07', 'status' =>    1],
            ['id' => 2, 'type' => 'suppliers', 'identity_document_type_id' =>    0, 'number' =>    99999999, 'name' =>    'PROVEEDOR - Varios', 'trade_name' => 'Inicio de stock', 'country_id' =>  'PE',    'department_id'    => null,     'province_id' => null, 'district_id' => NULL,    'perception_agent' => 0, 'percentage_perception' => 0, 'enabled' =>    1, 'seller_id' =>    1, 'created_at' =>    '2022-06-07 16:43:09', 'updated_at' => '2022-06-07 16:43:09', 'status' =>    1]
        ]);
        $establishment = DB::connection('tenant')->table('establishments')->first();

        if ($establishment) {
            DB::connection('tenant')->table('establishments')->where('id', $establishment->id)
                ->update(['customer_id' => 1]);
        }

        DB::connection('tenant')->table('turns')->insert([
            ['turn_desc' => 'MAÑANA', 'turn_active' => 1],
            ['turn_desc' => 'TARDE', 'turn_active' => 1],
            ['turn_desc' => 'NOCHE', 'turn_active' => 1]

        ]);
        DB::connection('tenant')->table('status_orden')->insert([

            ['id' => 5, 'description' => 'Anulado',  'active' => 1],
        ]);
        DB::connection('tenant')->table('persons')->insert(
            [[
                'type' => 'customers',
                'identity_document_type_id' => 1,
                'number' => 88888888,
                'name' => 'CLIENTES VARIOS-MODIFICADO',
                'country_id' => 'PE',
                'perception_agent' => 0,
                'enabled' => 1,
                'status' => 1,


            ]]
        );
        DB::connection('tenant')->table('college_degrees')->insert([
            ['description' => '1RO', 'active' => 1],
            ['description' => '2DO', 'active' => 1],
            ['description' => '3RO', 'active' => 1],
            ['description' => '4TO', 'active' => 1],
            ['description' => '5TO', 'active' => 1],
            ['description' => '6TO', 'active' => 1],
            ['description' => '7MO', 'active' => 1]
        ]);

        DB::connection('tenant')->table('college_sections')->insert([
            ['description' => 'A', 'active' => 1],
            ['description' => 'B', 'active' => 1],
            ['description' => 'C', 'active' => 1],
            ['description' => 'D', 'active' => 1],
            ['description' => 'E', 'active' => 1],
            ['description' => 'F', 'active' => 1],
            ['description' => 'G', 'active' => 1],
            ['description' => 'H', 'active' => 1]
        ]);


        DB::connection('tenant')->table('college_levels')->insert([
            ['description' => 'INICIAL', 'active' => 1],
            ['description' => 'PRIMARIA', 'active' => 1],
            ['description' => 'SECUNDARIA', 'active' => 1],
        ]);


        DB::connection('tenant')->table('college_turns')->insert([
            ['description' => 'MAÑANA', 'active' => 1],
            ['description' => 'TARDE', 'active' => 1],
            ['description' => 'NOCHE', 'active' => 1],
        ]);

        DB::connection('tenant')->table('college_plan_types')->insert([
            ['description' => 'MATRICULA', 'active' => 1],
            ['description' => 'MENSUALIDAD', 'active' => 1],
            ['description' => 'OTROS', 'active' => 1],
        ]);

        DB::connection('tenant')->table('college_periods')->insert([
            ['description' => 'ANUAL', 'default_count' => 1, 'active' => 1],
            ['description' => 'MENSUAL', 'default_count' => 12, 'active' => 1],
        ]);

        DB::connection('tenant')->table('college_plans')->insert([
            ['name' => 'OTROS', 'description' => 'ADQUISICION', 'period_id' => 1, 'type_id' => 3, 'count' => 1, 'days_extension' => 0, 'active' => 1],
        ]);
    }

    public function validateWebsite($uuid, $website)
    {

        $exists = $website::where('uuid', $uuid)->first();

        if ($exists) {
            throw new Exception("El subdominio ya se encuentra registrado");
        }
    }


    /**
     *
     * Registrar modulos de la app al usuario principal
     *
     * @param  int $user_id
     * @return void
     */
    // private function insertAppModules($user_id)
    // {
    //     $all_app_modules = AppModule::get()->map(function ($row) use ($user_id) {
    //         return [
    //             'app_module_id' => $row->id,
    //             'user_id' => $user_id,
    //         };
    //     })->toArray();

    //     DB::connection('tenant')->table('app_module_user')->insert($all_app_modules);
    // }


    public function renewPlan(Request $request)
    {

        // dd($request->all());
        $client = Client::findOrFail($request->id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($client->hostname->website);

        DB::connection('tenant')->table('billing_cycles')->insert([
            'date_time_start' => date('Y-m-d H:i:s'),
            'renew' => true,
            'quantity_documents' => DB::connection('tenant')->table('configurations')->where('id', 1)->first()->quantity_documents,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::connection('tenant')->table('configurations')->where('id', 1)->update(['quantity_documents' => 0]);
        // DB::connection('tenant')->table('configurations')->where('id', 1)->update(['quantity_sales_notes' => 0]);


        return [
            'success' => true,
            'message' => 'Plan renovado con exito'
        ];
    }


    public function lockedUser(Request $request)
    {

        $client = Client::findOrFail($request->id);
        $client->locked_users = $request->locked_users;
        $client->save();

        $tenancy = app(Environment::class);
        $tenancy->tenant($client->hostname->website);
        DB::connection('tenant')->table('configurations')->where('id', 1)->update(['locked_users' => $client->locked_users]);

        return [
            'success' => true,
            'message' => ($client->locked_users) ? 'Limitar creación de usuarios activado' : 'Limitar creación de usuarios desactivado'
        ];
    }

    public function lockedEmission(Request $request)
    {

        $client = Client::findOrFail($request->id);
        $client->locked_emission = $request->locked_emission;
        $client->save();

        $tenancy = app(Environment::class);
        $tenancy->tenant($client->hostname->website);
        DB::connection('tenant')->table('configurations')->where('id', 1)->update(['locked_emission' => $client->locked_emission]);

        return [
            'success' => true,
            'message' => ($client->locked_emission) ? 'Limitar emisión de documentos activado' : 'Limitar emisión de documentos desactivado'
        ];
    }


    public function lockedTenant(Request $request)
    {

        $client = Client::findOrFail($request->id);
        $client->locked_tenant = $request->locked_tenant;
        $client->save();

        $tenancy = app(Environment::class);
        $tenancy->tenant($client->hostname->website);
        DB::connection('tenant')->table('configurations')->where('id', 1)->update(['locked_tenant' => $client->locked_tenant]);

        return [
            'success' => true,
            'message' => ($client->locked_tenant) ? 'Cuenta bloqueada' : 'Cuenta desbloqueada'
        ];
    }


    /**
     *
     * Validar si el valor de confirmacion ingresado por el usuario es
     * igual al ruc o nombre de la empresa, para poder eliminar el cliente
     *
     * @param  Client $client
     * @param  string $input_validate
     * @return array
     */
    public function checkInputValidateDelete(Client $client, $input_validate)
    {

        if ($input_validate === $client->name || $input_validate === $client->number) {
            return $this->generalResponse(true);
        }

        return $this->generalResponse(false, 'El valor ingresado no coincide con el nombre o número de ruc de la empresa.');
    }


    /**
     *
     * Eliminar cliente
     *
     * @param  int $id
     * @param  string $input_validate
     * @return array
     */
    public function destroy($id, $input_validate)
    {
        $client = Client::find($id);

        $check_input_validate_delete = $this->checkInputValidateDelete($client, $input_validate);
        if (!$check_input_validate_delete['success']) return $check_input_validate_delete;

        if ($client->locked) {
            return [
                'success' => false,
                'message' => 'Cliente bloqueado, no puede eliminarlo'
            ];
        }

        $hostname = Hostname::find($client->hostname_id);
        $website = Website::find($hostname->website_id);

        app(HostnameRepository::class)->delete($hostname, true);
        app(WebsiteRepository::class)->delete($website, true);

        return [
            'success' => true,
            'message' => 'Cliente eliminado con éxito'
        ];
    }

    public function password($id)
    {
        $client = Client::find($id);
        $website = Website::find($client->hostname->website_id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($website);
        DB::connection('tenant')->table('users')
            ->where('id', 1)
            ->update(['password' => bcrypt($client->number)]);

        return [
            'success' => true,
            'message' => 'Clave cambiada con éxito'
        ];
    }

    public function startBillingCycle(Request $request)
    {
        $client = Client::findOrFail($request->id);
        $client->start_billing_cycle = $request->start_billing_cycle;
        $client->save();

        return [
            'success' => true,
            'message' => ($client->start_billing_cycle) ? 'Ciclo de Facturacion definido.' : 'No se pudieron guardar los cambios.'
        ];
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Validar que sea un archivo MP4 y menor a 10MB
            if ($file->getClientMimeType() !== 'video/mp4') {
                return [
                    'success' => false,
                    'message' => 'Solo se permiten archivos MP4'
                ];
            }

            if ($file->getSize() > 10485760) { // 10MB en bytes
                return [
                    'success' => false,
                    'message' => 'El archivo debe ser menor a 10MB'
                ];
            }

            $temp = tempnam(sys_get_temp_dir(), 'video');
            file_put_contents($temp, file_get_contents($file));

            return [
                'success' => true,
                'data' => [
                    'filename' => $file->getClientOriginalName(),
                    'temp_path' => $temp,
                    'preview_url' => 'data:video/mp4;base64,' . base64_encode(file_get_contents($temp))
                ]
            ];
        }
        return [
            'success' => false,
            'message' =>  'Error al subir el archivo',
        ];
    }

    public function storeVideos(Request $request)
    {
        try {
            $configuration = Configuration::first();

            // Procesar video antes del vencimiento
            if ($request->before_temp_path) {
                $before_path = $this->uploadVideo($request->before_temp_path, 'before');
                $configuration->before_video_url = $before_path;
            }

            // Procesar video después del vencimiento  
            if ($request->after_temp_path) {
                $after_path = $this->uploadVideo($request->after_temp_path, 'after');
                $configuration->after_video_url = $after_path;
            }

            $configuration->save();

            return [
                'success' => true,
                'message' => 'Videos guardados correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function uploadVideo($temp_path, $prefix)
    {
        if (!file_exists($temp_path)) {
            throw new \Exception('No se encontró el archivo temporal');
        }

        $directory = 'public/uploads/videos';
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        $file_content = file_get_contents($temp_path);
        $file_name = $prefix . '_' . date('YmdHis') . '.mp4';

        Storage::put($directory . '/' . $file_name, $file_content);
        unlink($temp_path); // Eliminar archivo temporal

        return Storage::url($directory . '/' . $file_name);
    }

    public function getVideos()
    {
        $configuration = Configuration::first();
        return [
            'before_video_url' => $configuration->before_video_url,
            'after_video_url' => $configuration->after_video_url
        ];
    }

    /**
     *
     * @param  Request $request
     * @return array
     */
    public function lockedByColumn(Request $request)
    {
        $column = $request->column;
        $client = Client::findOrFail($request->id);
        $client->{$column} = $request->{$column};
        $client->save();

        $tenancy = app(Environment::class);
        $tenancy->tenant($client->hostname->website);
        DB::connection('tenant')->table('configurations')->where('id', 1)->update([$column => $client->{$column}]);

        return $this->generalResponse(true, $client->{$column} ? 'Activado correctamente' : 'Desactivado correctamente');
    }

    /* public function getVerificateDominan()
    {
        // verificar si el dominio ya existe
        $subdomain = request()->input('subdomain');
        $fqdn = strtolower($subdomain) . '.' . config('tenant.app_url_base');
        $website = Website::whereHas('hostnames', function ($query) use ($fqdn) {
            $query->where('fqdn', $fqdn);
        })->first();
        if ($website) {
            return [
                'success' => false,
                'message' => 'El subdominio esta disponible',
            ];
        }
    } */
    public function getVerificateDominan()
    {
        $fqdn = request()->input('fqdn');
        if (!$fqdn) {
            return response()->json([
                'error' => 'FQDN no proporcionado'
            ], 400);
        }
        $fqdn = strtolower($fqdn);
        $hostname = Hostname::where('fqdn', $fqdn)->first();

        if ($hostname) {
            // El subdominio existe
            return response()->json([
                'fqdn' => $fqdn
            ]);
        } else {
            // El subdominio no existe
            return response()->json([
                'error' => 'Subdominio no existe'
            ], 404);
        }
    }
}
