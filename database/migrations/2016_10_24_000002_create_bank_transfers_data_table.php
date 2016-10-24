<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTransfersDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transfers_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payee_name', 45);
            $table->string('payee_account', 45);
            $table->dateTime('time');
            $table->integer('amount')->unsigned();
            $table->string('reference', 45);
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bank_transfers_data');
    }
}