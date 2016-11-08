<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {

            $table->string('name', 100);
            $table->string('contact_email', 100);
            $table->string('contact_phone', 20);
            $table->string('donations_address', 100)->nullable();
            $table->string('donations_coordinates', 200)->nullable();
            $table->text('description');
            $table->integer('logo_id')->unsigned()->nullable();
            $table->integer('represented_by')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->enum('status', ['active', 'inactive']);


        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->foreign('logo_id')->references('id')->on('media')->onDelete('no action')->onUpdate('no action');
            $table->foreign('represented_by')->references('id')->on('persons')->onDelete('no action')->onUpdate('no action');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('no action')->onUpdate('no action');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn(['name', 'contact_email', 'contact_phone', 'donations_address', 'donations_coordinates',
            'description', 'logo_id', 'represented_by', 'city_id', 'status']);
            $table->dropForeign(['logo_id', 'represented_by', 'city_id']);
        });

    }
}