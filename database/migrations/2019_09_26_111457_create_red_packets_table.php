<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedPacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('red_packets', function (Blueprint $table) {
            $table->increments('id',0);
             $table->integer('app_id',0);
             $table->string('service',255);
             $table->text('url',0);
             $table->integer('created_at',0)->nullable();
             $table->integer('updated_at',0)->nullable();
             $table->integer('deleted_at',0)->nullable()->default(null);
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
        Schema::dropIfExists('red_packets');
    }
}
