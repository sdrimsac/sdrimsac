<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Restaurant\Models\Table;
use Modules\Restaurant\Models\TableUserMaintenance;
use Modules\Restaurant\Models\WorkersType;

class TableMaintenanceController extends Controller
{
    public function records()
    {
    }
    public function record()
    {
    }
    function messageType($type)
    {
        $message = '';
        switch ($type) {
            case 'limpieza':
                $message = 'Se ha registrado una solicitud de limpieza';
                break;

            default:
                $message = 'Se ha registrado una solicitud de mantenimiento';
                break;
        }
        return $message;
    }
    function changeStateTable($table_id, $type)
    {
        $table = Table::find($table_id);
        switch ($type) {
            case 'limpieza':
                $table->is_cleaning = 1;
                break;

            default:
                $table->status_table_id = 3;
                break;
        }
        $table->save();
    }
    function sendMessage($table_maintenance)
    {
        $user_id = $table_maintenance->user_id;
        $user = User::find($user_id);
        $name = $user->name;

        $telephone = $user->telephone;
        if ($telephone) {
            $type = $table_maintenance->type;
            $message = $this->messageType($type);
            $message .= " con asignación a $name.";
            $table = $table_maintenance->table;
            $number = $table->number;
            $tower = $table->floor->tower->name;
            $typeTable = $table->is_room ? 'Habitación' : 'Mesa';
            $message .= "\n $typeTable: $tower - $number";
            $message .= "\n Comentario: " . $table_maintenance->init_comment;
            $message .= "\n Link: " . url('/');
            try {
                (new WhatsappController)->sendMessage($message, $telephone);
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
    public function store(Request $request)
    {
        $table_id = $request->table_id;
        $worker_id = $request->worker_id;
        $description = $request->description;
        $type = $request->type;
        $id = $request->id;
        $table_maintenance = TableUserMaintenance::firstOrNew(['id' => $id]);
        $table_maintenance->table_id = $table_id;
        $table_maintenance->user_id = $worker_id;
        $table_maintenance->type = $type;
        $table_maintenance->init_comment = $description;
        $table_maintenance->save();
        $this->sendMessage($table_maintenance);
        $this->changeStateTable($table_id, $type);
        return [
            'success' => true,
            'message' => $id ? 'Actualizado con exito' : 'Registrado con exito'
        ];
    }
    public function destroy()
    {
    }
    public function workers(Request $request)
    {
        $type = $request->type;
        $type = strtoupper($type);
        $worker_types_id = WorkersType::where('description', $type)->pluck('id');
        $users = User::whereIn('worker_type_id', $worker_types_id)
            ->where('active', true)
            ->get()
            ->transform(function ($row, $key) {
                return [
                    "id" => $row->id,
                    "name" => $row->name,
                    "area_id" => $row->area_id,
                    "worker_type_id" => $row->worker_type_id,
                    "establishment_id" => $row->establishment_id,
                ];
            });

        return [
            'success' => true,
            'records' => $users
        ];
    }
}
