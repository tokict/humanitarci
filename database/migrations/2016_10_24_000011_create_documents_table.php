<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned();
            $table->integer('person_id')->unsigned();
            $table->integer('donor_id')->unsigned();
            $table->enum('type', ['idScan']);
            $table->string('reference', 45);
            $table->dateTime('created_at')->default(CURRENT_TIMESTAMP);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('documents');
    }
}