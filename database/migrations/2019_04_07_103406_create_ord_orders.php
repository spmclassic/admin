<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ord_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial',50)->default('')->comment('订单号');
            $table->integer('user_id')->default(0)->comment('用户ID');
            $table->string('name',50)->default('')->comment('姓名');
            $table->string('mobile',15)->default('')->comment('手机号');
            $table->string('goods_name')->default('')->comment('商品名称');
            $table->tinyInteger('pay_type')->default(0)->comment('1微信 2积分');
            $table->integer('price')->default(0)->comment('金额');
            $table->tinyInteger('status')->default(0)->comment('1待付款 5付款成功 9取消订单');
            $table->timestamp('payed_at')->nullable();
            $table->timestamp('assess_at')->nullable();
            $table->timestamps();
        });

        Schema::create('ord_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->default(0);
            $table->integer('spu_id')->default(0);
            $table->integer('sku_id')->default(0);
            $table->timestamps();
        });

        Schema::create('ord_order_pays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial',50)->default('')->comment('支付单号');
            $table->integer('order_id')->default(0);
            $table->integer('price')->default(0);
            $table->tinyInteger('type')->default(1)->comment('1付款 9退款');
            $table->string('out_trade_no',100)->default('')->comment('支付单号');
            $table->tinyInteger('log_status')->default(1)->comment('1发起 2成功 3失败');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ord_orders');
    }
}
