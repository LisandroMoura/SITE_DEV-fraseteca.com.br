<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("tipo",11)->default('1'); //1)frase 2)artigos 3)pages Institucionais

            $table->string("urlamigavel",255); 
            $table->text("titulo");

            //resumo
            $table->string("resumo",255)->nullable(); 
            
            //valores default
            $table->string("status",11);
            $table->string("situacao",80)->default('0'); //0)rascunho - 1)publicado

            
            $table->string("mostrar_index",11)->default('1'); //0)não - 1)sim
            
            //corpo
            $table->longText("corpo");

            //midia: Id, tem id da nossa tabela Mídia, ou tem capa(url específica)
            $table->bigInteger("midia_id")->nullable();
            $table->longText("capa")->nullable();
            $table->longText("thumb")->nullable();


            $table->string("imprime_capa",11)->default('1'); //0)não - 1)sim 

            //categoria ID
            $table->bigInteger("categoria_id")->nullable();
            //TAgs
            $table->string("tags",255)->nullable(); 

            $table->bigInteger("lista_id")->nullable();
            $table->bigInteger('autor_id')->nullable();            
            /**
             * foreignkeys 
             */
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');

            $table->timestamps();
            $table->string("aux_1",255)->nullable()->default(''); 
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
        Schema::dropIfExists('posts');
    }
}
