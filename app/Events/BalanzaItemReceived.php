<?php

namespace App\Events;

use App\Models\Tenant\Configuration;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class BalanzaItemReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $items;

    public function __construct($items)
    {
        $this->items = $items;
        Log::info('BalanzaItemReceived evento creado', ['items' => $items]);
    }

    public function broadcastOn()
    {
        $channel = new Channel('balanza-channel');
        Log::info('Broadcasting en canal', ['channel' => 'balanza-channel']);
        return $channel;
    }
    /* public function broadcastAs()
    {
        return 'balanza.event';
    } */

    public function broadcastAs()
    {
        $configuration = Configuration::first();
        $event_name = $configuration->socket_channel ?? 'default';
        $eventName = 'balanza-' . $event_name;
        Log::info('Broadcasting como evento', ['event_name' => $eventName]);
        return $eventName;
    }

    public function broadcastWith()
    {
        return [
            'items' => $this->items
        ];
    }
}
