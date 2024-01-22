<?php

namespace App\Http\Controllers\Tenant;


use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\CommercialTreatmentCollection;
use App\Http\Resources\Tenant\CommercialTreatmentItemCollection;
use App\Http\Resources\Tenant\CommercialTreatmentResource;
use App\Models\Tenant\CommercialTreatment;
use App\Models\Tenant\CommercialTreatmentCategory;
use App\Models\Tenant\CommercialTreatmentItem;
use Illuminate\Http\Request;
use Modules\Item\Models\CategoryItem;

class CommercialTreatmentController extends Controller
{
    public function index()
    {
        return view('tenant.commercial_treatment.index');
    }
    public function columns()
    {
        return [
            'description' => 'Descripción'
        ];
    }
    public function delete($id)
    {
        $commercial_treatment = CommercialTreatment::findOrFail($id);
        $commercial_treatment->delete();
        return [
            'success' => true,
            'message' => 'Eliminado con éxito',
            'data'    => $commercial_treatment
        ];
    }
    public function store_categories(Request $request, $id)
    {
        $table_data = $request->data;
        CommercialTreatmentCategory::where('commercial_treatment_id', $id)->delete();
        foreach ($table_data as $row) {
            $commercial_treatment_category = new CommercialTreatmentCategory();
            $commercial_treatment_category->commercial_treatment_id = $id;
            $commercial_treatment_category->category_item_id = $row['id'];
            $commercial_treatment_category->amount = $row['amount'];
            $commercial_treatment_category->save();
        }
        return [
            'success' => true,
            'message' => 'Actualizado con éxito',
            'data'    => $table_data
        ];
    }
    public function active_desactive($id)
    {
        $commercial_treatment = CommercialTreatment::findOrFail($id);
        $commercial_treatment->active = !$commercial_treatment->active;
        $commercial_treatment->save();
        return [
            'success' => true,
            'message' => 'Actualizado con éxito',
            'data'    => $commercial_treatment
        ];
    }
    public function deleteItem( $commercial_treatment_item_id)
    {
       CommercialTreatmentItem::where('id', $commercial_treatment_item_id)->delete();
        return [
            'success' => true,
            'message' => 'Eliminado con éxito',
        ];
    }
    public function set_item(Request $request, $item_id, $commercial_treatment_id)
    {

        $amount = $request->amount;
        $commercial_treatment_item = CommercialTreatmentItem::where('item_id', $item_id)
            ->where('commercial_treatment_id', $commercial_treatment_id)
            ->first();
        if ($commercial_treatment_item) {
            $commercial_treatment_item->amount = $amount;
            $commercial_treatment_item->save();
        } else {
            $commercial_treatment_item = new CommercialTreatmentItem();
            $commercial_treatment_item->commercial_treatment_id = $commercial_treatment_id;
            $commercial_treatment_item->item_id = $item_id;
            $commercial_treatment_item->amount = $amount;
            $commercial_treatment_item->active = true;
            $commercial_treatment_item->save();
        }
        return [
            'success' => true,
            'message' => 'Actualizado con éxito',
            'data'    => $commercial_treatment_item
        ];
    }
    public function store_items(Request $request, $id)
    {
        $table_data = $request->data;
        // CommercialTreatmentItem::where('commercial_treatment_id', $id)->delete();
        foreach ($table_data as $row) {
            $commercial_treatment_category = new CommercialTreatmentItem();
            $commercial_treatment_category->commercial_treatment_id = $id;
            $commercial_treatment_category->item_id = $row['id'];
            $commercial_treatment_category->amount = $row['amount'];
            $commercial_treatment_category->save();
        }
        return [
            'success' => true,
            'message' => 'Actualizado con éxito',
            'data'    => $table_data
        ];
    }
    public function record_items($item_id, $commercial_treatment_id)
    {
        $record = CommercialTreatmentItem::where('item_id', $item_id)
            ->where('commercial_treatment_id', $commercial_treatment_id)
            ->first();
        if (!$record) {
            return [
                'success' => false,
                'message' => 'No existe el registro',
            ];
        }
        return [
            'success' => true,
            'message' => 'Existe el registro',
            'data'    => $record
        ];
    }
    public function records_items($commercial_treatment_id)
    {
        $records = CommercialTreatmentItem::with(['item:id,description'])
            ->where('commercial_treatment_id', $commercial_treatment_id)
            ->orderBy('id');

        return new CommercialTreatmentItemCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function records_categories($commercial_treatment_id)
    {
        $categories = CategoryItem::select(['id', 'name'])->get();
        $records = [];
        foreach ($categories as  $value) {
            $amount = 0.00;
            if ($commercial_treatment_id) {
                $commercial_treatment_category =
                    CommercialTreatmentCategory::where('commercial_treatment_id', $commercial_treatment_id)
                    ->where('category_item_id', $value->id)->first();
                if ($commercial_treatment_category) {
                    $amount = $commercial_treatment_category->amount;
                }
            }
            $records[] = [
                'id' => $value->id,
                'name' => $value->name,
                'amount' => number_format($amount, 2, '.', '')
            ];
        }
        return $records;
    }

    public function records(Request $request)
    {
        $all = $request->input('all');
        $records = CommercialTreatment::query();
        if ($request->column == 'description') {
            $records->where('description', 'like', "%{$request->value}%");
        }
        $records =  $records->orderBy('description');
        if ($all) {
            return $records->get();
        }

        return new CommercialTreatmentCollection($records->paginate(config('tenant.items_per_page')));
    }

    public function record($id)
    {
        $record = new CommercialTreatmentResource(CommercialTreatment::findOrFail($id));

        return $record;
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $commercial_treatment = CommercialTreatment::firstOrNew(['id' => $id]);
        $commercial_treatment->fill($request->all());
        $commercial_treatment->description = strtoupper($request->input('description'));
        $commercial_treatment->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Actualizado con éxito' : 'Registrado con éxito',
            'data'    => $commercial_treatment
        ];
    }
}
