<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGdsGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gds_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->default('')->comment('名称');
            $table->string('teacher',20)->default('')->comment('主讲人');
            $table->integer('timer')->default(0)->comment('时长');
            $table->integer('category_id')->default(0)->comment('分类');
            $table->string('intro')->default('')->comment('介绍');
            $table->integer('price')->default(0)->comment('价格');
            $table->integer('sorts')->default(0)->comment('排序');
            $table->tinyInteger('pay')->default(0)->comment('支持支付方式 详情见模型');
            $table->tinyInteger('type')->default(1)->comment('1单 2套餐');
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
        Schema::dropIfExists('gds_goods');
    }
}
