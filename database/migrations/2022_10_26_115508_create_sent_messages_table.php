<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_messages', function (Blueprint $table) {
            $table->id();
            $table->string('room_id');
            $table->string('sender_id');
            $table->string('sender_name')->nullable();
            $table->string('channel');
            $table->string('type');
            $table->text('text')->nullable();
            $table->string('attachment')->nullable();
            $table->string('filename')->nullable();
            $table->string('file_url')->nullable();
            $table->string('_created_at');
            $table->string('avatar')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('account_uniq_id')->nullable();
            $table->string('channel_account')->nullable();
            $table->string('participant_type')->nullable();
            $table->dateTime('resolved_at')->nullable();
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
        Schema::dropIfExists('sent_messages');
    }
};
