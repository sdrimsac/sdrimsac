<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\SeriesRequest;
use App\Http\Resources\Tenant\SellerCollection;
use App\Http\Resources\Tenant\SellerResource;
use App\Http\Resources\Tenant\SeriesCollection;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Catalogs\IdentityDocumentType;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Seller;
use App\Models\Tenant\Series;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        return view('tenant.sellers.index');
    }

    public function records()
    {
        $records = Seller::query()
            ->orderBy('id', 'desc');
        return new SellerCollection($records->paginate(config('tenant.items_per_page')));
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

    public function tables()
    {   $document_types = IdentityDocumentType::whereActive()
        ->where('id','<>' ,'6')
        ->get();
        $establishments = Establishment::all();
        return compact('establishments', 'document_types');
        
    }

    public function record($id){
        $record = new SellerResource(Seller::findOrFail($id));

        return $record;
    }
    public function store(Request $request)
    {
        $id = $request->input('id');
       $seller = Seller::firstOrNew(['id' => $id]);
        $seller->fill($request->all());
        $seller->save();
        return [
            'success' => true,
            'message' => ($id)?'Vendedor editado con éxito':'Vendedor registrado con éxito',
            'id' => $seller->id
        ];
    }

    public function destroy($id)
    {
        $item = Series::findOrFail($id);
        $item->delete();

        return [
            'success' => true,
            'message' => 'Serie eliminada con éxito'
        ];
    }
}
