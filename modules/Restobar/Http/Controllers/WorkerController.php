<?php

namespace Modules\Restobar\Http\Controllers;

use App\Exports\ReportProductWarehouse;
use App\Models\Tenant\User;
use Illuminate\Routing\Controller;
use Modules\Restobar\Models\Table;
use App\Http\Resources\Tenant\UserCollection;
use App\Models\Tenant\Cash;
use App\Models\Tenant\CommercialTreatmentUserExcluded;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Series;
use App\Models\Tenant\UserSerie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Restobar\Http\Requests\TableRequest;
use Modules\Restobar\Http\Requests\WorkerRequest;
use App\Models\Tenant\RegisterMovement;
use App\Http\Resources\Tenant\RegisterMovementCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Workers;

class WorkerController extends Controller
{
    protected $all_models = [];
    public function __construct()
    {
        $this->all_models = [
            "orden" => "Modules\Restobar\Models\Orden",
            "table" => "Modules\Restobar\Models\Table",
            "area" => "Modules\Restobar\Models\Area",
            "food" => "Modules\Restobar\Models\Food",
            "ordenItem" => "Modules\Restobar\Models\OrdenItem",
            "document" => "App\Models\Tenant\Document",
            "saleNote" => "App\Models\Tenant\SaleNote",
            "purchase" => "App\Models\Tenant\Purchase",
            "box" => "App\Models\Box",
        ];
    }


    public function index()
    {
        $establishments = Establishment::all();
        $configuration = Configuration::first();
        return view('restobar::workers', compact('establishments', 'configuration'));
    }
    public function columns()
    {
        return [
            'nombre' => 'name',
            'estado' => 'active',
            'tipo usuario' => 'type'
        ];
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $new_request = [
                'file' => $request->file('file'),
                'type' => $request->input('type'),
            ];

            return $this->upload_image($new_request);
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
    function upload_image($request)
    {
        $file = $request['file'];
        $type = $request['type'];

        $temp = tempnam(sys_get_temp_dir(), $type);
        file_put_contents($temp, file_get_contents($file));

        $mime = mime_content_type($temp);
        $data = file_get_contents($temp);

        return [
            'success' => true,
            'data' => [
                'filename' => $file->getClientOriginalName(),
                'temp_path' => $temp,
                'temp_image' => 'data:' . $mime . ';base64,' . base64_encode($data)
            ]
        ];
    }
    /* public function delete_images($id)
    {
        $record = ItemImage::findOrFail($id);
        $record->delete();

        return [
            'success' => true,
            'message' => 'Imagen eliminada con éxito'
        ];
    } */

    public function report_products_w(Request $request)
    {

        ini_set('max_execution_time', 30000);
        ini_set('memory_limit', '3024M');
        $user_id = $request->user_id;
        $cash_id = $request->cash_id;
        $cash = Cash::find($cash_id);
        $user = $user_id ? User::find($user_id) : auth()->user();
        $establishment_id = isset($user->establishment_id) ? $user->establishment_id : auth()->user()->establishment_id;
        $establishment = Establishment::find($establishment_id);
        $company = Company::active();
        $records = ItemWarehouse::where('warehouse_id', $establishment_id)
            ->whereHas('item', function ($query) {
                $query->where('unit_type_id', '<>', 'ZZ')
                    ->whereNotIsSet()
                    ->whereNotPromotionItems();
            })
            ->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->item->description,
                    'stock' => $row->stock,
                    'internal_id' => $row->item->internal_id,
                    'category' => optional($row->item->category)->name,
                    'unit_type_id' => $row->item->unit_type_id,
                ];
            });
        $turn = $cash->turn->turn_desc;
        return (new ReportProductWarehouse)
            ->records($records)
            ->company($company)
            ->user($user)
            ->turn($turn)
            ->establishment($establishment)
            ->download('Stock_al_cerrar_caja_' . Carbon::now() . '.xlsx');
    }
    public function report_products()
    {
        $user = auth()->user();
        //el ultimo registro de Cash del usuario
        $cash = Cash::where('user_id', $user->id)->latest()->first();
        $turn = $cash->turn->turn_desc;
        $company = Company::active();
        $establishment_id = auth()->user()->establishment_id;
        $establishment = Establishment::find($establishment_id);
        $records = ItemWarehouse::where('warehouse_id', $establishment_id)
            ->whereHas('item', function ($query) {
                $query->where('unit_type_id', '<>', 'ZZ')
                    ->whereNotIsSet()
                    ->whereNotPromotionItems();
            })
            ->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->item->description,
                    'stock' => $row->stock,
                    'internal_id' => $row->item->internal_id,
                    'category' => optional($row->item->category)->name,
                    'unit_type_id' => $row->item->unit_type_id,
                ];
            });
        return (new ReportProductWarehouse)
            ->records($records)
            ->company($company)
            ->user($user)
            ->turn($turn)
            ->establishment($establishment)
            ->download('Stock_al_cerrar_caja_' . Carbon::now() . '.xlsx');
    }

    public function getAuthenticatedUser()
    {
        $user = auth()->user(); // Obtiene el usuario autenticado
        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }
    public function records(Request $request)
    {
        $configuration =  Configuration::first();

        $user_type = auth()->user()->type;
        $establishment_id = auth()->user()->establishment_id;
        $user = auth()->user();
        $status = $request->input('qty_type');
        $name = $request->input('name');
        /* if ($user_type == 'admin') {
            $records = User::where('type', '<>', 'superadmin');

            if ($user_type == 'admin') {
                if ($user->is_pharmacy) {

                    $records = User::whereIn('type', ['admin', 'seller'])
                        ->where('is_pharmacy', 1);
                } else {
                    $records = User::whereRaw('1 = 0');
                }
            }
        } else {
            $records = User::query();
        } */
        if ($user_type == 'admin') {
            if ($user->is_pharmacy) {
                // Solo usuarios de tipo admin y seller que también son de farmacia
                $records = User::whereIn('type', ['admin', 'seller'])
                    ->where('is_pharmacy', 1);
            } else {
                // Admin sin farmacia: ver todos excepto superadmin
                $records = User::where('type', '<>', 'superadmin');
            }
        } else {
            $records = User::query();
        }

        if ($user_type == 'seller') {
            $records = $records->where('type', '<>', 'superadmin')
                ->where('type', '<>', 'admin');
            if ($configuration->health_network) {
                $arca_type = User::find($user->id)->getUserTypeArca();
                if ($arca_type) {
                    if ($arca_type == 'product') {
                        $records = $records->whereHas('establishment', function ($query) use ($establishment_id) {
                            $query->where('is_product', true);
                        });
                    } else {
                        $records = $records->whereHas('establishment', function ($query) use ($establishment_id) {
                            $query->where('is_service', true);
                        });
                    }
                } else {
                    $records =  $records->where('establishment_id', $establishment_id);
                }
            }
        }
        if ($status !== null) {
            $records = $records->where('active', $status);
        } else {
            $records = $records->where('active', 1);
        }
        if ($name) {
            $records = $records->where('name', 'like', '%' . $name . '%');
        }

        return new UserCollection($records->paginate(150),);
    }
    public function recordsActivity(Request $request)
    {

        $records = RegisterMovement::query();
        $column = $request->column;
        $value = $request->value;

        if ($column && $value) {
            switch ($column) {
                case 'user_id':
                    $records = $records->where('user_id', $value);
                    break;
                case 'date_of_issue':
                    $records = $records->whereDate('created_at', $value);
                    break;
                case 'description':
                    $records = $records->where('description', 'like', "%{$value}%");
                    break;
                case 'event_description':
                    $records = $records->where('event', $value);
                    break;
                case 'model':
                    $model = $this->get_model($value);
                    if ($model) {
                        $records = $records->where('model', $model);
                    }
                    break;
            }
        }

        $records = $records->orderBy('id', 'desc');
        return new RegisterMovementCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function record($id) //8
    {
        $worker = User::find($id);
        // $worker->series = 12;
        $user_serie = UserSerie::where('user_id', $id)
            ->whereHas('seriexxx', function ($oo) {
                $oo->where('document_type_id', '01');
            })
            ->first();
        $commercial_treatment = CommercialTreatmentUserExcluded::where('user_id', $id)
            ->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->commercial_treatment_id,
                    'description' => $row->commercial_treatment->description,
                    'active' => (bool) $row->commercial_treatment->active,
                ];
            });
        if ($user_serie) {
            $worker->series = $user_serie->serie_id;
        }
        $worker->commercial_treatment = $commercial_treatment;
        if ($worker->image) {
            $worker->image_url = url('') . '/storage/uploads/workers/' . $worker->image;
        } else {
            $worker->image_url = url('') . '/status_images/user.png';
        }
        return [
            'success' => true,
            'data' => $worker,
            'has_series' => $user_serie ? true : false,
        ];
    }
    private function newPin()
    {
        $pin = $this->generatePIN();
        $isNew = false;

        while (!$isNew) {
            $pinExist = User::where('pin', $pin)->first();
            if ($pinExist) {
                $pin = "";
                $pin = $this->generatePIN();
            } else {
                $isNew = true;
            }
        }
        return $pin;
    }
    private function generatePIN($digits = 4)
    {
        $i = 0;
        $pin = "";
        while ($i < $digits) {
            $pin .= mt_rand(0, 9);
            $i++;
        }


        return $pin;
    }
    public function store(WorkerRequest $request)
    {
        $docs = [
            "NV"    => "80",
            "B"     => "03",
            "F"     => "01",
            "FD"    => "08",
            "ND"    => "08",
            "FC"    => "07",
            "BC"    => "07",
            "T"     => "09",
        ];
        $serie_id = $request->series;
        $id = $request->input('id');
        $temp_path = $request->input('temp_path');

        $user = User::firstOrNew(['id' => $id]);
        $user->user_items()->delete();
        UserSerie::where('user_id', $id)->delete();
        //establishment_id
        $user_items = $request->input('user_items');
        $establishment_id = $user->establishment_id; //1

        if ($user_items) {
            foreach ($user_items as $item) {
                $user->user_items()->create(['item_id' => $item['id']]);
            }
        }
        if ($serie_id) {

            $serie = Series::where('id', $serie_id)->first();
            $number = $serie->number;
            $prefix = substr($number, -3); //F003 003


            foreach ($docs as $key => $value) {
                $prefix_serie = $key;
                $largo = strlen($prefix_serie);
                $prefix_to_search = null;
                if ($largo == 1) {
                    $prefix_to_search = $key . $prefix;
                } else {
                    $prefix_to_search = $key . substr($prefix, -2);
                }

                //NV002 F002 B002
                $serie_db = Series::where('document_type_id', $value)
                    ->where('number', $prefix_to_search)
                    ->where('establishment_id', $establishment_id)
                    ->first();
                if (!$serie_db) {
                    $serie_db = new Series;
                    $serie_db->document_type_id = $value;
                    $serie_db->number = $prefix_to_search;
                    $serie_db->establishment_id = $establishment_id;
                    $serie_db->save();
                }

                $user_serie = new UserSerie;
                $user_serie->user_id = $id;
                $user_serie->serie_id = $serie_db->id;
                $user_serie->save();
            }
        }



        //actualización
        if ($id) {
            $user->fill($request->all());

            // $user->establishment_id = auth()->user()->establishment_id;
        }
        //creando
        else {
            $pin =  $this->newPin();
            $user->pin = $pin;
            $user->type = 'seller';
            $user->fill($request->all());
            // $user->establishment_id = auth()->user()->establishment_id;
        }
        if ($temp_path) {
            $directory = 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'workers' . DIRECTORY_SEPARATOR;
            $file_name_old = $request->input('image');
            $file_name_old_array = explode('.', $file_name_old);
            $file_content = file_get_contents($temp_path);

            $datenow = date('YmdHis');
            $file_name = Str::slug($user->name) . '-' . $datenow . '.' . end($file_name_old_array);

            Storage::put($directory . $file_name, $file_content);
            $user->image = $file_name;
        } elseif (!$request->input('image') && !$request->input('temp_path') && !$request->input('image_url')) {
            /* $user->image = 'user.png'; */
            $user->image = User::DEFAULT_USER_IMAGE;
        }
        $user->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Trabajador actualizado con éxito' : 'Trabajador creado con éxito'
        ];
    }
    public function commercial_treatment(Request $request)
    {
        $worker_id = $request->input('worker_id');
        $commercial_treatment_id = $request->input('commercial_treatment_id');
        $commercial_treatment = CommercialTreatmentUserExcluded::where('user_id', $worker_id)
            ->where('commercial_treatment_id', $commercial_treatment_id)
            ->first();
        if ($commercial_treatment) {
            $commercial_treatment->delete();
        } else {
            $commercial_treatment = new CommercialTreatmentUserExcluded();
            $commercial_treatment->user_id = $worker_id;
            $commercial_treatment->commercial_treatment_id = $commercial_treatment_id;
            $commercial_treatment->save();
        }
        return [
            'success' => true,
            'message' => 'Tratamiento comercial actualizado con éxito'
        ];
    }
    public function active($id)
    {
        $workers = User::find($id);
        $workers->active = !$workers->active;
        $workers->save();
        return [
            'success' => true,
            'data' => $workers,
            'message' => 'Usuario ' . ($workers->active ? 'activado' : 'desactivado')
        ];
    }
    public function destroy($id)
    {
        // $woker=User::findOrFail($id);
        // $woker->active=;
        // return [
        //     'success' => true,
        //     'message' => 'Eliminado con éxito'
        // ];
    }
}
