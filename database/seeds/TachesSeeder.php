<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Taches;

class TachesTableSeeder extends Seeder {


	public function run()
	{
		

		$items = [
		//Nom, Description
		["Balais","Préposé au ménage."],
		["Sécurité","Fait la sécurité dans les différentes zones de sports."],
		["Accompagnateur","Un accompagnateur accompagne un athlète pour qu'il ne soit pas seul."]
		];

		DB::table('taches')->delete();
		foreach($items as $item) {
			$taches = new Taches();
		    $taches->nom = $item[0];
		    $taches->description = $item[1];
            $taches->save();	
		}
	}
}