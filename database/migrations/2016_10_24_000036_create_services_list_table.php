<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->string('description', 255);
            $table->string('cover_image_url', 255);
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->foreign('service_id')->references('id')->on('services_list')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
        });

        Schema::drop('services_list');
    }
}