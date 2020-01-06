<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->increments('id',0);
             $table->integer('uid',0);
            $table->tinyinteger('type',0);
            $table->string('content',800);
            $table->tinyinteger('is_read',0)->default(0);
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
        Schema::dropIfExists('notices');
    }
}
