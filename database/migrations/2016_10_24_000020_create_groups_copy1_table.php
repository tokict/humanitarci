<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsCopy1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_copy1', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45)->nullable();
            $table->string('description', 45)->nullable();
            $table->string('representing_person_id', 45)->nullable();
            $table->string('representing_entity_id', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('groups_copy1');
    }
}