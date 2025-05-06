<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\DocumentSaludCollection;
use App\Models\Tenant\DocumentSalud;
use Illuminate\Http\Request;

class DocumentSaludController extends Controller
{

    public function records(Request $request)
    {
        $column = $request->input('column');
        $value = $request->input('value');
        if ($column && $value) {
            $records = DocumentSalud::where($column, 'like', "%{$value}%");
        } else {
            $records = DocumentSalud::query();
        }

        $records = $records->orderBy('id', 'desc');
        return new DocumentSaludCollection($records->paginate(config('tenant.items_per_page')));
    }
}
