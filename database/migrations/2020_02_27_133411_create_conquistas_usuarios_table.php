<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateConquistasUsuariosTable.
 */
class CreateConquistasUsuariosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conquistas_usuarios', function(Blueprint $table) {
            $table->bigIncrements('id');

			$table->unsignedBigInteger('conquista_id');
            $table->foreign('conquista_id')->references('id')->on('conquistas')->ondDelete('cascade');

            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');
					
			$table->string("notified",11)->nullable(); 
			$table->index('notified');

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
		Schema::drop('conquistas_usuarios');
	}
}
