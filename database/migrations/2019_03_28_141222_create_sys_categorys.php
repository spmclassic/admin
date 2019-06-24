<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysCategorys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',60)->default('')->comment('分类名称');
            $table->string('image',160)->default('')->comment('分类图片');
            $table->integer('sorts')->default(0);
            $table->integer('parent_id')->default(0);
            $table->tinyInteger('type')->default(0)->comment('备注见模型');
            $table->tinyInteger('status')->default(2)->comment('1正常 2冻结');
            $table->timestamps();
        });

        Schema::create('sys_categoryables', function (Blueprint $table) {
            $table->integer('category_id');
            $table->integer('categoryable_id');
            $table->string('categoryable_type',160);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_categorys');
    }
}
