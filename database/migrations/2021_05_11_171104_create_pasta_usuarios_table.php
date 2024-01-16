<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePastaUsuariosTable.
 */
class CreatePastaUsuariosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */	 

	public function up()
	{
		Schema::create('pasta_usuarios', function(Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');
			$table->unsignedBigInteger('usuario_id_owner')->nullable(); 
			$table->bigInteger("pasta_id")->nullable();
			$table->string("titulo",255)->nullable();
			$table->text("descricao_previa")->nullable(); 
			$table->string("status",11)->nullable()->default("0");
			$table->bigInteger("post_id")->nullable();
			$table->longText("capa")->nullable();
            $table->longText("thumb")->nullable();
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
		Schema::drop('pasta_usuarios');
	}
}
