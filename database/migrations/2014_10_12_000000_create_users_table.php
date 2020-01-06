<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {//pinyin
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id',0);
             $table->string('name',255)->default('');
            $table->string('pinyin',255)->default('');
            $table->string('mobile',255);
             $table->string('password',255);
             $table->string('pic',512)->default('');
             $table->integer('identity')->default(2)->comment('身份');
             $table->integer('grade',0)->default(0)->comment('等级');
             $table->integer('fraction',0)->default(12)->comment('分数');
             $table->string('remember_token',100)->default('');
             $table->integer('status',0)->default(1);
             $table->string('shara_code',10);
             $table->integer('parent_id',0);
             $table->integer('initial_id',0);
            $table->integer('level',0)->default(0);
            $table->integer('groupchat',0)->comment('群组')->default(0);
            $table->integer('is_talk',0)->nullable();
            $table->integer('created_at',0)->nullable();
             $table->integer('updated_at',0)->nullable();
             $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
