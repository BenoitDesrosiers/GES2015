<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Arbitre;

class ArbitresTableSeeder extends Seeder {


	public function run()
	{

		$entrees = [
		//prénom,	nom				 region, #,  association, 	telephone, 		sexe
		["Benoit"	, "Desrosiers"	, 1,	 1,		"AQSFR",	"819-578-6489",		0],
		["Guy"	, "Bernard"	, 2,	 1,		"OSQ",			"450-715-6915",		0],
		["Jonathan"	, "Gareau"		, 3,	 1,		"ASSQ",			"514-763-2485",		0],
		["Stéphane", "Janvier"	, 4,	 2,		"ASAQ",			"450-571-1203",		0],

		foreach($entrees as $entree) {
			$arbitre = new Arbitre;
			$arbitre->prenom = $entree[0];
			$arbitre->nom = $entree[1];
			$arbitre->region_id = $entree[2];
			$arbitre->numero_accreditation = $entree[3];
			$arbitre->association = $entree[4];
			$arbitre->numero_telephone = '819-123-4567';
			$arbitre->sexe = rand(0,1);
			$date_temp = new DateTime;
	        $date_temp->setDate(1994, 1, 1);
	        $arbitre->date_naissance=$date_temp;
			
			$arbitre->save();
		}
	}
}