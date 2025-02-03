<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

use App\Models\Tenant\Catalog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CatalogoController extends Controller
{
    /* public function index()
    {
        return view('tenant.banks.index');
    } */
    public function uploadImage(Request $request)
    {
        $catalog = Catalog::first();

        if (!$catalog) {
            $catalog = Catalog::create();
        }

        $column = $request->column;
        if ($request->hasFile('file') && in_array($column, ['image_past', 'image_fond', 'image_footer'])) {
            $path = $request->file('file')->store('catalog', 'public');
            $catalog->update([$column => $path]);
        }

        return response()->json([
            'catalog' => [
                'image_past' => asset('storage/' . $catalog->image_past),
                'image_fond' => asset('storage/' . $catalog->image_fond),
                'image_footer' => asset('storage/' . $catalog->image_footer),
            ]
        ]);
    }
    public function getImages()
    {
        $catalog = Catalog::first();
        return response()->json([
            'image_past' => $catalog->image_past ? asset('storage/' . $catalog->image_past) : null,
            'image_fond' => $catalog->image_fond ? asset('storage/' . $catalog->image_fond) : null,
            'image_footer' => $catalog->image_footer ? asset('storage/' . $catalog->image_footer) : null,
        ]);
    }
}
