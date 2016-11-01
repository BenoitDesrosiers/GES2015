<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Benevole;

class BenevolesTableSeeder extends Seeder {


	public function run()
	{
        //nom, prenom, adresse, numTel, numCell, courriel, disponibilite, accreditation, verification
        $infos = [
		["Desrosiers", "Jérémi", "123 rue Duniquab, Drummondville, J2C 1A1", "8194771234", "8198181234", "masculin", "j.desrosiers@evenement-sportif.ca", "000A123", "À faire" , "2016-10-10"],
		["Pedneault", "Eric", "124 rue Petinichon, Drummondville, J2C 1A2", "8194772345", "8198182345", "masculin",  "e.pedneault@evenement-sportif.ca", "000B123", "En attente", "2016-10-10"],
		["Girardin", "Simon", "125 rue Sainte-Paire, Drummondville, J2C 1A3", "8194773456", "8198183456", "masculin",  "s.girardin@evenement-sportif.ca", "000C123", "Fait", "2016-10-10"],
        ["Lehoux", "Alexandre", "126 boul. Delamarde, Drummondville, J2C 1A4", "8194774567", "8198184567", "masculin",  "a.lehoux@evenement-sportif.ca", "000D123", "Fait", "2016-10-10"],
        ["Dubé", "Sarah", "127 rue Dunimportequoi, Drummondville, J2C 1A5", "8194775678", "8198185678", "feminin", "s.dube@evenement-sportif.ca", "000E123", "Fait", "2016-10-10"],
		];

        DB::table('benevoles')->delete();
        foreach($infos as $info) {
		    $benevole = new Benevole();
		    $benevole->nom = $info[0];
		    $benevole->prenom = $info[1];
		    $benevole->adresse = $info[2];
		    $benevole->numTel = $info[3];
		    $benevole->numCell = $info[4];
		    $benevole->sexe = $info[5];
		    $benevole->courriel = $info[6];
		    $benevole->accreditation = $info[7];
		    $benevole->verification = $info[8];
		    $benevole->naissance= new DateTime;
			$benevole->save();		
        }
	}
}
