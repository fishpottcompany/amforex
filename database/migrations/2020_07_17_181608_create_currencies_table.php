<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->bigIncrements('currency_id');
            $table->string('currency_full_name', 255)->unique();
            $table->string('currency_abbreviation', 255)->unique();
            $table->string('currency_symbol', 255);
            $table->boolean('currency_flagged');
            $table->timestamps();
        });

        Schema::table('currencies', function (Blueprint $table) {
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
        Schema::dropIfExists('currencies');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
