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
            $table->string('branch_gps_location', 255)->nullable();
            $table->string('branch_address', 255);
            $table->integer('branch_flagged');
            $table->timestamps();
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->unsignedBigInteger('bureau_id');
            $table->unsignedBigInteger('admin_id');

            $table->foreign('bureau_id')->references('bureau_id')->on('bureaus');
            $table->foreign('admin_id')->references('admin_id')->on('administrators');
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
