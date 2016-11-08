<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\ArbitreTelephone;
use App\Models\Arbitre;

class ArbitreTelephoneTableSeeder extends Seeder {

	/**
	 * Création d'arbitres dans la base de données
	 */
	public function run()
	{
		DB::table("arbitre_telephone")->delete();
		
		$entrees = [
			//arbitre_id			numero_telephone      	description
			[0,					"819-578-6489",			""],
			[1,					"450-715-6915",			""],
			[2,					"514-763-2485",			""],
			[3,					"450-571-1203",			""]
		];

		$arbitres = Arbitre::all();
		
		foreach($entrees as $entree) {
			$arbitreTelephone = new ArbitreTelephone();
			
			//Ce insert la est fucked up pcq ca l'arbitre dans lequel on insert est basé sur sa position dans le array
			//Ça fait qu'il faut que le seed soit 1 plus petit que la valeur réellement désirée
			$arbitreTelephone->arbitre_id = $arbitres[$entree[0]]->id;
			//$participant->region_id = $regions[$entree[3]]->id;
			
			$arbitreTelephone->numero_telephone = $entree[1];
			$arbitreTelephone->description = $entree[2];
			$arbitreTelephone->save();
		}
	}
}