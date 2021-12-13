<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_contents', function (Blueprint $table) {
            $table->unsignedBigInteger('hold_id');
            $table->integer('people');
            $table->longText('rule');
            $table->date('schedule');

            $table->foreign('hold_id')->references('hold_id')->on('tournaments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournament_contents');
    }
}
