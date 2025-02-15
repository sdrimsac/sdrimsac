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

class StateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $order;
    public function __construct(Orden $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('orders');
    }

    /* public function broadcastAs()
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
    } */
    public function broadcastWith()
    {
        return [
            'orden_id' => $this->order->id,
            'status_orden_id' => $this->order->status_orden_id
        ];
    }
}
