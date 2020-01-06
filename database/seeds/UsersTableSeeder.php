<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Artisan::call('setUser',[
            'mobile' => '15100000001',
            'password' => '123456',
        ]);

        //红包商户
        $data = [
            'id' => 2,
            'name' => '商户A',
            'mobile' => '',
            'password' => '',
            'groupchat' => 1,
            'shara_code'=>'',
            'parent_id' => 0,
            'initial_id' => 0,
            'identity' => 3,
        ];
        $mode = new \App\Storage\Database\User();
        $mode->insert($data);
        $red_data = [
            'app_id' => 2,
            'service' => 'qwertyuiop',
            'url' => 'http://10.0.6.113:8020/log',
        ];
        $server_mode = new \App\Storage\Database\RedPacket();
        $server_mode->insert($red_data);
    }

}
