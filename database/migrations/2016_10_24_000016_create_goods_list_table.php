<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->string('description', 255);
            $table->string('unit_measurement', 20);
            $table->string('cover_image_url', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('goods_list');
    }
}