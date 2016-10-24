<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id')->unsigned()->nullable();
            $table->integer('entity_id')->unsigned()->nullable();
            $table->string('amount_donated', 45)->nullable();
            $table->string('total_donations', 45)->nullable();
            $table->string('goods_donated', 45)->nullable();
            $table->string('services_donated', 45)->nullable();
            $table->dateTime('created_at')->default('CURRENT_TIMESTAMP');
            $table->dateTime('modified_at')->default('CURRENT_TIMESTAMP');
        });

        Schema::table('action_logs', function (Blueprint $table) {
            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('donor_reports', function (Blueprint $table) {
            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('action_logs', function (Blueprint $table) {
            $table->dropForeign(['donor_id']);
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['donor_id']);
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['donor_id']);
        });

        Schema::table('donor_reports', function (Blueprint $table) {
            $table->dropForeign(['donor_id']);
        });

        Schema::drop('donors');
    }
}