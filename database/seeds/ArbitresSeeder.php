<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Arbitre;
use App\Models\Epreuve;
use App\Models\Region;

class ArbitresTableSeeder extends Seeder {

	/**
	 * Création d'arbitres dans la base de données
	 */
	public function run()
	{
		DB::table('arbitre_epreuve')->delete();
		DB::table("arbitre_telephone")->delete();
		DB::table("arbitres")->delete();
		
		$epreuves=Epreuve::all();
		$entrees = [
			//prénom	  nom			numéro      association 	  sexe
			["Benoit" ,   "Desrosiers"	,  "1",		"AQSFR",			0],
			["Guy"	, 	  "Bernard"	,      "1",		"OSQ",				0],
			["Jonathan"	, "Gareau" ,  	   "1",		"ASSQ",				0],
			["Stéphane",  "Janvier" ,	   "2",		"ASAQ",				0]
		];

		$regions = Region::all();

		foreach($entrees as $entree) {
			$arbitre = new Arbitre;
			$arbitre->prenom = $entree[0];
			$arbitre->nom = $entree[1];
			$arbitre->region_id = $regions->random()->id;
			$arbitre->numero_accreditation = $entree[2];
			$arbitre->association = $entree[3];
			$arbitre->sexe = $entree[4];
			$date_temp = new DateTime;
			$date_temp->setDate(1994, 1, 1);
			$arbitre->date_naissance=$date_temp;
			$arbitre->save();
			for($j=0;$j<rand(1,4);$j++) {
				$epreuves->random()->arbitres()->attach($arbitre->id);
			}
		}
	}
}