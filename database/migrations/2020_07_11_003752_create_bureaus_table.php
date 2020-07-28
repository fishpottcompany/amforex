<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBureausTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bureaus', function (Blueprint $table) {
            $table->bigIncrements('bureau_id');
            $table->string('bureau_name', 255)->unique();
            $table->string('bureau_hq_gps_address', 255);
            $table->longText('bureau_hq_location');
            $table->string('bureau_tin', 255)->unique();
            $table->string('bureau_license_no', 255)->unique();
            $table->string('bureau_registration_num', 255)->unique();
            $table->string('bureau_phone_1', 255);
            $table->string('bureau_phone_2', 255);
            $table->string('bureau_email_1', 255);
            $table->string('bureau_email_2', 255);
            $table->boolean('bureau_flagged');
            $table->timestamps();
        });
        
        Schema::table('bureaus', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id');
    
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
        Schema::dropIfExists('bureaus');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
