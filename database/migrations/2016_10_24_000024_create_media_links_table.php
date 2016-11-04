<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id')->unsigned()->nullable();
            $table->integer('campaign_id')->unsigned()->nullable();
            $table->integer('media_id')->unsigned()->nullable();
            $table->integer('organization_id')->unsigned()->nullable();
            $table->integer('person_id')->unsigned()->nullable();
            $table->integer('donor_id')->unsigned()->nullable();
            $table->integer('beneficiary_id')->unsigned()->nullable();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('no action')->onUpdate('no action');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('no action')->onUpdate('no action');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('no action')->onUpdate('no action');
            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('no action')->onUpdate('no action');
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_links', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropForeign(['campaign_id']);
            $table->dropForeign(['media_id']);
            $table->dropForeign(['donor_id']);
            $table->dropForeign(['beneficiary_id']);
        });

        Schema::drop('media_links');
    }
}