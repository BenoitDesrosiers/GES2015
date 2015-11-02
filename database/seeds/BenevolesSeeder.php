<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BenevolesTableSeeder extends Seeder {


	public function run()
	{
		DB::table('benevoles')->delete();

		$benevoles = [
		//prenom, nom, adresse, numTel, numCell, courriel, disponibilite, accreditation, verification
		["Jérémi","Desrosiers", "123 rue Dupuis, Drummondville, J2C 1A1", "8191234567", "8198181234", "En tout temps", "00000A1", "À faire"],
		["Eric","Pedneault", "222 rue du Cégep, Drummondville, J2B 1B3", "8190001234", "8198167770", "Le matin seulement", "012003A1", "En attente"],
		["Simon","Girardin", "242 rue de Lamarre, Drummondville, J2C 1A8", "8190341234", "8198179870", "En tout temps sauf le jeudi!", "012023A1", "Fait" ],
        ["Alexandre", "Lehoux", "1443 boul. Lemire, Drummondville, J2B 3G7", "8195678934", "8198111110", "Tous les midis", "BP2003A3", "Fait"],
		];
    /*
		foreach($benevoles as $benevole) {
			Benevole::create(array('prenom'=>$benevole[0],'nom'=>$benevole[1],...));
     */		
        }
	}
}
