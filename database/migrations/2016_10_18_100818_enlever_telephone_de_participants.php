<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class EnleverTelephoneDeParticipants créée par Émilio G! à partir du 161018.
 */
class EnleverTelephoneDeParticipants extends Migration
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
			$table->dropColumn('telephone');
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
			$table->string('telephone')->nullable();
		});
    }
}
