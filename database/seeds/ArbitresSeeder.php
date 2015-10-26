<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ArbitresSeeder extends Seeder {


	public function run()
	{
		DB::table('arbitres')->delete();

		$regions = ["ABT","BOU","CAP","CDQ","CHA","CTN","EDQ","EST","LSL","LAN","LAU","LAV","MAU","MON","OUT","RIY","RIS","SLJ","SUO" ];
		$noms = ["Machin","Machin chouette","Chose","L'autre","Lui-là","Machine","Lui","L'autre-là","Là"];
		$numero_accreditation = ["1357059", "2584612", "1473546", "0145678", "2316580", "1567308"];
		
		//nom, prenom, region, numero_accreditation, association et numero_telephone
		for($i=0;$i<10;$i++) {
			
			$regionid=DB::table('regions')->where('nom_court',$regions[rand(0,18)])->pluck('id');
			DB::table('arbitres')->insert(array('nom' => $noms[rand(0,8)], 
												'prenom' => $noms[rand(0,8)],
												'region_id'=>$regionid, 
												'numero_accreditation'=>$numero_accreditation[$i],
												'association'=>$noms[rand(0,5)],
												'numero_telephone'=>"1234567890"));
			
		}
	}
}