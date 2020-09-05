<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('branch_id');
            $table->string('branch_ext_id', 255)->unique();
            $table->string('branch_name', 255);
            $table->string('branch_gps_location', 255);
            $table->longText('branch_address');
            $table->string('branch_phone_1', 255);
            $table->string('branch_phone_2', 255)->nullable();
            $table->string('branch_email_1', 255);
            $table->string('branch_email_2', 255)->nullable();
            $table->boolean('branch_was_first');
            $table->boolean('branch_flagged');
            $table->string('creator_user_type', 255);
            $table->unsignedBigInteger('creator_id');
            $table->timestamps();
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->unsignedBigInteger('bureau_id');

            $table->foreign('bureau_id')->references('bureau_id')->on('bureaus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('branches');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
