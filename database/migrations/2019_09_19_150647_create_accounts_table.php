<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id',0);
             $table->integer('uid',0);
             $table->decimal('flow',10,2)->default(0.00)->comment('流动');
             $table->decimal('frozen',10,2)->default(0.00)->comment('冻结');
             $table->decimal('reward',10,2)->default(0.00)->comment('奖励');
             $table->decimal('task',10,2)->default(0.00)->comment('任务奖励');
             $table->tinyinteger('status',0)->default(1);
             $table->integer('created_at',0)->nullable();
             $table->integer('updated_at',0)->nullable();
             $table->engine = 'Innodb';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
