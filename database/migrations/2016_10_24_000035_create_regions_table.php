<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
        });

        Schema::drop('regions');
    }
}