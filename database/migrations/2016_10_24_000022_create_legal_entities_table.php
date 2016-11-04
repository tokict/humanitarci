<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_entities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45)->nullable();
            $table->string('tax_id', 45)->nullable();
            $table->string('vat_id', 45)->nullable();
            $table->string('city_id', 45)->nullable();
            $table->string('address', 45)->nullable();
            $table->string('bank_id', 45)->nullable();
            $table->string('bank_acc', 45)->nullable();
            $table->boolean('is_beneficiary')->nullable();
            $table->dateTime('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('modified_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
        });


        Schema::table('group_legal_entities', function (Blueprint $table) {
            $table->foreign('legal_entity_id')->references('id')->on('legal_entities')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->foreign('representing_entity_id')->references('id')->on('legal_entities')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });

        Schema::table('group_legal_entities', function (Blueprint $table) {
            $table->dropForeign(['legal_entity_id']);
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['representing_entity_id']);
        });

        Schema::drop('legal_entities');
    }
}