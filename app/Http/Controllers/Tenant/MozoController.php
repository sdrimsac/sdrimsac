<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\MozoCollection;
use App\Http\Resources\Tenant\MozoResource;
use App\Http\Resources\Tenant\SellerCollection;
use App\Models\Tenant\Catalogs\IdentityDocumentType;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Mozo;
use App\Models\Tenant\Seller;
use App\Models\Tenant\Series;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Report\Exports\ExportSeller;

class MozoController extends Controller
{
    public function index()
    {
        return view('tenant.mozo.index');
    }
    public function records(Request $request)
    {
        $records = $this->getRecords($request);

        return new MozoCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function recordsProduct(Request $request)
    {
        $records = $this->getRecordsProduct($request);

        return new SellerCollection($records->paginate(10));
    }
    public function getRecords(Request $request)
    {
        $records = Mozo::query();
        
        return $records->orderBy('id', 'desc');
    }
    public function check(Request $request)
    {
        $f = $request->f;
        $b = $request->b;
        $n = $request->n;

        $series = [$f, $b, $n];
        $exist = false;
        foreach ($series as $serie) {

            $existSerie = Series::where('number', $serie)->first();
            if ($existSerie) {

                $exist = true;
                break;
            }
        }

        return ["success" => !$exist, "message" => $exist ? "Las series ya existen" : "Series válidas"];
    }
    public function columns()
    {
        return [
            'name' => 'Nombre',
            'document' => 'Número de DNI o RUC',
        ];
    }

    public function tables()
    {
        $document_types = IdentityDocumentType::whereActive()
            ->where('id', '<>', '6')
            ->get();
        $establishments = Establishment::all();
        return compact('establishments', 'document_types');
    }

    public function record($id)
    {
        $record = new MozoResource(Mozo::findOrFail($id));

        return $record;
    }
    public function store(Request $request)
    {
        $id = $request->input('id');
        $seller = Mozo::firstOrNew(['id' => $id]);
        $seller->fill($request->all());
        $user_id = auth()->id();
        $seller->user_id = $user_id;
        $seller->save();
        return [
            'success' => true,
            'message' => ($id) ? 'Vendedor editado con éxito' : 'Vendedor registrado con éxito',
            'id' => $seller->id
        ];
    }

    /* public function destroy($id)
    {
        try {
            $seller = Seller::findOrFail($id);
            $seller->delete();

            return [
                'success' => true,
                'message' => 'Vendedor eliminado con éxito',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar el vendedor: ' . $e->getMessage(),
            ];
        }
    } */
    public function enabledSellers($type, $id)
    {

        $person = Mozo::findOrFail($id);
        $person->active = $type;
        $person->save();

        $type_message = ($type) ? 'habilitado' : 'inhabilitado';

        return [
            'success' => true,
            'message' => "Vendedor {$type_message} con éxito"
        ];
    }
    public function exportSellers(Request $request)
    {
        ini_set('memory_limit', '2048M');
        $records = $this->getRecords($request)->get();
        if ($records->isEmpty()) {
            return response()->json(['message' => 'No hay datos para exportar.'], 204);
        }

        $company = Company::first();
        return (new ExportSeller)
            ->records($records)
            ->company($company)
            ->download('Ventas Vendedores' . '_' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }
}
