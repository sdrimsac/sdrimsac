<?php

namespace Modules\Restobar\Events;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\Mozo;
use App\Models\Tenant\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Modules\Restaurant\Models\OrdenItem;

class OrdenReadyListEvent implements ShouldBroadcast
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
        $orden = OrdenItem::with(['user:id,name', 'food', 'orden.table', 'orden.mozo'])
            ->findOrFail($id);
        
        $this->order_item = [
            'id' => $orden->orden->id,
            'mozo_name' => $orden->orden->mozo->name ?? null
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
            new Channel('orden_list');
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
        return 'order-list-' . $event_name;
    }
}
