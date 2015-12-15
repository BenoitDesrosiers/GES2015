<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Arbitre;
use App\Models\Region;

class ArbitresTableSeeder extends Seeder {

	/**
	 * Création d'arbitres dans la base de données
	 */
	public function run()
	{

		$entrees = [
			//prénom	  nom			numéro      association 	telephone 		  sexe
			["Benoit" ,   "Desrosiers"	,  "1",		"AQSFR",		"819-578-6489",		0],
			["Guy"	, 	  "Bernard"	,      "1",		"OSQ",			"450-715-6915",		0],
			["Jonathan"	, "Gareau" ,  	   "1",		"ASSQ",			"514-763-2485",		0],
			["Stéphane",  "Janvier" ,	   "2",		"ASAQ",			"450-571-1203",		0]
		];

		$regions = Region::all();

		foreach($entrees as $entree) {
			$arbitre = new Arbitre;
			$arbitre->prenom = $entree[0];
			$arbitre->nom = $entree[1];
			$arbitre->region_id = $regions->random()->id;
			$arbitre->numero_accreditation = $entree[2];
			$arbitre->association = $entree[3];
			$arbitre->numero_telephone = $entree[4];
			$arbitre->sexe = $entree[5];
			if ($arbitre->save()) {

			} else {
				echo("save non réussi");
			}
		}
	}
}