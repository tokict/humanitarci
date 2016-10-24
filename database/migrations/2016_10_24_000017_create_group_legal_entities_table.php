<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupLegalEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_legal_entities', function (Blueprint $table) {
            $table->increments('legal_entity_id');
            $table->integer('group_id')->unsigned();
            $table->dateTime('added_at')->default('CURRENT_TIMESTAMP');
            $table->dateTime('modified_at')->default('CURRENT_TIMESTAMP');
            $table->enum('status', ['active', 'removed'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group_legal_entities');
    }
}