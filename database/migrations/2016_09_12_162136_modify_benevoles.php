<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBenevoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ajout de la date de naissance et du sexe
        Schema::table('benevoles', function($table)
        		{
        			$table->date('date_naissance')->nullable();
        			$table->char('sexe',1)->default('h');
        		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    	Schema::table('benevoles', function($table)
    			{
    				$table->dropColumn('date_naissance');
    				$table->dropColumn('sexe');
    			});
    }
}
