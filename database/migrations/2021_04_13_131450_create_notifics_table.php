<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateNotificsTable.
 */
class CreateNotificsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifics', function(Blueprint $table) {
            $table->bigIncrements('id');

			$table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');
			
			$table->string("status",11)->nullable()->default("0");
			$table->string("tipo",11)->default('1'); 
			$table->longText("texto")->nullable();
			$table->string("cb")->nullable(); 
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
		Schema::drop('notifics');
	}
}
/*
        'tipo',
        'cb',
        'aux_1',
        'aux_2',
*/