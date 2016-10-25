<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned();
        });
        Schema::table('campaign_reports', function (Blueprint $table) {
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_reports');
    }
}