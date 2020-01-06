<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id',0);
             $table->string('order_id',255);
             $table->integer('uid',0);
             $table->decimal('total',10,2)->default(0.00);
             $table->decimal('surplus',10,2)->default(0.00);
             $table->decimal('conduct',10,2)->default(0.00);
             $table->integer('min',0);
             $table->integer('max',0);
             $table->decimal('price',10,2)->default(1.00);
             $table->string('remarks',255)->default('');
             $table->integer('pay_type',0);
             $table->string('pay_list',255);
             $table->tinyinteger('status',0)->default(1);
            $table->integer('term_of_validity',0)->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
