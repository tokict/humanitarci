<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->string('description', 45);
            $table->integer('representing_person_id')->unsigned()->nullable();
            $table->integer('representing_entity_id')->unsigned()->nullable();
        });

        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('group_legal_entities', function (Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('group_persons', function (Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
        });

        Schema::table('group_legal_entities', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
        });

        Schema::table('group_persons', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
        });

        Schema::drop('groups');
    }
}