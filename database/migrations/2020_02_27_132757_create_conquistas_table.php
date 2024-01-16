<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateConquistasTable.
 */
class CreateConquistasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conquistas', function(Blueprint $table) {
			$table->bigIncrements('id');			
			$table->string("nome",255);
			$table->string("descricao",255);
			$table->longText("icone");
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
		Schema::drop('conquistas');
	}
}
