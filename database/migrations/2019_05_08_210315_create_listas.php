<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text("titulo");
            $table->text("descricao_previa")->nullable(); 
            $table->bigInteger("midia_id")->nullable();
            $table->longText("capa")->nullable();
            $table->longText("thumb")->nullable();
            
            $table->longText("conteudo")->nullable();
            $table->string("status",11);
            $table->bigInteger("post_id")->nullable();

            /**
             * foreignkeys 
             */

            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias')->ondDelete('cascade');

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
        Schema::dropIfExists('listas');
    }
}
