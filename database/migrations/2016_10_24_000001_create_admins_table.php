<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id')->unsigned();
            $table->integer('organization_id')->unsigned()->nullable();
            $table->string('password', 100);
        });

        Schema::table('action_logs', function (Blueprint $table) {
            $table->foreign('id_admin')->references('id')->on('admins')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('action_logs', function (Blueprint $table) {
            $table->dropForeign(['id_admin']);
        });

        Schema::drop('admins');
    }
}