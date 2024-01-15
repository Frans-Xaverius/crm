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
        Schema::create('socialblade_datas', function (Blueprint $table) {
            $table->id();
            $table->string('chanel')->nullable();
            $table->date('date')->nullable();
            $table->string('likes')->nullable();
            $table->string('comments')->nullable();
            $table->string('followers')->nullable();
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
        Schema::dropIfExists('socialblade_datas');
    }
};
