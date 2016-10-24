<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference', 255);
            $table->dateTime('created_at')->default(CURRENT_TIMESTAMP);
            $table->dateTime('modified_at')->default(CURRENT_TIMESTAMP);
            $table->enum('type', ['image', 'video']);
            $table->boolean('is_local')->default(1);
            $table->string('description', 255)->nullable();
            $table->string('title', 45)->nullable();
            $table->integer('size_id');
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreign('cover_photo_id')->references('id')->on('media')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropForeign(['cover_photo_id']);
        });

        Schema::drop('media');
    }
}