<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->ondDelete('cascade');
            
            $table->string("status",11);

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('body')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->string("autor_email",191);
            $table->string("autor_nome",191);
            $table->string("autor_ip",191)->nullable();

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
        Schema::dropIfExists('comments');
    }
}
