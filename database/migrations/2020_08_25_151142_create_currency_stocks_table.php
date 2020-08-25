<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_stocks', function (Blueprint $table) {
            $table->bigIncrements('stock_id');
            $table->string('stock_ext_id', 255)->unique();
            $table->decimal('stock', 12, 2);
            $table->timestamps();
        });

        Schema::table('currency_stocks', function (Blueprint $table) {
            $table->unsignedBigInteger('worker_id');
            $table->unsignedBigInteger('bureau_id');
            $table->unsignedBigInteger('currency_id');

            $table->foreign('currency_id')->references('currency_id')->on('currencies');
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
        Schema::dropIfExists('currency_stocks');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
