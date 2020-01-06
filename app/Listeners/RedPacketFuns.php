<?php

namespace App\Listeners;

use App\Events\RedPacketFun;
use App\Repositories\RedPacketRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RedPacketFuns implements ShouldQueue
{
    public $connection = 'redis';
    public $queue = 'redCurl';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RedPacketFun  $event
     * @return void
     */
    public function handle(RedPacketFun $event)
    {
        $redOBJ = resolve(RedPacketRepository::class);
        $redOBJ->send($event->uid,$event->data);
    }
}
