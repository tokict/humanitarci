<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->string('key', 45);
            $table->string('api_uri', 255);
            $table->dateTime('created_at')->default(CURRENT_TIMESTAMP);
            $table->dateTime('modified_at')->default(CURRENT_TIMESTAMP);
        });

        Schema::table('payment_provider_data', function (Blueprint $table) {
            $table->foreign('provider_id')->references('id')->on('payment_providers')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('payment_provider_data', function (Blueprint $table) {
            $table->dropForeign(['provider_id']);
        });

        Schema::drop('payment_providers');
    }
}