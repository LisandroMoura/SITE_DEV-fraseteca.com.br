<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCurtidasTable.
 */
class CreateCurtidasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('curtidas', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedBigInteger('post_id');
			$table->foreign('post_id')->references('id')->on('posts')->ondDelete('cascade');			
			$table->string("tipo",11)->default('0');
			$table->string("ip",191);
			$table->unsignedBigInteger('usuario_id')->nullable();									
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
		Schema::drop('curtidas');
	}
}
