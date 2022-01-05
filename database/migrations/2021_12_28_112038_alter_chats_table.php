<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chats', function (Blueprint $table) {

            $table->dropColumn(['sender', 'receiver']);
            $table->unsignedBigInteger('room_id')->first();

            // 送信者のユーザーidの型変更
            $table->unsignedBigInteger('send_id')->change();
            $table->unsignedBigInteger('receive_id')->change();

            // readまたはunread（既読未読）
            $table->string('read_status')->after('message');
            $table->timestamp('created_at')->after('read_status');

            $table->foreign('room_id')->references('id')->on('chat_rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            
            $table->dropColumn(['room_id', 'read_status', 'created_at']);
            $table->integer('send_id')->change();
            $table->string('sender')->after('send_id');
            $table->integer('receive_id')->after('sender');
            $table->string('receiver')->after('receive_id');
        });
    }
}
