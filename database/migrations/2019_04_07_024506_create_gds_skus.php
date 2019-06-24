<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGdsSkus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gds_skus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('goods_id')->default(0)->comment('SPUID');
            $table->string('name',50)->default('')->comment('名称');
            $table->string('teacher',20)->default('')->comment('主讲人');
            $table->string('url',100)->default('')->comment('视频链接');
            $table->integer('timer')->default(0)->comment('时长');
            $table->string('intro')->default('')->comment('介绍');
            $table->integer('price')->default(0)->comment('价格');
            $table->integer('sorts')->default(0)->comment('排序');
            $table->integer('scan')->default(0)->comment('浏览');
            $table->tinyInteger('pay')->default(0)->comment('支持支付方式 详情见模型');
            $table->integer('number')->default(0)->comment('视频数量');
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
        Schema::dropIfExists('gds_skus');
    }
}
