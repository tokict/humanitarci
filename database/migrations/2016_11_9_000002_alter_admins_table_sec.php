<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAdminsTableSec extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('admins', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
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

            $table->foreign('created_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');


        });
    }
}