<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBannersTable.
 */
class CreateBannersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banners', function(Blueprint $table) {
            $table->increments('id');
			$table->string("urlamigavel",255)->nullable(); 
            $table->text("titulo");
			$table->longText("capa")->nullable();            
            $table->string("resumo",255)->nullable(); 
            //valores default
			$table->string("status",11)->default("1");			
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
		Schema::drop('banners');
	}
}
