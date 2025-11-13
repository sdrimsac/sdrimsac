<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\JobPositionCollection;
use App\Http\Resources\Tenant\JobPositionResource;
use Illuminate\Http\Request;
use App\Models\Tenant\JobPosition;

class JobPositionController extends Controller
{
    public function record($id)
    {
        $record = new JobPositionResource(JobPosition::findOrFail($id));
        return $record;
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $jobPosition = JobPosition::firstOrNew(['id' => $id]);
        $jobPosition->fill($request->all());
        $jobPosition->save();
        return [
            'success' => true,
            'message' => ($id) ? 'sueldo actualizado' : 'sueldo registrado'
        ];
    }

    public function records($type = null)
    {
        // Construir la consulta base
        $query = JobPosition::query();

        // Si se requiere filtrar por tipo (opcional), agregar la condición
        if (!is_null($type)) {
            // Ajusta la columna/condición según la lógica de negocio real
            // Ejemplo genérico: filtrar por una columna 'type'
            if (in_array($type, ['some_type', 'other_type'])) {
                $query->where('type', $type);
            }
        }

        return new JobPositionCollection($query->paginate(config('tenant.items_per_page')));
    }

    public function update(Request $request, $id)
    {
        $jobPosition = JobPosition::findOrFail($id);
        $jobPosition->fill($request->all());
        $jobPosition->save();

        return [
            'success' => true,
            'message' => 'Puesto de trabajo actualizado con éxito'
        ];
    }

    public function destroy($id)
    {
        $jobPosition = JobPosition::findOrFail($id);
        $jobPosition->delete();


        return [
            'success' => true,
            'message' => 'Puesto de trabajo eliminado con éxito'
        ];
    }
}
