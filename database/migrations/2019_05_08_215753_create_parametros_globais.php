<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametrosGlobais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros_globais', function (Blueprint $table) {
            $table->bigIncrements('id');  
            //dados do projeto         
            $table->string("titulo_do_site",255); 
            $table->longText("logo");
            $table->longText("logoMobile");
            
            //servidor de imagens
            $table->string("servidor_imagens_app",255)->nullable(); 
            $table->string("servidor_imagens_usuario",255)->nullable(); 
            
            //paginações / Confif            
            $table->string("paginate",255)->nullable(); 
            $table->string("paginatePost",255)->nullable(); 
            $table->string("msg_final_listas",255)->nullable(); 
            
            //Dimensões de imagens do sistema
            $table->string("tamanho_upload_midia",255)->nullable(); 
            $table->string("txt_tamanho_upload_midia",255)->nullable();
            $table->string("width_upload_midia",255)->nullable(); 
            $table->string("height_upload_midia",255)->nullable(); 

            $table->string("tamanho_upload_adm",255)->nullable(); 
            $table->string("txt_tamanho_upload_adm",255)->nullable(); 
            
            $table->string("tamanho_upload_avatar",255)->nullable(); 
            $table->string("txt_tamanho_upload_avatar",255)->nullable(); 
            $table->string("width_upload_avatar",255)->nullable(); 
            $table->string("height_upload_avatar",255)->nullable();             
            
            //Configurações de Apis de terceiros
            $table->string("clientIdUnsplash",255)->nullable(); 
            $table->string("collectionDefault",255)->nullable(); 
            $table->string("perPageUnsplash",255)->nullable(); 
            $table->string("keyYandex",255)->nullable(); 
     
            $table->string("aux_1",255)->nullable(); 
            $table->string("aux_2",255)->nullable(); 
           
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
        Schema::dropIfExists('parametros_globais');
    }
}
