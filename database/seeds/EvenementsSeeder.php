<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Evenement;

class EvenementsTableSeeder extends Seeder {


	public function run()
	{
		DB::table('evenement_participant')->delete();		
		
		//nom, prenom, numero, region court (à mapper), equipe
		$participants=DB::table('participants')->pluck('id');
		$evenements=DB::table('evenements');
		for($i=0;$i<10;$i++) {
			for($j=0;$j<rand(1,2);$j++) { //TODO: refaire avec un attach()
				DB::table('evenement_participant')->insert(array('participant_id' => $participants[$i], 'evenement_id' => rand($evenements->min('id'),$evenements->max('id'))));
			}
		}
	}
}