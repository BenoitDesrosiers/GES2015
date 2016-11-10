<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Epreuve;

class EpreuvesTableSeeder extends Seeder {


	public function run()
	{
		DB::table('epreuves')->delete();
		DB::table('resultats_tournois')->delete();
		
		//épreuves et resultats associées au sport Badminton
		$sports= [
			['Badminton',
				[
				    //nom, description
					[ "Simple Féminin","" ],
					[ "Simple Masculin","" ],
					[ "Double Féminin","" ],
					[ "Double Masculin","" ],
					[ "Épreuve par équipe","" ],
				]
			],
			['Hockey masculin',
				[
                    //nom, description
                    [ "Division A","" ],
                    [ "Division B","" ],
                    [ "Division C","" ],
                    [ "Division D","" ],
                    [ "Division E","" ],
				]
			],
		];
		
		foreach($sports as $sport) {
			$sportid=DB::table('sports')->where('nom',$sport[0])->pluck('id')->first();
			foreach($sport[1] as $epreuve) {
				Epreuve::create(array('nom' => $epreuve[0], 'description'=>$epreuve[1],'sport_id'=>$sportid));
			};
		};
		}
}