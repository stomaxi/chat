<?php

namespace App\Console\Commands;

use App\Repositories\RedisRepository;
use Illuminate\Console\Command;

class DelRedisCancel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delRedisCancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除过期的用户取消集合';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $obj = resolve(RedisRepository::class);
        $obj->delKey();
    }
}
