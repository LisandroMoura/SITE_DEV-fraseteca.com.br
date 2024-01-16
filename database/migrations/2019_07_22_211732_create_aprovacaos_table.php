<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAprovacaosTable.
 */
class CreateAprovacaosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('aprovacaos', function(Blueprint $table) {
			$table->increments('id');			
			$table->unsignedBigInteger('item_id');
			$table->string("tipo",11)->nullable();			
			$table->string("status",11);
			$table->text("observacao")->nullable(); 

			$table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');

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
		Schema::drop('aprovacaos');
	}
}
