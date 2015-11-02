<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Benevole;

class BenevolesTableSeeder extends Seeder {


	public function run()
	{
		DB::table('benevoles')->delete();

		$benevoles = [
		//nom, prenom, adresse, numTel, numCell, courriel, disponibilite, accreditation, verification
		["Desrosiers", "Jérémi", "123 rue Dupuis, Drummondville, J2C 1A1", "8191234567", "8198181234", "j.desrosiers@evenementsportif.ca", "En tout temps", "00000A1", "À faire"],
		["Pedneault", "Eric", "222 rue du Cégep, Drummondville, J2B 1B3", "8190001234", "8198167770", "e.pedneault@evenementsportif.ca", "Le matin seulement", "012003A1", "En attente"],
		["Girardin", "Simon", "242 rue de Lamarre, Drummondville, J2C 1A8", "8190341234", "8198179870", "s.girardin@evenementsportif.ca", "En tout temps sauf le jeudi!", "012023A1", "Fait" ],
        ["Lehoux", "Alexandre", "1443 boul. Lemire, Drummondville, J2B 3G7", "8195678934", "8198111110", "a.lehoux@evenementsportif.ca", "Tous les midis", "BP2003A3", "Fait"],
        ["Bear", "John", "20 boul. Delamarde, Drummondville, J2B 4F5", "8195338934", "8198111234", "j.bear@evenementsportif.ca", "Tous les soirs", "DDD003A3", "Fait"]
		];

		foreach($benevoles as $benevole) {
			DB::table('benevoles')->insert(array('nom'=>$benevole[0],'prenom'=>$benevole[1],'adresse'=>$benevole[2],'numTel'=>$benevole[3],'numCell'=>$benevole[4],'courriel'=>$benevole[5],'disponibilite'=>$benevole[6],'accreditation'=>$benevole[7],'verification'=>$benevole[8]));
     		
        }
	}
}
