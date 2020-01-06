<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TransactionOrderCancel
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderOBJ = '';
    public $obj = '';
    public $type = '';
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($orderOBJ,$obj,$type = 1)
    {
        $this->orderOBJ = $orderOBJ;
        $this->obj = $obj;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
