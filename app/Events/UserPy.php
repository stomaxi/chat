<?php
//修改用户的首字母拼音
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserPy
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $uid = '';
    public $name = '';
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($uid, $name)
    {
        $this->uid = $uid;
        $this->name = $name;
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
