<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EpreuvesTableSeeder extends Seeder {


	public function run()
	{
		DB::table('epreuves')->delete();
		DB::table('resultats_tournois')->delete();
		
		//épreuves et resultats associées au sport Badminton
		$sports= [
			['Badminton',
				[
				//nom, description, [[nom, finale, division, section]]
					[ "Simple Féminin","", 
						[ 
						[ "Demi-Finale", 1, 0, ""], 
						[ "Finale", 1, 0, ""] 
						] 
					],
					[ "Simple Masculin","", [ ["Finale", 1, 0, ""] ] ],
					[ "Double Féminin","", [ ["Finale", 1, 0, ""] ] ],
					[ "Double Masculin","", [ ["Finale", 1, 0, ""] ] ],
					[ "Épreuve par équipe","", [ ["Finale", 1, 0, ""] ] ],
				]
			],
			['Hockey masculin',
				[
				//nom, description, [[nom, finale, division, section]]
				[ "Division A","",
					[
						[ "Finale", 1, 0, ""]
					]
				],
				[ "Division B","", [ ["Finale", 1, 0, ""] ] ],
				[ "Division C","", [ ["Finale", 1, 0, ""] ] ],
				[ "Division D","", [ ["Finale", 1, 0, ""] ] ],
				[ "Division E","", [ ["Finale", 1, 0, ""] ] ],
				]
			],
		];
		
		foreach($sports as $sport) {
			$sportid=DB::table('sports')->where('nom',$sport[0])->pluck('id');
			foreach($sport[1] as $epreuve) {
				$epreuvedb = Epreuve::create(array('nom' => $epreuve[0], 'description'=>$epreuve[1],'sport_id'=>$sportid));
				foreach($epreuve[2] as $resultat) {
					DB::table('evenements')->insert(
					array(
					'nom'=>$resultat[0],
					'epreuve_id'=>$epreuvedb->id,
					'finale'=>$resultat[1],
					'division'=>$resultat[2],
					'section'=>$resultat[3]
					)
					);
				};
		
			};
		};
		}
}