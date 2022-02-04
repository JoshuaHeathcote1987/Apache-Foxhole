<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soldiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('squad_id');
            $table->string('game_name');
            $table->string('steam_id')->nullable();;
            $table->string('instagram')->nullable();;
            $table->string('twitter')->nullable();;
            $table->string('facebook')->nullable();;
            $table->string('twitch')->nullable();;
            $table->timestamps();
            $table->foreign('squad_id')
                ->references('id')
                ->on('squads')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soldiers');
    }
}
