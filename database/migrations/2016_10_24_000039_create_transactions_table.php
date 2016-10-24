<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_donation_id')->unsigned();
            $table->integer('donation_id')->unsigned();
            $table->integer('amount')->unsigned()->nullable();
            $table->longText('goods')->nullable();
            $table->dateTime('time')->default(CURRENT_TIMESTAMP);
            $table->enum('type', ['user', 'admin', 'system']);
            $table->string('description', 255);
            $table->integer('campaign_id')->unsigned();

            $table->foreign('from_donation_id')->references('id')->on('donations')->onDelete('no action')->onUpdate('no action');
            $table->foreign('donation_id')->references('id')->on('donations')->onDelete('no action')->onUpdate('no action');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['from_donation_id']);
            $table->dropForeign(['donation_id']);
            $table->dropForeign(['campaign_id']);
        });


        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
        });

        Schema::drop('transactions');
    }
}