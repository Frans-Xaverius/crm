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
        Schema::create('wa_bot', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('curr_level')->default(0);
            $table->integer('curr_option')->default(0);
            $table->integer('curr_parent')->default(0);
            $table->integer('has_intro')->default(0);
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
        Schema::dropIfExists('wa_bot');
    }
};
