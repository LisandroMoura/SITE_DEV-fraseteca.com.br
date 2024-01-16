<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMidias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('midias', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger("tipo");
            $table->longText("url");
            $table->string("status",11);

            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');
            
            $table->string("em_uso",90)->nullable();

            $table->string("titulo")->nullable();
            $table->string("legenda")->nullable();
            $table->string("descricao")->nullable();

            $table->timestamps();
            $table->string("aux_1",255)->nullable(); 
            $table->string("aux_2",255)->nullable(); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('midias');
    }
}
