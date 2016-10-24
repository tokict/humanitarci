<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentProviderDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_provider_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_id')->unsigned()->nullable();
            $table->integer('provider_id')->unsigned();
        });

        Schema::table('monetary_input', function (Blueprint $table) {
            $table->foreign('payment_provider_data_id')->references('id')->on('payment_provider_data')->onDelete('no action')->onUpdate('no action');
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
            $table->dropForeign(['payment_provider_data_id']);
        });

        Schema::drop('payment_provider_data');
    }
}