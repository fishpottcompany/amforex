<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasscodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passcodes', function (Blueprint $table) {
            $table->bigIncrements('passcode_id');
            $table->string('user_type', 255);
            $table->string('user_id', 255);
            $table->string('passcode', 255);
            $table->boolean('used');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passcodes');
    }
}
