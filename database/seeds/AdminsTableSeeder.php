<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //后台用户
        $data = [
            'name' => 'root',
            'password' => \Illuminate\Support\Facades\Hash::make(123456),
            'id_ype' => '1',
        ];
        \Illuminate\Support\Facades\DB::table('admin_users')->insert($data);
    }
}
