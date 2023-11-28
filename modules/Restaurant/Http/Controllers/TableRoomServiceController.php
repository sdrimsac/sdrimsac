<?php

namespace Modules\Restaurant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\ItemRoomService;
use Modules\Restaurant\Models\RoomService;

class TableRoomServiceController extends Controller
{

    public function record($id){
        $record = RoomService::findOrFail($id);
        $record->items = $record->items->transform(function($row, $key){
            $row->description = $row->food->description;
            $row->id = $row->food->item_id;
            return $row;
        });
        return [
            'success' => true,
            'record' => $record
        ];
    }

    public function records(Request $request){
        $records = RoomService::get()
        
        ->transform(function($row, $key){
            $row->items = $row->items->transform(function($row, $key){
                $row->description = $row->food->description;
                return $row;
            });
            return $row;
        });

        return [
            'success' => true,
            'records' => $records
        ];
    }
    public function destroy($id){
        $room_service = RoomService::findOrFail($id);
        $room_service->delete();

        return [
            'success' => true,
            'message' => 'Servicio de habitación eliminado con éxito'
        ];
    }
    public function room_services(Request $request)
    {
        $id = $request->id;
        $items = $request->items;
        $room_service = RoomService::firstOrNew(['id' => $id]);
        $room_service->name = $request->name;
        $room_service->description = $request->description;
        $room_service->due_time = $request->due_time;

        if ($items  && count($items) > 0) {
            $room_service->has_items = true;
        }
        $room_service->save();
        $room_service->items()->delete();

        if ($items  && count($items) > 0) {
            foreach ($items as $row) {
                $item_room_service = new ItemRoomService;
                $item_room_service->room_service_id = $room_service->id;
                $id = $row['id'];
                $food = Food::where('item_id', $id)->first();
                $item_room_service->food_id = $food->id;
                $item_room_service->quantity = $row['quantity'];
                $item_room_service->save();
            }
        }

        return [
            'success' => true,
            'message' => 'Servicio de habitación registrado con éxito'
        ];
    }
}
