<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostsRelacionados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_relacionados', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->ondDelete('cascade');
            
            $table->unsignedBigInteger('post_rel');
            $table->foreign('post_rel')->references('id')->on('posts')->ondDelete('cascade');
            

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
        Schema::dropIfExists('posts_relacionados');
    }
}
