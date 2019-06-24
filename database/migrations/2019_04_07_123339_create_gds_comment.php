<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGdsComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gds_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->integer('spu_id')->default(0);
            $table->integer('sku_id')->default(0);
            $table->string('content')->default('')->comment('评论内容');
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
        Schema::dropIfExists('gds_common');
    }
}
