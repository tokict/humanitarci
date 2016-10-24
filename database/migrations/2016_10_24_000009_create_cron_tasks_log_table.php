<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronTasksLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cron_tasks_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->string('action', 45);
            $table->longText('params')->nullable();
            $table->longText('output')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cron_tasks_log');
    }
}