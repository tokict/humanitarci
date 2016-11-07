<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLegalEntitiesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('legal_entities', function(Blueprint $table)
		{

			$table->integer('bank_id')->unsigned()->change();
			$table->integer('city_id')->unsigned()->change();
			$table->foreign('bank_id')->references('id')->on('banks')->onDelete('no action')->onUpdate('no action');
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
		Schema::table('legal_entities', function ($table) {
			$table->char('bank_id', 45)->change();
			$table->dropForeign(['bank_id', 'city_id']);
		});
	}

}