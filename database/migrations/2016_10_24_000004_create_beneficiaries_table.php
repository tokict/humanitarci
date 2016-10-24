<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('identifier', 15);
            $table->integer('group_id')->unsigned()->nullable();
            $table->integer('profile_image_id')->unsigned();
            $table->integer('funds_used')->unsigned()->default(0);
            $table->integer('donor_number')->unsigned()->default(0);
            $table->enum('status', ['active', 'inactive', 'blocked', 'review', 'deleted'])->default('inactive');
            $table->integer('person_id')->unsigned()->nullable();
            $table->integer('entity_id')->unsigned()->nullable();
            $table->string('contact_phone', 45)->nullable();
            $table->string('contact_mail', 45)->nullable();
            $table->integer('created_by_id')->unsigned();
            $table->longText('description');
            $table->tinyInteger('members_public');
            $table->string('photo_ids', 255);
            $table->integer('company_id')->unsigned()->nullable();

            $table->foreign('created_by_id')->references('id')->on('admins')->onDelete('no action')->onUpdate('no action');
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
            $table->dropForeign(['created_by_id']);
        });

        Schema::drop('beneficiaries');
    }
}