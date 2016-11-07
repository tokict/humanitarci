<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeneficiaryReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiary_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('beneficiary_id')->unsigned();
            $table->enum('type', ['hourly', 'daily', 'weekly', 'monthly', 'quarterly', 'yearly', 'total']);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('start_time');
            $table->longText('data');

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
        Schema::table('beneficiary_reports', function (Blueprint $table) {
            $table->dropForeign(['beneficiary_id']);
        });

        Schema::drop('beneficiary_reports');
    }
}