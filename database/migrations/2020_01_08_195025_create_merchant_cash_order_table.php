<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantCashOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_cash_order', function (Blueprint $table) {
            $table->increments('id',0);
             $table->integer('uid',0)->comment('商户id');
             $table->integer('order',0)->comment('订单编号');
             $table->tinyinteger('type',0)->comment('类型');
             $table->tinyinteger('status',0)->default(1)->comment('状态');
             $table->integer('num',0)->comment('数量');
             $table->integer('admin_uid',0)->nullable()->comment('处理人');
            $table->integer('hand_at',0)->nullable()->comment('处理时间');
            $table->integer('created_at',0)->nullable()->comment('');
             $table->integer('updated_at',0)->nullable()->comment('');
             $table->integer('deleted_at',0)->nullable()->default(null)->comment('');
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
        Schema::dropIfExists('merchant_cash_order');
    }
}
