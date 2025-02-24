<?php

namespace Modules\Restaurant\Events;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\Restaurant\Http\Resources\OrdenItemCollection;
use Modules\Restaurant\Models\Food;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\Table;
use Illuminate\Support\Str;

class OrdenEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $order_item;
    public function __construct($id)
    {
        $orden = OrdenItem::with(['user:id,name', 'food', 'orden.table'])
            ->findOrFail($id);
        
        $this->order_item = [
            'id' => $id,
            'quantity' => $orden->quantity,
            'to_carry' => $orden->to_carry,
            'time' => $orden->time,
            'user' => $orden->user->name,
            'orden' => $orden->orden,
            'food' => $orden->food,
            'table' => $orden->orden->table,
            'observations' => $orden->observations
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return
            new Channel('orden_request');
    }

    public function broadcastAs()
    {
        $configuration = Configuration::first();
        $event_name = $configuration->socket_channel;
        if (!$event_name) {
            $configuration->socket_channel = Str::random(10);
            $configuration->save();
            $event_name = $configuration->socket_channel;
        }
        // Log::info('order-request-' . $event_name);
        return 'order-request-' . $event_name;
    }
}
