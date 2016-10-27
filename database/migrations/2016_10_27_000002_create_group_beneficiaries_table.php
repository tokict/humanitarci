<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_beneficiaries', function (Blueprint $table) {
            $table->integer('beneficiary_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->dateTime('added_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('modified_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('status', ['active', 'removed'])->default('active');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('no action')->onUpdate('no action');
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group_beneficiaries');
    }
}