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
        Schema::create('call_centers', function (Blueprint $table) {
            $table->id();
            $table->string('calldate')->nullable();
            $table->string('clid')->nullable();
            $table->string('src')->nullable();
            $table->string('dst')->nullable();
            $table->string('dcontext')->nullable();
            $table->string('channel')->nullable();
            $table->string('dstchannel')->nullable();
            $table->string('lastapp')->nullable();
            $table->string('lastdata')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('billsec')->nullable();
            $table->enum('disposition', ['ANSWERED','NO ANSWER'])->nullable();
            $table->integer('amaflags')->nullable();
            $table->string('accountcode')->nullable();
            $table->string('uniqueid')->nullable();
            $table->string('userfield')->nullable();
            $table->boolean('solved')->default(false)->nullable();
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
        Schema::dropIfExists('call_centers');
    }
};
