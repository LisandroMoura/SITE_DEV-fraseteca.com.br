<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHonrariasUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('honrarias_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');

            /**
             * foreignkeys 
             */
            $table->unsignedBigInteger('honraria_id');
            $table->foreign('honraria_id')->references('id')->on('honrarias');

            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');


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
        Schema::dropIfExists('honrarias_usuarios');
    }
}
