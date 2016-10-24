<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonorReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donor_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('donor_id')->unsigned();
            $table->enum('type', ['hourly', 'daily', 'weekly', 'monthly', 'quarterly', 'yearly', 'total']);
            $table->dateTime('start_time');
            $table->dateTime('created_at')->default('CURRENT_TIMESTAMP');
            $table->longText('donator_reportscol')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('donor_reports');
    }
}