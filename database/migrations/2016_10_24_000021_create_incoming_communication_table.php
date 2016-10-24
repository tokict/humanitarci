<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomingCommunicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incoming_communication', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['mail', 'sms']);
            $table->string('subject', 255)->nullable();
            $table->longText('body')->nullable();
            $table->longText('attachments')->nullable();
            $table->string('mail_to', 45)->nullable();
            $table->string('mail_from', 45)->nullable();
            $table->string('msisdn_from', 45)->nullable();
            $table->integer('device_id_from')->unsigned()->nullable();

            $table->foreign('device_id_from')->references('id')->on('devices')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incoming_communication', function (Blueprint $table) {
            $table->dropForeign(['device_id_from']);
        });

        Schema::drop('incoming_communication');
    }
}