<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay', function (Blueprint $table) {
            $table->increments('id',0);
             $table->integer('uid');
             $table->integer('pay_id');
             $table->string('name',255);
             $table->string('account',255);
             $table->string('pay_pic',512)->default('');
             $table->string('other',512)->default('');
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
        Schema::dropIfExists('pay');
    }
}
