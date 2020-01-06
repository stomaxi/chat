<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('checkTransactions')->everyMinute();//定时检查过期挂单
        $schedule->command('delRedisCancel')->dailyAt('04:00');//清除用户取消集合
        $schedule->command('checkTranasctionBuyExpire')->everyMinute();//定时检查过期用户购买挂单
        $schedule->command('checkOrderNoPayCurrency')->everyMinute();//定时检查挂单卖家超时未付款
        $schedule->command('CheckTaskPayMoneyExpire')->everyMinute();//定时检查红包商户超时未付款订单取消赔偿
        $schedule->command('CheckRedPacketOverTime')->everyMinute();//过期重发红包

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
