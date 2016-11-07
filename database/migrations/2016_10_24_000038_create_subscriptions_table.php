<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('donor_id')->unsigned()->nullable();
            $table->integer('campaing_id')->unsigned()->nullable();
            $table->integer('amount')->nullable();
            $table->integer('service_id')->unsigned()->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('modified_at')->nullable();
            $table->enum('status', ['active', 'inactive', 'failed']);
            $table->longText('processing_data')->nullable();

            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('no action')->onUpdate('no action');
            $table->foreign('campaing_id')->references('id')->on('campaigns')->onDelete('no action')->onUpdate('no action');
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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['donor_id']);
            $table->dropForeign(['campaing_id']);
            $table->dropForeign(['service_id']);
        });

        Schema::drop('subscriptions');
    }
}