<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\ArbitreCourriel;
use App\Models\Arbitre;

class ArbitreCourrielTableSeeder extends Seeder {

	/**
	 * Création d'arbitres dans la base de données
	 */
	public function run()
	{
		DB::table("arbitre_courriel")->delete();
		
		$entrees = [
			//arbitre_id			courriel      	description
			[0,					"",							""],
			[1,					"guy@hotmail.com",			""],
			[2,					"joe@gmail.com",			""],
			[3,					"steph@email.com",			""]
		];

		$arbitres = Arbitre::all();
		
		foreach($entrees as $entree) {
			$arbitreCourriel = new ArbitreCourriel();
			
			//arbitre_id correspond à la position de l'arbitre voulu dans $arbitres[]
			$arbitreCourriel->arbitre_id = $arbitres[$entree[0]]->id;
			
			$arbitreCourriel->courriel = $entree[1];
			$arbitreCourriel->description = $entree[2];
			$arbitreCourriel->save();
		}
	}
}