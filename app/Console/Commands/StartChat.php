<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class StartChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $phpPath = PHP_BINARY;

        $separator  = DIRECTORY_SEPARATOR;
        $basePath = base_path();

        $artian = "{$phpPath} {$basePath}{$separator}artisan ";

        echo 2;

        $fp =popen("{$artian} chat:start_gw", "r");

        $this->call("chat:start_reg");


        echo 3;

       // passthru("{$artian} chat:start_reg");


        exit;



        system("{$artian} chat:start_gw");
        system("{$artian} chat:start_bw");


    }
}
