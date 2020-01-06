<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id',0)->comment('');
            $table->string('order',255)->comment('订单id');
            $table->string('use_pay',255)->comment('支持支付方式');
            $table->integer('send_uid',0)->comment('发任务uid');
             $table->integer('num',0)->comment('数量');
             $table->decimal('price',10,2)->default(1.00)->comment('单价');
             $table->decimal('money',10,2)->comment('支付金额');
             $table->tinyinteger('status',0)->default(1)->comment('状态');
             $table->tinyinteger('repeat_num',0)->default(0)->comment('重复发送次数');
             $table->integer('efffet_at',0)->nullable()->comment('有效期');
             $table->integer('uid',0)->default(0)->comment('抢单uid');
             $table->text('pay',0)->nullable()->comment('支付方式');
             $table->integer('task_at',0)->nullable()->comment('抢单时间');
             $table->integer('complaints_at',0)->nullable()->comment('可投诉时间');
             $table->integer('get_money_at',0)->nullable()->comment('支付时间');
            $table->integer('complaint_user_at',0)->nullable()->comment('商户可投诉时间');
            $table->integer('get_currency_at',0)->nullable()->comment('支付币时间');
            $table->integer('set_complaints_at',0)->nullable()->comment('投诉时间');
            $table->integer('complaints_id',0)->nullable()->comment('投诉id');
            $table->integer('cancel_at',0)->nullable()->comment('取消时间');
            $table->integer('cancel_reward',0)->nullable()->comment('取消奖励');
            $table->integer('created_at',0)->nullable()->comment('');
             $table->integer('updated_at',0)->nullable()->comment('');
             $table->integer('deleted_at',0)->nullable()->default(null)->comment('');
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
        Schema::dropIfExists('tasks');
    }
}
