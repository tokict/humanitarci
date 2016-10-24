<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutgoingSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outgoing_sms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id')->unsigned()->nullable();
            $table->integer('organization_id')->unsigned()->nullable();
            $table->integer('donor_id')->unsigned()->nullable();
            $table->integer('group_id')->unsigned()->nullable();
            $table->integer('legal_entity_id')->unsigned()->nullable();
            $table->longText('body');
            $table->dateTime('created_at')->default(CURRENT_TIMESTAMP);
            $table->dateTime('sent_at')->nullable();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('no action')->onUpdate('no action');
            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('no action')->onUpdate('no action');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('no action')->onUpdate('no action');
            $table->foreign('legal_entity_id')->references('id')->on('legal_entities')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outgoing_sms', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropForeign(['donor_id']);
            $table->dropForeign(['group_id']);
            $table->dropForeign(['legal_entity_id']);
        });

        Schema::drop('outgoing_sms');
    }
}