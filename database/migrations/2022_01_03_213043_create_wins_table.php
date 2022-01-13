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
            $table->boolean('round1')->nullable();
            $table->boolean('round2')->nullable();
            $table->boolean('round3')->nullable();
            $table->boolean('round4')->nullable();
            $table->boolean('round5')->nullable();
            $table->boolean('round6')->nullable();
            $table->boolean('round7')->nullable();

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
