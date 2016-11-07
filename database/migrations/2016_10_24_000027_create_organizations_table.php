<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('legal_entity_id')->unsigned();

            $table->foreign('legal_entity_id')->references('id')->on('legal_entities')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('goods_input', function (Blueprint $table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('media_links', function (Blueprint $table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('organization_reports', function (Blueprint $table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['legal_entity_id']);
        });


        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });

        Schema::table('goods_input', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });

        Schema::table('media_links', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });

        Schema::table('organization_reports', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
        });

        Schema::drop('organizations');
    }
}