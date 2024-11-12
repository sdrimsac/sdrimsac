<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\SeriesRequest;
use App\Http\Resources\Tenant\SellerCollection;
use App\Http\Resources\Tenant\SellerResource;
use App\Http\Resources\Tenant\SeriesCollection;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Catalogs\IdentityDocumentType;
use App\Models\Tenant\Company;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Seller;
use App\Models\Tenant\Series;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Report\Exports\ExportSeller;

class SellerController extends Controller
{
    public function index()
    {
        return view('tenant.sellers.index');
    }
    public function records(Request $request)
    {
        $records = $this->getRecords($request);

        return new SellerCollection($records->paginate(config('tenant.items_per_page')));
    }
    /* public function getRecords(Request $request)
    {
        $date_of_issue = $request->input('date_of_issue');
        $month_start = $request->input('month_start');
        $active = $request->input('active', 1);

        $query = Seller::query()
            ->withSum(['documents as documents_total' => function ($query) use ($date_of_issue, $month_start) {
                if (!empty($date_of_issue) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_issue)) {

                    $query->whereDate('date_of_issue', $date_of_issue);
                } elseif (!empty($month_start) && preg_match('/^\d{4}-\d{2}$/', $month_start)) {

                    $month_start_date = "{$month_start}-01";
                    $month_end_date = date("Y-m-t", strtotime($month_start_date));
                    $query->whereBetween('date_of_issue', [$month_start_date, $month_end_date]);
                }
            }], 'total')
            ->withSum(['saleNotes as sale_notes_total' => function ($query) use ($date_of_issue, $month_start) {

                if (!empty($date_of_issue) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_issue)) {

                    $query->whereDate('date_of_issue', $date_of_issue);
                } elseif (!empty($month_start) && preg_match('/^\d{4}-\d{2}$/', $month_start)) {

                    $month_start_date = "{$month_start}-01";
                    $month_end_date = date("Y-m-t", strtotime($month_start_date));
                    $query->whereBetween('date_of_issue', [$month_start_date, $month_end_date]);
                }
            }], 'total');
        if ($request->has('active')) {
            $active = $request->input('active');
            $query->where('active', $active);
        } else {
            $query->where('active', 1);
        }

        if ($request->has('column') && $request->has('value') && !empty($request->value)) {
            $column = $request->input('column');
            if (in_array($column, ['name', 'document'])) {
                $query->where($column, 'like', '%' . $request->value . '%');
            }
        }
        return $query->orderBy('id', 'desc');
    } */
    public function getRecords(Request $request)
    {
        $date_of_issue = $request->input('date_of_issue');
        $month_start = $request->input('month_start');
        $active = $request->input('active', 1);

        $query = Seller::query()
            ->withSum(['documents as documents_total' => function ($query) use ($date_of_issue, $month_start) {
                if (!empty($date_of_issue) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_issue)) {
                    $query->whereDate('date_of_issue', $date_of_issue);
                } elseif (!empty($month_start) && preg_match('/^\d{4}-\d{2}$/', $month_start)) {
                    $month_start_date = "{$month_start}-01";
                    $month_end_date = date("Y-m-t", strtotime($month_start_date));
                    $query->whereBetween('date_of_issue', [$month_start_date, $month_end_date]);
                }
            }], 'total')
            ->withSum(['saleNotes as sale_notes_total' => function ($query) use ($date_of_issue, $month_start) {
                if (!empty($date_of_issue) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_issue)) {
                    $query->whereDate('date_of_issue', $date_of_issue);
                } elseif (!empty($month_start) && preg_match('/^\d{4}-\d{2}$/', $month_start)) {
                    $month_start_date = "{$month_start}-01";
                    $month_end_date = date("Y-m-t", strtotime($month_start_date));
                    $query->whereBetween('date_of_issue', [$month_start_date, $month_end_date]);
                }
            }], 'total')
            ->with(['soldItems' => function ($query) use ($date_of_issue, $month_start) {
                if (!empty($date_of_issue) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_issue)) {
                    $query->whereHas('document', function ($q) use ($date_of_issue) {
                        $q->whereDate('date_of_issue', $date_of_issue);
                    });
                } elseif (!empty($month_start) && preg_match('/^\d{4}-\d{2}$/', $month_start)) {
                    $month_start_date = "{$month_start}-01";
                    $month_end_date = date("Y-m-t", strtotime($month_start_date));
                    $query->whereHas('document', function ($q) use ($month_start_date, $month_end_date) {
                        $q->whereBetween('date_of_issue', [$month_start_date, $month_end_date]);
                    });
                }
            }]);

        if ($request->has('active')) {
            $active = $request->input('active');
            $query->where('active', $active);
        } else {
            $query->where('active', 1);
        }

        if ($request->has('column') && $request->has('value') && !empty($request->value)) {
            $column = $request->input('column');
            if (in_array($column, ['name', 'document'])) {
                $query->where($column, 'like', '%' . $request->value . '%');
            }
        }

        return $query->orderBy('id', 'desc');
    }

    /* public function getRecordsProduct(Request $request)
    {

        // Obtener los datos de entrada desde la solicitud
        $date_of_issue = $request->input('date_of_issue');
        $month_start = $request->input('month_start');
        $sellerId = $request->input('sellerId');  // Obtener el sellerId de la solicitud

        // Crear la consulta base
        $query = Seller::query()
            ->withSum(['documents as documents_total' => function ($query) use ($date_of_issue, $month_start) {
                if (!empty($date_of_issue) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_issue)) {
                    $query->whereDate('date_of_issue', $date_of_issue);
                } elseif (!empty($month_start) && preg_match('/^\d{4}-\d{2}$/', $month_start)) {
                    $month_start_date = "{$month_start}-01";
                    $month_end_date = date("Y-m-t", strtotime($month_start_date));
                    $query->whereBetween('date_of_issue', [$month_start_date, $month_end_date]);
                }
            }], 'total')
            ->withSum(['saleNotes as sale_notes_total' => function ($query) use ($date_of_issue, $month_start) {
                if (!empty($date_of_issue) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_issue)) {
                    $query->whereDate('date_of_issue', $date_of_issue);
                } elseif (!empty($month_start) && preg_match('/^\d{4}-\d{2}$/', $month_start)) {
                    $month_start_date = "{$month_start}-01";
                    $month_end_date = date("Y-m-t", strtotime($month_start_date));
                    $query->whereBetween('date_of_issue', [$month_start_date, $month_end_date]);
                }
            }], 'total')
            ->with(['soldItems' => function ($query) use ($date_of_issue, $month_start) {
                if (!empty($date_of_issue) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_issue)) {
                    $query->whereHas('document', function ($q) use ($date_of_issue) {
                        $q->whereDate('date_of_issue', $date_of_issue);
                    });
                } elseif (!empty($month_start) && preg_match('/^\d{4}-\d{2}$/', $month_start)) {
                    $month_start_date = "{$month_start}-01";
                    $month_end_date = date("Y-m-t", strtotime($month_start_date));
                    $query->whereHas('document', function ($q) use ($month_start_date, $month_end_date) {
                        $q->whereBetween('date_of_issue', [$month_start_date, $month_end_date]);
                    });
                }
            }]);

        // Si se proporciona sellerId, filtramos por el ID del vendedor
        if (!empty($sellerId)) {
            $query->where('id', $sellerId);  // Filtramos por el sellerId
        }

        // Si hay un filtro por columna, lo aplicamos
        if ($request->has('column') && $request->has('value') && !empty($request->value)) {
            $column = $request->input('column');
            if (in_array($column, ['name', 'document'])) {
                $query->where($column, 'like', '%' . $request->value . '%');
            }
        }

        // Ordenar por ID de forma descendente
        return $query->orderBy('id', 'desc');
    } */

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
            /* 'active' => 'Estado' */
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
        $record = new SellerResource(Seller::findOrFail($id));

        return $record;
    }
    public function store(Request $request)
    {
        $id = $request->input('id');
        $seller = Seller::firstOrNew(['id' => $id]);
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

        $person = Seller::findOrFail($id);
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
        /* $establishment = Establishment::first(); */
        return (new ExportSeller)
            ->records($records)
            ->company($company)
            /* ->establishment($establishment) */
            ->download('Ventas Vendedores' . '_' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }
}
