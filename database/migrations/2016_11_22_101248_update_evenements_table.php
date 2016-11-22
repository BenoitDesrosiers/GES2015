<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEvenementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evenements',function(Blueprint $table)
		{
			$table->unsignedInteger('terrain_id')->nullable();
			$table->foreign('terrain_id')
				->references('id')
				->on('terrains')
				->onDelete('cascade')
				->onUpdate('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('evenements', function (Blueprint $table) {
    		$table->dropForeign(['terrain_id']);
    	});
		
        Schema::table('evenements',function(Blueprint $table)
		{
			$table->dropColumn('terrain_id');
		});
    }
}
