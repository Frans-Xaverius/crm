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
        Schema::create('historical_fb', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->integer('user_id');
            $table->date('date');
            $table->integer('followers');
            $table->integer('likes');
            $table->integer('comments');
            $table->integer('reads');
            $table->integer('is_solved');
            $table->integer('unreads');
            $table->integer('visitors');
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
        Schema::dropIfExists('historical_fb');
    }
};
