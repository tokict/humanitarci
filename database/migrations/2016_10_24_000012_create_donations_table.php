<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('beneficiary_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->integer('donor_id')->unsigned();
            $table->enum('type', ['money', 'goods', 'service']);
            $table->integer('amount')->unsigned()->nullable();
            $table->enum('status', ['received', 'on_hold', 'used', 'free', 'repurposed'])->default('received');
            $table->dateTime('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('source', ['site', 'bank_transfer', 'on_hands', 'sms', 'delivery_service']);
            $table->longText('goods')->nullable();
            $table->integer('payment_id')->unsigned()->nullable();
            $table->integer('transaction_id')->unsigned()->nullable();
            $table->integer('goods_received_id')->unsigned()->nullable();
            $table->integer('service_id')->unsigned()->nullable();
            $table->boolean('service_delivered')->nullable();
            $table->integer('organization_id')->unsigned();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('no action')->onUpdate('no action');
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
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
            $table->dropForeign(['beneficiary_id']);
        });

        Schema::drop('donations');
    }
}