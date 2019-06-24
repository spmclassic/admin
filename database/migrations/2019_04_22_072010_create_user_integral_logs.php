<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserIntegralLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_integral_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->tinyInteger('type')->default(0)->comment('1订单消费积分 2签到积分等 见模型');
            $table->integer('integral')->default(0)->comment('积分');
            $table->integer('integral_new')->default(0)->comment('积分计算后快照');
            $table->string('content')->default('')->comment('描述内容');
            $table->tinyInteger('status')->default(1)->comment('1有效 0删除');
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
        Schema::dropIfExists('user_integral_logs');
    }
}
