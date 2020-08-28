<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::dropIfExists('customers');
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->string('customer_am_id_number')->unique();
            $table->string('customer_surname', 255);
            $table->string('customer_firstname', 255);
            $table->string('customer_othernames', 255)->nullable();
            $table->string('customer_phone_number', 255)->unique();
            $table->string('customer_email', 255)->nullable();
            $table->string('customer_nationality', 255);
            $table->string('customer_id_1_id', 255)->unique();
            $table->string('customer_id_1_type', 255);
            $table->string('customer_id_1_number', 255);
            $table->string('customer_id_2_type', 255)->nullable();
            $table->string('customer_id_2_number', 255)->nullable();
            $table->string('customer_id_3_type', 255)->nullable();
            $table->string('customer_id_3_number', 255)->nullable();
            $table->boolean('customer_flagged');
            $table->timestamps();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('worker_id');
            $table->unsignedBigInteger('bureau_id');

            $table->foreign('bureau_id')->references('bureau_id')->on('bureaus');
            $table->foreign('worker_id')->references('worker_id')->on('workers');
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
        Schema::dropIfExists('customers');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}