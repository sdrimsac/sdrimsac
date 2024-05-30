<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\BankRequest;
use App\Http\Resources\Tenant\BankCollection;
use App\Http\Resources\Tenant\BankResource;
use App\Models\Tenant\Bank;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BankController extends Controller
{
    public function index()
    {
        return view('tenant.banks.index');
    }
    public function deleteImage($bank_id)
    {
        try {
            $bank = Bank::findOrFail($bank_id);
            $path = 'public/banks/' . $bank->image;
            Storage::delete($path);
            $bank->image = null;
            $bank->save();
            return [
                'success' => true,
                'message' => 'Imagen eliminada con éxito'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar la imagen'
            ];
        }
    }
    public function UploadImage(Request $request)
    {

        $file = $request->file('image');
        $bank_id = $request->input('bank_id');
        $bank = Bank::findOrFail($bank_id);
        if ($bank->image) {
            $path = 'public/banks/' . $bank->image;
            Storage::delete($path);
        }
        $uuid = uniqid();
        $ext = $file->getClientOriginalExtension();
        $name = $uuid . '.' . $ext;
        $file->storeAs('public/banks', $name);
        $bank->image = $name;
        $bank->save();
        return [
            'success' => true,
            'message' => 'Imagen subida con éxito'
        ];
    }
    public function records()
    {
        $records = Bank::all();

        return new BankCollection($records);
    }

    public function record($id)
    {
        $record = new BankResource(Bank::findOrFail($id));

        return $record;
    }

    public function store(BankRequest $request)
    {
        $id = $request->input('id');
        $bank = Bank::firstOrNew(['id' => $id]);
        $bank->fill($request->all());
        $bank->save();

        return [
            'success' => true,
            'message' => ($id) ? 'Banco editado con éxito' : 'Banco registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        try {

            $bank = Bank::findOrFail($id);
            $bank->delete();

            return [
                'success' => true,
                'message' => 'Banco eliminado con éxito'
            ];
        } catch (Exception $e) {

            return ($e->getCode() == '23000') ? ['success' => false, 'message' => 'El banco esta siendo usado por otros registros, no puede eliminar'] : ['success' => false, 'message' => 'Error inesperado, no se pudo eliminar el banco'];
        }
    }
}
