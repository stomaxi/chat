<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_orders', function (Blueprint $table) {
              $table->increments('id',0);
             $table->string('order_id',255);
             $table->integer('uid',0);
             $table->string('transactions_id',255);
             $table->integer('sell_uid');
             $table->decimal('num',10,2);
            $table->decimal('price',10,2)->default(1.00);
            $table->decimal('parents_num',10,2);
            $table->decimal('get_num',10,2);
            $table->integer('pay_type',0);
             $table->string('pay_list',255);
             $table->string('pay_rand',255);
             $table->integer('term_of_validity',0);
             $table->tinyinteger('status',0)->default(1);
            $table->integer('pay_currency_time',0)->nullable();
            $table->integer('pay_money_time',0)->nullable();
             $table->integer('created_at',0)->nullable();
             $table->integer('updated_at',0)->nullable();

             $table->engine='Innodb';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_orders');
    }
}
