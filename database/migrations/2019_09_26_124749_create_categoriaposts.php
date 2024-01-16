<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriaposts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoriaposts', function (Blueprint $table) {
            $table->bigIncrements('id');
            /*
            * foreignkeys 
            **/            
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias')->ondDelete('cascade');  

            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->ondDelete('cascade');
            
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
        Schema::dropIfExists('categoriaposts');
    }
}
