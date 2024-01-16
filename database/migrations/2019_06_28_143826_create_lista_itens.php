<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListaItens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_itens', function (Blueprint $table) {
            $table->bigIncrements('id');

            /**
             * foreignkeys 
             */
            $table->unsignedBigInteger('lista_id');
            $table->foreign('lista_id')->references('id')->on('listas')->ondDelete('cascade');            

            $table->unsignedBigInteger('frase_id')->nullable();
            $table->longText("frase")->nullable();
            $table->string("status",11);            
            $table->bigInteger("post_id")->nullable();
            $table->string("autor",191);                        
            $table->timestamps();

            //campos auxiliares custons
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
        Schema::dropIfExists('lista_itens');
    }
}
