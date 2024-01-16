<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexTocolNotified extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conquistas_usuarios', function (Blueprint $table) {
            $table->string("notified",11)->nullable(); 
            $table->index('notified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conquistas_usuarios', function (Blueprint $table) {
            //
        });
    }
}
