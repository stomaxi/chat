<?php

namespace App\Listeners;

use App\Events\UserRegister;
use App\Repositories\AccountRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisters
{
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
     * @param  UserRegister  $event
     * @return void
     */
    public function handle(UserRegister $event)
    {
        //$event->user->id
        $this->addAccount($event->user->id);
        $this->addGroup($event);
    }
    public function addGroup($event)
    {
        $event->user->groupchat = $event->group;
        $event->user->save();
    }


    public function addAccount($uid)
    {
        $obj = resolve(AccountRepository::class);
        $obj->add($uid);
    }
}
