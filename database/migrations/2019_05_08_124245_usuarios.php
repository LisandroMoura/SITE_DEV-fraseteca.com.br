<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Usuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string("name",191); 
            $table->string("email",191);                         
            $table->string("sexo",2)->nullable();
            $table->string("password"); 
            

            $table->string("nome_completo",255)->nullable(); 
            $table->string("apelido",255)->nullable(); 
            $table->date("email_verificado_dt")->nullable();            
            $table->rememberToken();            
            $table->string("data_nascimento",11)->nullable();

            
            $table->string("perfil",11)->nullable();
            $table->string("status",11)->nullable();
            $table->string("termo",11)->nullable()->default('0');
            $table->string("avatar_icone_id",255)->nullable();
            $table->longText("informacoes_biograficas")->nullable();
            $table->string("honrarias",255)->nullable(); 
            $table->unsignedBigInteger('conquista_id')->nullable();
            $table->string("receber_news",11)->nullable();
            $table->string("receber_comentarios_notificacao",11)->nullable();
            
            $table->string("url",255)->nullable(); 
            $table->string("pasta",255)->nullable(); 

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
        Schema::dropIfExists('usuarios');
    }
}
