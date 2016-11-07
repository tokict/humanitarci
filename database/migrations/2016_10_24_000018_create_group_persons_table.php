<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_persons', function (Blueprint $table) {
            $table->integer('person_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->dateTime('added_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('modified_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('status', ['active', 'removed'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group_persons');
    }
}