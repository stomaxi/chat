<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talks', function (Blueprint $table) {
            $table->increments('id',0);
             $table->integer('uid',0);
             $table->tinyinteger('type',0);
             $table->text('content');
             $table->integer('created_at',0)->nullable();
             $table->integer('updated_at',0)->nullable();
             $table->integer('deleted_at',0)->nullable()->default(null);
             $table->string('groups',255);
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
        Schema::dropIfExists('talks');
    }
}
