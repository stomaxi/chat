<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flows', function (Blueprint $table) {
            $table->increments('id',0);
             $table->integer('uid',0);
             $table->tinyinteger('flow_type',0);
             $table->string('source',255);
             $table->decimal('num',10,2);
             $table->decimal('before_num',10,2);
             $table->decimal('after_num',10,2);
             $table->string('symbol',255);
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
        Schema::dropIfExists('flows');
    }
}
