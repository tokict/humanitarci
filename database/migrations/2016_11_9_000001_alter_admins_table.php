<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
            $table->dropColumn('person_id');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('user_id')->unsigned();
            $table->integer('created_by')->unsigned();
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->integer('person_id');
            $table->foreign('person_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $table->dropColumn('created_at');
            $table->dropColumn('created_by');
            $table->dropColumn('user_id');

        });
    }
}