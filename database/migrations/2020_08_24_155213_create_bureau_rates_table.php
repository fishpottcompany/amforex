<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBureauRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bureau_rates', function (Blueprint $table) {
            $table->bigIncrements('bureau_rate_id');
            $table->string('bureau_rate_ext_id', 255)->unique();
            $table->string('currency_from_id', 255);
            $table->string('currency_to_id', 255);
            $table->decimal('rate', 4, 2);
            $table->timestamps();
        });

        Schema::table('bureau_rates', function (Blueprint $table) {
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
        Schema::dropIfExists('bureau_rates');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
