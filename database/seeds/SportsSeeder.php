<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Sport;

class SportsTableSeeder extends Seeder {


	public function run()
	{
		DB::table('sports')->delete();

		$sports = [
		//nom, tournoi (1=oui, 0=non)
		["Badminton","1"],
		["Basketball en fauteuil roulant","1"],
		["Boccia","1" ],
		["Boxe olympique","1"],
		["Curling féminin","1" ],
		["Curling masculin","1" ],
		["Escrime","1" ],
		["Gymnastique","0" ],
		["Haltérophilie","0" ],
		["Hockey féminin","1" ],
		["Hockey masculin","1" ],
		["Judo","1" ],
		["Karaté","1" ],
		["Nage Synchronisée","0" ],
		["Patinage artistique","0" ],
		["Patinage de vitesse","1" ],
		["Plongeon","0" ],
		["Ski alpin","0" ],
		["Ski de fond","0" ],
		["Taekwondo","1" ],
		["Tennis de table","1" ],
		["Trampoline","0" ]
		];

		foreach($sports as $sport) {
			Sport::create(array('nom'=>$sport[0],'tournoi'=>$sport[1],'saison'=>"h"));
		}
	}
}