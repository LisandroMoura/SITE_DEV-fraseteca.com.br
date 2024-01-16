<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTagFrasesTable.
 */
class CreateTagFrasesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tagfrases', function(Blueprint $table) {
            $table->increments('id');

			$table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags')->ondDelete('cascade');  
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
		Schema::drop('tagfrases');
	}
}
