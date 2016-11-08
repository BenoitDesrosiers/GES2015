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
			
			//Ce insert la est fucked up pcq ca l'arbitre dans lequel on insert est basé sur sa position dans le array
			//Ça fait qu'il faut que le seed soit 1 plus petit que la valeur réellement désirée
			$arbitreCourriel->arbitre_id = $arbitres[$entree[0]]->id;
			//$participant->region_id = $regions[$entree[3]]->id;
			
			$arbitreCourriel->courriel = $entree[1];
			$arbitreCourriel->description = $entree[2];
			$arbitreCourriel->save();
		}
	}
}