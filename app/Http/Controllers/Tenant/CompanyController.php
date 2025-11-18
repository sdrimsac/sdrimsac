<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Company;
use App\Models\Tenant\SoapType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\CompanyRequest;
use App\Http\Resources\Tenant\CompanyResource;
use App\Models\System\Client;
use App\Models\Tenant\CompanySameRuc;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function info()
    {
        $company = Company::active();
        return new CompanyResource($company);
    }
    public function create()
    {
        return view('tenant.companies.form');
    }

    public function save_same_ruc(Request $request){
        $company = new CompanySameRuc();
        $company->name = $request->name;
        $company->website_id = $request->website_id;
        $company->uuid = $request->uuid;
        $company->save();
        return [
            'success' => true,
            'message' => 'Empresa agregada'
        ];
    }
    public function remove_same_ruc($id){
        $company = CompanySameRuc::findOrFail($id);
        $company->delete();
        return [
            'success' => true,
            'message' => 'Empresa eliminada'
        ];
    }
    public function tables()
    {
        $soap_sends = config('tables.system.soap_sends');
        $soap_types = SoapType::all();
        $companies = Client::query()->get()->transform(
            function ($row) {
                return [
                    'id' => $row->id,
                    'name' => $row->name,
                    'website_id' => $row->hostname->website_id,
                    'uuid' => $row->hostname->website->uuid,
                    'number' => $row->number
                ];
            }
        );
        $same_rucs = CompanySameRuc::all();
        return compact('soap_types', 'soap_sends', 'companies', 'same_rucs');
    }

    public function record()
    {
        $company = Company::active();
        $record = new CompanyResource($company);

        return $record;
    }

    public function store(CompanyRequest $request)
    {

        $id = $request->input('id');
        $company = Company::find($id);
        $company->fill($request->all());

        $company->save();

        return [
            'success' => true,
            'message' => 'Empresa actualizada'
        ];
    }

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $company = Company::active();
            $type = $request->input('type');
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            $time = date('YmdHis');
            $name = $type . '_' . $company->number . '_' . $time . '.' . $ext;
            if (($type === 'logo')) request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048']);
            $file->storeAs(($type === 'logo') ? 'public/uploads/logos' : 'certificates', $name);
            if (($type === 'logo_store')) request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048']);
            $file->storeAs(($type === 'logo_store') ? 'public/uploads/logos' : 'certificates', $name);
            if (($type === 'document_logo')) request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048']);
            $file->storeAs(($type === 'document_logo') ? 'public/uploads/logos' : 'certificates', $name);
            if (($type === 'health_network_image')) request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048']);
            $file->storeAs(($type === 'health_network_image') ? 'public/uploads/logos' : 'certificates', $name);
            if (($type === 'a5_image')) request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048']);
            $file->storeAs(($type === 'a5_image') ? 'public/uploads/logos' : 'certificates', $name);
            if (($type === 'backgroud_image_document')) request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048']);
            $file->storeAs(($type === 'backgroud_image_document') ? 'public/uploads/logos' : 'certificates', $name);

            if ($type === 'account_img_trade_name_max') {
                request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048']);
            }
            if ($type === 'file_nuevo_dolares_img') {
                request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048']);
            }
            if ($type === 'account_img_trade_name_max') {
                $file->storeAs('public/uploads/logos', $name);
            }
            if ($type === 'file_nuevo_dolares_img') {
                $file->storeAs('public/uploads/logos', $name);
            }
            $company->$type = $name;
            $company->save();
            return [
                'success' => true,
                'message' => __('app.actions.upload.success'),
                'name' => $name,
                'type' => $type
            ];
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
    public function img_bg(Request $request)
    {
        if ($request->hasFile('file')) {
            $company = Company::active();
            $type = $request->input('type');
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            $name = $type . '_' . $company->number . '.' . $ext;
            if (($type === 'img_bg')) request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
            $file->storeAs(($type === 'img_bg') ? 'public/uploads/img_bg' : 'img_bg', $name);
            $company->img_bg = $name;
            $company->save();
            return [
                'success' => true,
                'message' => __('app.actions.upload.success'),
                'name' => $name,
                'type' => $type
            ];
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
    public function favicon(Request $request)
    {
        if ($request->hasFile('file')) {
            $company = Company::active();
            $type = $request->input('type');
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            $name = $type . '_' . $company->number . '.' . $ext;
            if (($type === 'favicon')) request()->validate(['file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
            $file->storeAs(($type === 'favicon') ? 'public/uploads/favicon' : 'favicon', $name);
            $company->favicon = $name;
            $company->save();
            return [
                'success' => true,
                'message' => __('app.actions.upload.success'),
                'name' => $name,
                'type' => $type
            ];
        }
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    }
}
