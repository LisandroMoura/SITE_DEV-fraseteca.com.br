<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFrasesTable.
 */
class CreateFrasesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('frases', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string("url_longa_amigavel",191)->default("");
			$table->string("status",11)->nullable()->default("1");
			$table->longText("frase")->nullable();
			$table->string("autor",191)->nullable();			
			$table->string("origem",11)->nullable();
			$table->bigInteger("id_origem")->nullable();

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
		Schema::drop('frases');
	}
}
