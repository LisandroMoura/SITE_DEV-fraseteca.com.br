<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFrasesFavoritasTable.
 */
class CreateFrasesFavoritasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('frases_favoritas', function(Blueprint $table) {
			$table->increments('id');			
			$table->string("status",11)->nullable()->default("1");
			$table->string("marcacao",191)->nullable();			
			/*
            * foreignkeys 
            **/            
            $table->unsignedBigInteger('usuario_id');
			$table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');
			
			$table->unsignedBigInteger('frase_id');
            $table->foreign('frase_id')->references('id')->on('frases')->ondDelete('cascade');
			
			

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
		Schema::drop('frases_favoritas');
	}
}
