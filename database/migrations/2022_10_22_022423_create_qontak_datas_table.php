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
        Schema::create('qontak_datas', function (Blueprint $table) {
            $table->id();
            $table->string('channel')->nullable();
            $table->string('_id', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('unread_count', 255)->nullable();
            $table->date('_created_at')->nullable();
            $table->date('_updated_at')->nullable();
            $table->dateTime('resolved_at')->nullable();
            $table->string('resolved_by_id', 255)->nullable();
            $table->string('resolved_by_type', 255)->nullable();
            $table->string('agent_ids', 255)->nullable();
            $table->string('tags', 255)->nullable();
            $table->string('sender_id', 255)->nullable();
            $table->string('full_name', 255)->nullable();
            $table->string('username', 255)->nullable();
            $table->string('phone_number', 255)->nullable();
            $table->string('status', 255)->nullable();
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
        Schema::dropIfExists('qontak_datas');
    }
};
