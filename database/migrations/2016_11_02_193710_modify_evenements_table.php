<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyEvenementsTable extends Migration
{
        /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('evenements', function($table) {
			$table->dropColumn('finale');
			$table->dropColumn('division');
			$table->dropColumn('section');
            $table->dropColumn('type');
			
			$table->unsignedInteger('terrain_id');
			$table->unsignedInteger('type_id');
		
			$table->foreign('terrain_id')
					->references('id')
					->on('terrains')
					->onDelete('restrict')
					->onUpdate('cascade');
					
			$table->foreign('type_id')
					->references('id')
					->on('types_evenement')
					->onDelete('restrict')
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
		Schema::table('evenements', function($table)
		{
			$table->boolean('finale');
			$table->integer('division')->nullable();
			$table->char('section',1)->nullable();
			$table->string('type')->nullable();

            $table->dropColumn('terrain_id');
            $table->dropColumn('type_id');
        });
    }
}
