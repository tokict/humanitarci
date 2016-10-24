<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 45);
            $table->string('middle_name', 45)->nullable();
            $table->string('last_name', 100);
            $table->string('social_id', 45)->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->string('address', 100)->nullable();
            $table->string('contact_phone', 45)->nullable();
            $table->string('contact_email', 45)->nullable();
            $table->longText('social_accounts')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('title', 20)->nullable();
            $table->boolean('is_donor')->nullable();
            $table->boolean('is_beneficiary');
            $table->boolean('is_admin');
            $table->integer('bank_id')->unsigned()->nullable();
            $table->string('bank_acc', 34)->nullable();
            $table->dateTime('created_at')->default('CURRENT_TIMESTAMP');
            $table->dateTime('modified_at')->default('CURRENT_TIMESTAMP');
            $table->integer('device_id')->unsigned()->nullable();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('no action')->onUpdate('no action');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('no action')->onUpdate('no action');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('group_legal_entities', function (Blueprint $table) {
            $table->foreign('legal_entity_id')->references('id')->on('persons')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('group_persons', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->foreign('representing_person_id')->references('id')->on('persons')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('media_links', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('outgoing_push', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('outgoing_sms', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['device_id']);
            $table->dropForeign(['bank_id']);
        });


        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::table('group_legal_entities', function (Blueprint $table) {
            $table->dropForeign(['legal_entity_id']);
        });

        Schema::table('group_persons', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['representing_person_id']);
        });

        Schema::table('media_links', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::table('outgoing_push', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::table('outgoing_sms', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::drop('persons');
    }
}