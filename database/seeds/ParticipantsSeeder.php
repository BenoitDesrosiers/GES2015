<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ParticipantsTableSeeder extends Seeder {


	public function run()
	{
		DB::table('participants')->delete();

		$regions = ["ABT","BOU","CAP","CDQ","CHA","CTN","EDQ","EST","LSL","LAN","LAU","LAV","MAU","MON","OUT","RIY","RIS","SLJ","SUO" ];
		$noms = ["Machin","Machin chouette","Chose","L'autre","Lui-là","Machine","Lui","L'autre-là","Là"];
		$sports=DB::table('sports');
		
		//nom, prenom, numero, region court (à mapper), equipe
		for($i=0;$i<10;$i++) {
			
			$regionid=DB::table('regions')->where('nom_court',$regions[rand(0,18)])->pluck('id');
			DB::table('participants')->insert(array('nom' => $noms[rand(0,8)], 'prenom' => $noms[rand(0,8)],
														'numero'=>$i,'region_id'=>$regionid, 'equipe'=>rand(0,1)));
			for($j=0;$j<rand(1,4);$j++) {
				DB::table('participant_sport')->insert(array('participant_id' => DB::table('participants')->max('id'), 'sport_id' => rand($sports->min('id'),$sports->max('id'))));
			}
		}
	}
}