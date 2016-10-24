<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsInputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_input', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->integer('donor_id')->unsigned();
            $table->longText('goods');
            $table->dateTime('created_at')->default('CURRENT_TIMESTAMP');

            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('no action')->onUpdate('no action');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->foreign('goods_received_id')->references('id')->on('goods_input')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods_input', function (Blueprint $table) {
            $table->dropForeign(['donor_id']);
            $table->dropForeign(['campaign_id']);
        });


        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['goods_received_id']);
        });

        Schema::drop('goods_input');
    }
}