<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function (Blueprint $table) {

            $table->string('google2fa_secret')->after('password')->nullable()->comment('google2fa密钥');
            $table->boolean('google2fa_enable')->after('google2fa_secret')->default(0)->comment('google2fa开启与否');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
