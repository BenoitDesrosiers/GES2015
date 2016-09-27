<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoitureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

    	 Schema::create('Voitures', function (Blueprint $table) {
            $table->unsignedInteger('voiture_id');  <<< changer pour id
			$table->string('modele');
			$table->date('date_achat');
			$table->unsignedInteger('identifiant');
			$table->timestamps();
				
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
        Schema::drop('Voitures');
    
        
    }
}
