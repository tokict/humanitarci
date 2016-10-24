<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonetaryInputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monetary_input', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('donor_id')->unsigned();
            $table->integer('amount');
            $table->dateTime('created_at')->default(CURRENT_TIMESTAMP);
            $table->integer('campaign_id')->unsigned();
            $table->integer('payment_provider_data_id')->unsigned();
            $table->integer('bank_transfer_data_id')->unsigned();

            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('no action')->onUpdate('no action');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('no action')->onUpdate('no action');
            $table->foreign('bank_transfer_data_id')->references('id')->on('bank_transfers_data')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->foreign('payment_id')->references('id')->on('monetary_input')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monetary_input', function (Blueprint $table) {
            $table->dropForeign(['donor_id']);
            $table->dropForeign(['campaign_id']);
            $table->dropForeign(['bank_transfer_data_id']);
        });


        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
        });

        Schema::drop('monetary_input');
    }
}