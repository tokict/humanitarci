<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beneficiaries', function ($table) {
            $table->dropForeign('beneficiaries_group_id_foreign');
            $table->dropColumn('group_id');

        });
    }
}
