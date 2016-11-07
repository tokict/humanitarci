<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBanksTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('banks', function(Blueprint $table)
		{
			$table->integer('legal_entity_id')->unsigned();
			$table->foreign('legal_entity_id')->references('id')->on('legal_entities')->onDelete('no action')->onUpdate('no action');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('banks', function ($table) {
			$table->dropColumn('legal_entity_id');
			$table->dropForeign(['legal_entity_id']);
		});
	}

}