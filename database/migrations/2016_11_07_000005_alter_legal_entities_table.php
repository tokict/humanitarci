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
			$table->integer('represented_by')->unsigned();
			$table->char('contact_email', 100);
			$table->char('contact_phone', 20);
			$table->foreign('represented_by')->references('id')->on('persons')->onDelete('no action')->onUpdate('no action');

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
			$table->dropColumn('represented_by');
			$table->dropColumn('contact_email');
			$table->dropColumn('contact_phone');
			$table->dropForeign(['represented_by']);
		});
	}

}