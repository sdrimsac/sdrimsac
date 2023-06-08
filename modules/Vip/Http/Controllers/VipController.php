<?php

namespace Modules\Vip\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vip\Http\Requests\VipRequest;
use Modules\Vip\Http\Resources\VipCollection;
use Modules\Vip\Models\Vip;

class VipController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('vip::index');
    }
    public function columns()
    {
        return [
            'description' => 'Nombre',
        ];
    }
    public function clients()
    {
        return view('vip::clients');
    }
    public function records()
    {
        $vips = Vip::where('id', '<>', null)->paginate(20);

        return new VipCollection($vips);
    }
    public function record($id)
    {
        $vip = Vip::find($id);

        return $vip;
    }
    public function desactive($id)
    {
        $vip = Vip::find($id);
        $vip->active = !$vip->active;
        $vip->save();
        return ["success" => true];
    }
    public function store(VipRequest $request)
    {
        $vip = Vip::findOrNew($request->id);
        $vip->fill($request->all());
        $vip->save();
        return ["success" => true];
    }
}
