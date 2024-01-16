<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFavoritasTable.
 */
class CreateFavoritasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('favoritas', function(Blueprint $table) {
            $table->increments('id');

			$table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->ondDelete('cascade');

			$table->unsignedBigInteger('usuario_id');
			$table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');
			
			$table->string("status",11)->default('0');
			
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
		Schema::drop('favoritas');
	}
}
