<?php

namespace App\Events;

use App\Models\Tenant\Configuration;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class BalanzaItemReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function broadcastOn()
    {
        return new Channel('balanza-channel');
    }
    /* public function broadcastAs()
    {
        return 'balanza.event';
    } */

    public function broadcastAs()
    {
        $configuration = Configuration::first();
        $event_name = $configuration->socket_channel;
        return 'balanza-' . $event_name;
    }

    

}
