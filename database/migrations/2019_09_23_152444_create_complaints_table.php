<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
             $table->increments('id',0);
             $table->string('complaint_id',255);
             $table->integer('uid',0);
             $table->tinyinteger('type',0);
             $table->string('order',255);
             $table->string('content',255)->default('');
             $table->string('pic',255)->default('');
             $table->tinyinteger('is_hand',0)->default(0);
            $table->tinyinteger('hand_order',0)->default(0);
             $table->string('hand_content',0)->default('');
             $table->integer('hand_at',0)->nullable();
             $table->integer('hand_uid',0)->nullable();
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
        Schema::dropIfExists('complaints');
    }
}
