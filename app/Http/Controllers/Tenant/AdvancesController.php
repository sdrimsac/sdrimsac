<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\AdvancesCollection;
use App\Http\Resources\Tenant\JobPositionCollection;
use App\Http\Resources\Tenant\JobPositionResource;
use Illuminate\Http\Request;
use App\Models\Tenant\JobPosition;
use App\Models\Tenant\WorkerAdvance;

class AdvancesController extends Controller
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
        $query = WorkerAdvance::query();

        if (!is_null($type)) {

            if (in_array($type, ['some_type', 'other_type'])) {
                $query->where('type', $type);
            }
        }

        return new AdvancesCollection($query->paginate(config('tenant.items_per_page')));
    }

    public function update(Request $request, $id)
    {
        $workerAdvance = WorkerAdvance::findOrFail($id);
        $workerAdvance->fill($request->all());
        $workerAdvance->save();

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
