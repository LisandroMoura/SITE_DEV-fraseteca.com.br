<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePastaUsuarioItemsTable.
 */
class CreatePastaUsuarioItemTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pasta_usuario_item', function(Blueprint $table) {
            $table->bigIncrements('id');

			$table->unsignedBigInteger('pasta_id');
			$table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');
            $table->foreign('pasta_id')->references('id')->on('pasta_usuarios')->ondDelete('cascade');
			$table->bigInteger("frase_id")->nullable();
			$table->string("status",11)->nullable()->default("0");
			$table->longText("frase")->nullable();
			$table->string("autor",191)->nullable();			
			$table->bigInteger("ordem")->nullable();			
			$table->string("token",191)->nullable();
			$table->string("mostraimg",11)->nullable()->default("0");						
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
		Schema::drop('pasta_usuario_item');
	}
}
