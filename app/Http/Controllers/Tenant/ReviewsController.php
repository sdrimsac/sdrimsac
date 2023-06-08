<?php
namespace App\Http\Controllers\Tenant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\ReviewsRequest;
use App\Http\Resources\Tenant\ReviewsResource;
use App\Http\Resources\Tenant\ReviewsCollection;
use Illuminate\Http\Request;
use App\Models\Tenant\Vehicle;
use App\Models\Tenant\Reviews;

class ReviewsController extends Controller
{
    public function index()
    {
        return view('tenant.reviews.index');
    }
 
    public function columns()
    {
        return [
            'date_latest_reviews' => 'Fecha Ultima',
            'date_next_reviews'   => 'Fecha Proxima',
            
        ];
    }
    public function record($id)
    {
        $record = new ReviewsResource(Reviews::findOrFail($id));
        return $record;
    }

    public function tables()
    {
      
     $vehicle= Vehicle::all();
     return compact('vehicle');
       
    }

    public function store(ReviewsRequest $request)
    {
        $id = $request->input('id');
        $reviews = Reviews::firstOrNew(['id' => $id]);
        $reviews->fill($request->all());
        $reviews->save();
        return [
            'success' => true,
            'message' => ($id)?'Revision actualizado':'Revision registrado'
        ];
    }
 
    public function records(Request $request)
    {
        $records = Reviews::where($request->column, 'like', "%{$request->value}%")->orderBy($request->column);//para ordenar

        return new ReviewsCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function destroy($id)
    {
        $reviews = Reviews::findOrFail($id);
        $reviews->save();

        return [
            'success' => true,
            'message' => 'Revision eliminado con éxito'
        ];
    }
}
