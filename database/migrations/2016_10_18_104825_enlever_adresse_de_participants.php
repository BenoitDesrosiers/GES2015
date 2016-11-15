<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class EnleverAdresseDeParticipants créée par Émilio G! à partir du 161018.
 */
class EnleverAdresseDeParticipants extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('participants',function($table)
		{
			$table->dropColumn('adresse');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('participants',function($table)
		{
			$table->string('adresse')->nullable();
		});
	}
}
