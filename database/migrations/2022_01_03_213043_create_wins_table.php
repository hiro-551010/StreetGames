<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wins', function (Blueprint $table) {
            $table->unsignedBigInteger('hold_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedtinyInteger('round1')->nullable();
            $table->unsignedtinyInteger('round2')->nullable();
            $table->unsignedtinyInteger('round3')->nullable();
            $table->unsignedtinyInteger('round4')->nullable();
            $table->unsignedtinyInteger('round5')->nullable();
            $table->unsignedtinyInteger('round6')->nullable();
            $table->unsignedtinyInteger('round7')->nullable();

            $table->foreign('hold_id')->references('hold_id')->on('players');
            $table->foreign('user_id')->references('user_id')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wins');
    }
}
