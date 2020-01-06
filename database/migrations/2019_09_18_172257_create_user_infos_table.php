<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->increments('id',0);
             $table->integer('uid',0);
             $table->tinyinteger('type',0)->default(1);
             $table->string('name',255)->default('');
             $table->string('card',255)->default('');
             $table->string('mobile',255)->default('');
             $table->string('jy_password',255)->default('');//
            $table->decimal('rate',4,3)->default(0.000)->comment('费率');
            $table->tinyinteger('is_set_rate',0)->default(0);
            $table->tinyinteger('grade',0)->default(1);
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
        Schema::dropIfExists('user_infos');
    }
}
