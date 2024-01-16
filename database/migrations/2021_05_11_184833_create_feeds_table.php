<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFeedsTable.
 */
class CreateFeedsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feed', function(Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->ondDelete('cascade');			
			$table->string("status",11)->nullable()->default("0");
			$table->string("origem",11)->nullable()->default("0");
			$table->bigInteger("origem_id")->nullable();
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
		Schema::drop('feeds');
	}
}
