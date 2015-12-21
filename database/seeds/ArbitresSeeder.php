<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Arbitre;
use App\Models\Epreuve;

class ArbitresTableSeeder extends Seeder {


	public function run()
	{

		DB::table('arbitre_epreuve')->delete();
		DB::table("arbitres")->delete();
		
		$regions = ["ABT","BOU","CAP","CDQ","CHA","CTN","EDQ","EST","LSL","LAN","LAU","LAV","MAU","MON","OUT","RIY","RIS","SLJ","SUO" ];
		$noms = ["Arbitre 1","Arbitre 2","Arbitre 3","Arbitre 4","Arbitre 5","Arbitre 6","Arbitre 7","Arbitre 8","Arbitre 9","Arbitre 10"];
		$numeros_accreditation = ["1357059", "2584612", "1473546", "0145678", "2316580", "1567308"];
		$associations = ["assoc0","assoc1","assoc2","assoc3","assoc4","assoc5"];
		$epreuves=Epreuve::all();

		for($i=0;$i<10;$i++) {
			$arbitre = new Arbitre;
			$arbitre->nom = "EnChef";
			$arbitre->prenom = $noms[$i];
			$regionid=DB::table('regions')->where('nom_court',$regions[$i])->pluck('id');
			$arbitre->region_id = $regionid;
			$arbitre->numero_accreditation = $numeros_accreditation[rand(0,5)];
			$arbitre->association = $associations[$i%2];
			$arbitre->numero_telephone = '819-123-4567';
			$arbitre->sexe = rand(0,1);
			$date_temp = new DateTime;
	        $date_temp->setDate(1994, 1, 1);
	        $arbitre->date_naissance=$date_temp;
			
			$arbitre->save();
		
			for($j=0;$j<rand(1,4);$j++) { 
				$epreuves->random()->arbitres()->attach($arbitre->id);
			}
		}
	}
}