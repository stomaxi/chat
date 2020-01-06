<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\UserRegister' => [//注册事件
            'App\Listeners\UserRegisters',
        ],
        'App\Events\TransactionOrderCancel' => [//挂单取消事件
            'App\Listeners\TransactionOrderCancels',
        ],
        'App\Events\SendTalk' => [//聊天事件
            'App\Listeners\SendTalks',
        ],
        'App\Events\RedPacketFun' => [//红包回调事件
            'App\Listeners\RedPacketFuns',
        ],
        'App\Events\UserPy' => [//用户修改姓名获取拼音
            'App\Listeners\UserPys',
        ],
        'App\Events\NoticeUser' => [//通知用户事件
            'App\Listeners\NoticeUsers',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
