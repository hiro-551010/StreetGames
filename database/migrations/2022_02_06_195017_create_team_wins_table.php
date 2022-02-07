<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamWinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_wins', function (Blueprint $table) {
            $table->unsignedBigInteger('hold_id');
            $table->unsignedBigInteger('team_id');
            $table->string('round1')->nullable();
            $table->string('round2')->nullable();
            $table->string('round3')->nullable();
            $table->string('round4')->nullable();
            $table->string('round5')->nullable();
            $table->string('round6')->nullable();
            $table->string('round7')->nullable();

            $table->foreign('hold_id')->references('hold_id')->on('play_teams');
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_wins');
    }
}
