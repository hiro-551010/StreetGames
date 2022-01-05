<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_rooms', function (Blueprint $table) {
            // 大会参加者との個別のチャットルーム
            $table->id();
            $table->unsignedBigInteger('hold_id');
            $table->unsignedBigInteger('player_id');
            $table->timestamp('created_at');

            // 値が入ればチャットルームを閉じる
            $table->timestamp('closed_at')->nullable();

            $table->foreign('hold_id')->references('hold_id')->on('hosts');
            $table->foreign('player_id')->references('user_id')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_rooms');
    }
}
