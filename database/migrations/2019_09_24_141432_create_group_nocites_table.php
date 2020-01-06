<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupNocitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_nocites', function (Blueprint $table) {
            $table->increments('id',0);
            $table->integer('group_id',0);
             $table->integer('uid',0);
             $table->string('content',600);
             $table->integer('read_num',0);
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
        Schema::dropIfExists('group_nocites');
    }
}
