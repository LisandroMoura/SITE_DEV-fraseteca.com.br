<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagposts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagposts', function (Blueprint $table) {
            $table->bigIncrements('id');
             /*
            * foreignkeys 
            **/            
            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags')->ondDelete('cascade');  
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
        Schema::dropIfExists('tagposts');
    }
}
