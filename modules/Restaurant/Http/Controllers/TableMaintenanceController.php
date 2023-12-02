<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Events\ReloadEvent;
use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\System\Configuration;
use App\Models\Tenant\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Restaurant\Models\Table;
use Modules\Restaurant\Models\TableUserMaintenance;
use Modules\Restaurant\Models\WorkersType;

class TableMaintenanceController extends Controller
{
    function change_table($table_id, $table_user_maintenance)
    {
        $type = $table_user_maintenance->type;
        $status = $table_user_maintenance->status;
        switch ($type) {
            case 'limpieza':
                $this->change_table_clean($table_id, $status);
                break;
            default:
                $this->change_table_maintenance($table_id, $status);
                break;
        }
    }
    function change_table_maintenance($table_id, $status)
    {
        $table = Table::find($table_id);
        switch ($status) {
            case 2:
                $table->status_table_id = 3;
                break;
            case 3:
                $table->status_table_id = 1;
                break;
        }
        $table->save();
    }
    function change_table_clean($table_id, $status)

    {
        $table = Table::find($table_id);
        switch ($status) {
            case 1:
                $configuration = Configuration::first();
                $minutes = $configuration->time_to_clean;
                $minutes = $minutes ?? 45;
                $table->is_cleaning = 1;
                $table->cleaning_start_date = Carbon::now()->addMinutes($minutes);
                break;
            case 3:
                $table->is_cleaning = 0;
                $table->cleaning_start_date = null;
                break;
        }
        $table->save();
    }
    public function change_state(Request $request)
    {
        $id = $request->id;
        $finish_comment = $request->finish_comment;
        $table_user_maintenance = TableUserMaintenance::find($id);
        $status = $table_user_maintenance->status;
        $table_id = $table_user_maintenance->table_id;
        $this->change_table($table_id, $table_user_maintenance);
        $new_status = $status == 1 ? 2 : ($status == 2 ? 3 : 1);
        
        if ($new_status == 3) {
            $table_user_maintenance->finish_comment = $finish_comment;
            $table_user_maintenance->finish_time = date('Y-m-d H:i:s');
        }

        if ($new_status == 2) {
            $table_user_maintenance->init_time = date('Y-m-d H:i:s');
        }
        $table_user_maintenance->status = $new_status;
        $table_user_maintenance->save();
        event(new ReloadEvent(true));
        return [
            'success' => true,
            'message' => 'Estado actualizado con exito'
        ];
    }
    public function records()
    {
        $records = TableUserMaintenance::where('user_id', auth()->id())
            ->whereIn('status', [1, 2])
            ->where('active', true)
            ->get()
            ->transform(function ($row, $key) {
                $table_name = null;
                $table = $row->table;
                $number = $table->number;
                $tower = $table->floor->tower->name;
                $table_name = "$tower - $number";
                return [
                    "id" => $row->id,
                    "table_id" => $row->table_id,
                    "user_id" => $row->user_id,
                    "type" => $row->type,
                    "init_comment" => $row->init_comment,
                    "name" => $table_name,
                    'status' => $row->status,
                ];
            });

        return [
            'success' => true,
            'records' => $records
        ];
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
