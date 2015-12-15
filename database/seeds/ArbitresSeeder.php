<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Arbitre;

class ArbitresTableSeeder extends Seeder {


	public function run()
	{

		$regions = ["ABT","BOU","CAP","CDQ","CHA","CTN","EDQ","EST","LSL","LAN","LAU","LAV","MAU","MON","OUT","RIY","RIS","SLJ","SUO" ];
		$noms = ["Machin","Machin chouette","Chose","L'autre","Lui-là","Machine","Lui","L'autre-là","Là"];
		$numeros_accreditation = ["1357059", "2584612", "1473546", "0145678", "2316580", "1567308"];
		$epreuves=DB::table('epreuves');

		for($i=0;$i<10;$i++) {
			$arbitre = new Arbitre;
			$arbitre->nom = $noms[rand(0,8)];
			$arbitre->prenom = $noms[rand(0,8)];
			$regionid=DB::table('regions')->where('nom_court',$regions[rand(0,18)])->pluck('id');
			$arbitre->region_id = $regionid;
			$arbitre->numero_accreditation = $numeros_accreditation[rand(0,5)];
			$arbitre->association = $noms[rand(0,8)];
			$arbitre->numero_telephone = '819-123-4567';
			$arbitre->sexe = rand(0,1);
			$date_temp = new DateTime;
	        $date_temp->setDate(1994, 1, 1);
	        $arbitre->date_naissance=$date_temp;
			
			$arbitre->save();
		
			for($j=0;$j<rand(1,4);$j++) {
				DB::table('arbitres_epreuves')->insert(array('arbitre_id' => DB::table('arbitres')->max('id'), 'epreuve_id' => rand($epreuves->min('id'),$epreuves->max('id'))));
			}
		}
	}
}