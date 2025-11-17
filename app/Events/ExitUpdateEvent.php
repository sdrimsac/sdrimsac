<?php

namespace App\Events;

use App\Models\Tenant\Configuration;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class ExitUpdateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function broadcastOn()
    {
        $channel = new Channel('exit-channel');
        return $channel;
    }

    public function broadcastAs()
    {
        $configuration = Configuration::on('tenant')->first();
        $event_name = $configuration->socket_channel;
        $eventName = 'exit-' . $event_name;
        return $eventName;
    }

    public function broadcastWith()
    {
        return [
            'items' => $this->items
        ];
    }
}
