<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->string('name', 100);
            $table->integer('beneficiary_id')->unsigned();
            $table->integer('target_amount')->unsigned();
            $table->integer('target_amount_extra')->unsigned()->nullable();
            $table->string('currency', 3);
            $table->integer('cover_photo_id')->unsigned();
            $table->string('description_short', 150);
            $table->longText('description_full');
            $table->integer('organization_id')->unsigned();
            $table->integer('current_funds')->unsigned();
            $table->enum('status', ['active', 'inactive', 'goal_reached', 'goal_failed', 'blocked', 'ended'])->nullable();
            $table->integer('funds_transferred_amount')->unsigned()->nullable();
            $table->integer('donors_number')->unsigned()->nullable();
            $table->enum('type', ['money', 'goods', 'services'])->nullable();
            $table->integer('administrator_id')->unsigned();
            $table->dateTime('created_at')->default('CURRENT_TIMESTAMP');
            $table->timestamp('edited_at');
            $table->integer('priority')->default(0);
            $table->string('slug', 200);
            $table->string('tags', 255);
            $table->dateTime('action_by_date');
            $table->dateTime('ends')->nullable();
            $table->string('reference_id', 45);
            $table->longText('end_notes')->nullable();
            $table->longText('media_info');

            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries')->onDelete('no action')->onUpdate('no action');
            $table->foreign('administrator_id')->references('id')->on('admins')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('campaign_reports', function (Blueprint $table) {
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropForeign(['beneficiary_id']);
            $table->dropForeign(['administrator_id']);
        });


        Schema::table('campaign_reports', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
        });

        Schema::drop('campaigns');
    }
}