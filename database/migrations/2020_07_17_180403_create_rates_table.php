<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->bigIncrements('rate_id');
            $table->string('rate_ext_id', 255)->unique();
            $table->string('currency_from_id', 255);
            $table->string('currency_to_id', 255);
            $table->decimal('rate', 4, 2);
            $table->timestamps();
        });

        Schema::table('rates', function (Blueprint $table) {
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
        Schema::dropIfExists('rates');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
