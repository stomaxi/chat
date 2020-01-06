<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupchatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupchats', function (Blueprint $table) {
            $table->increments('id',0);
             $table->integer('master',0)->nullable();
             $table->string('name',255)->default('未命名');
             $table->tinyinteger('status',0)->default(1);
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
        Schema::dropIfExists('groupchats');
    }
}
