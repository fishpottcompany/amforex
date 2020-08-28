<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        //Schema::dropIfExists('customers');
        Schema::create('trades', function (Blueprint $table) {
            $table->bigIncrements('trade_id');
            $table->unsignedBigInteger('trade_currency_in_id');
            $table->unsignedBigInteger('trade_currency_in_old_stock');
            $table->unsignedBigInteger('trade_currency_in_new_stock');
            $table->decimal('trade_currency_in_amount');
            $table->unsignedBigInteger('trade_currency_out_id');
            $table->unsignedBigInteger('trade_currency_out_old_stock');
            $table->unsignedBigInteger('trade_currency_out_new_stock');
            $table->decimal('trade_currency_out_amount');
            $table->decimal('trade_bureau_rate', 4, 2);
            $table->decimal('trade_bog_rate', 4, 2);
            $table->boolean('trade_flagged');
            $table->timestamps();
        });

        Schema::table('trades', function (Blueprint $table) {
            $table->string('customer_id_1_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('bureau_id');
            $table->unsignedBigInteger('worker_id');

            $table->foreign('customer_id_1_id')->references('customer_id_1_id')->on('customers');
            $table->foreign('branch_id')->references('branch_id')->on('branches');
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
        Schema::dropIfExists('trades');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
